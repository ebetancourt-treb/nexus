<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OdooService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class OdooFlowController extends Controller
{
    protected $odoo;

    public function __construct(OdooService $odoo)
    {
        $this->odoo = $odoo;
    }

    public function index(): View
    {
        $productos = [];
        
        Log::info('[Odoo Flow] Iniciando consulta de catálogo a Odoo...');

        try {
            $productos = $this->odoo->executeKw(
                'product.product', 
                'search_read',
                [[]], 
                ['fields' => ['id', 'name', 'default_code', 'qty_available'], 'limit' => 50]
            );
            
            Log::info('[Odoo Flow] Catálogo obtenido exitosamente. Total de productos: ' . count($productos));

        } catch (\Exception $e) {
            Log::error('[Odoo Flow] Fallo al cargar catálogo: ' . $e->getMessage());
        }

        return view('tenant.operations.odoo_flow', compact('productos'));
    }

    public function process(Request $request): RedirectResponse
    {
        $request->validate([
            'odoo_product_id' => 'required|integer',
            'operation_type' => 'required|in:in,out',
            'quantity' => 'required|numeric|min:1',
            'ubicacion_piso' => 'required|string|max:255',
        ]);

        Log::info("[Odoo Flow] Intentando crear movimiento. Tipo: {$request->operation_type}, Producto ID: {$request->odoo_product_id}, Cantidad: {$request->quantity}");

        try {
            // 1. BUSCAR LOS IDs DINÁMICAMENTE EN LA BASE DE DATOS DEL CLIENTE
            $tipoOperacion = $request->operation_type === 'in' ? 'incoming' : 'outgoing';
            
            $pickingType = $this->odoo->executeKw('stock.picking.type', 'search_read', [
                [ ['code', '=', $tipoOperacion] ] // Buscamos la regla de "Recepción" o "Entrega"
            ], [
                'fields' => ['id', 'default_location_src_id', 'default_location_dest_id'],
                'limit' => 1
            ]);

            if (empty($pickingType)) {
                throw new \Exception("No se encontraron las rutas de almacén en Odoo para la operación: " . $tipoOperacion);
            }

            // Odoo devuelve los campos relacionales como un arreglo: [ID, "Nombre"]
            // Nosotros extraemos la posición [0] que es el puro ID numérico.
            $pickingTypeId = $pickingType[0]['id'];
            $locationId = $pickingType[0]['default_location_src_id'][0];
            $locationDestId = $pickingType[0]['default_location_dest_id'][0];

            Log::info("[Odoo Flow] IDs dinámicos obtenidos: PickingType={$pickingTypeId}, Src={$locationId}, Dest={$locationDestId}");

            // 2. Crear Cabecera con los IDs reales
            $pickingId = $this->odoo->executeKw('stock.picking', 'create', [[
                'picking_type_id' => $pickingTypeId,
                'location_id' => $locationId,
                'location_dest_id' => $locationDestId,
                'origin' => 'Treblum WMS - ' . $request->ubicacion_piso, 
            ]]);

            Log::info("[Odoo Flow] Documento base creado con ID: {$pickingId}. Agregando líneas de detalle...");

            // 3. Crear Detalle
            $this->odoo->executeKw('stock.move', 'create', [[
                'picking_id' => $pickingId,
                'product_id' => (int) $request->odoo_product_id,
                'product_uom_qty' => $request->quantity, // La cantidad solicitada (Demanda)
                'location_id' => $locationId,
                'location_dest_id' => $locationDestId,
            ]]);

            $tipoStr = $request->operation_type === 'in' ? 'Recepción' : 'Entrega';
            
            Log::info("[Odoo Flow] Éxito. Operación de {$tipoStr} concluida en ERP.");

            return back()->with('success', "¡Documento de {$tipoStr} creado en Odoo! Revisa el módulo de Inventario. ID: {$pickingId}");

        } catch (\Exception $e) {
            Log::error('[Odoo Flow] Error crítico al insertar en Odoo: ' . $e->getMessage());
            return back()->withErrors(['odoo' => 'Error al comunicar con Odoo: ' . $e->getMessage()]);
        }
    }

    public function pending(): View
    {
        $pickings = [];
        
        Log::info('[Odoo Flow] Consultando movimientos pendientes (Borrador, Espera, Preparado)...');

        try {
            $pickings = $this->odoo->executeKw(
                'stock.picking',
                'search_read',
                [
                    [['state', 'in', ['draft', 'confirmed', 'assigned']]]
                ],
                [
                    'fields' => ['id', 'name', 'state', 'origin', 'scheduled_date'],
                    'limit' => 30,
                    'order' => 'id desc' // Mostrar los más recientes primero
                ]
            );
        } catch (\Exception $e) {
            Log::error('[Odoo Flow] Error leyendo pendientes: ' . $e->getMessage());
        }

        return view('tenant.operations.odoo_pending', compact('pickings'));
    }

    /**
     * Valida el documento en Odoo tras confirmar la ubicación de piso local
     */
    public function validatePicking(Request $request): RedirectResponse
    {
        $request->validate([
            'picking_id' => 'required|integer',
            'ubicacion_piso' => 'required|string|max:255',
        ]);

        $pickingId = (int) $request->picking_id;
        $ubicacion = $request->ubicacion_piso;

        Log::info("[Odoo Flow] Validando picking ID: {$pickingId}. Ubicación de piso: {$ubicacion}");

        try {
            // 1. Odoo exige que el documento pase de "Borrador" a "Preparado" antes de validar
            $this->odoo->executeKw('stock.picking', 'action_confirm', [[$pickingId]]);
            $this->odoo->executeKw('stock.picking', 'action_assign', [[$pickingId]]);

            // 2. Presionamos el botón "Validar" inicial
            $respuestaValidacion = $this->odoo->executeKw('stock.picking', 'button_validate', [[$pickingId]]);

            // 3. LA MAGIA: Verificamos si Odoo nos lanzó la ventana de "Transferencia Inmediata"
            if (is_array($respuestaValidacion) && isset($respuestaValidacion['res_model']) && $respuestaValidacion['res_model'] === 'stock.immediate.transfer') {
                
                Log::info("[Odoo Flow] Odoo solicita confirmar el 100% de las piezas. Procesando ventana virtual...");

                // A) Creamos el registro temporal de la ventana (Wizard) en la base de Odoo
                $wizardId = $this->odoo->executeKw('stock.immediate.transfer', 'create', [[
                    // El [6, 0, [IDs]] es el comando oficial de Odoo para enlazar relaciones (Many2Many)
                    'pick_ids' => [[6, 0, [$pickingId]]] 
                ]]);

                // B) Le damos clic al botón "Aplicar" (process) de esa ventana
                $this->odoo->executeKw('stock.immediate.transfer', 'process', [[$wizardId]]);
            }

            Log::info("[Odoo Flow] ¡Operación validada exitosamente!");

            return back()->with('success', "¡Sincronización exitosa! La transferencia inmediata se aplicó y el inventario en Odoo ya fue actualizado. Ubicación: {$ubicacion}.");

        } catch (\Exception $e) {
            Log::error('[Odoo Flow] Error crítico al validar en Odoo: ' . $e->getMessage());
            return back()->withErrors(['odoo' => 'No se pudo completar la validación: ' . $e->getMessage()]);
        }
    }
}