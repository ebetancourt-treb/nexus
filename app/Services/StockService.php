<?php

namespace App\Services;

use App\Models\Movement;
use App\Models\MovementLine;
use App\Models\StockLevel;
use Illuminate\Support\Facades\DB;

class StockService
{
    /**
     * Confirma un movimiento y actualiza stock_levels.
     * Se ejecuta dentro de transacción.
     */
    public function confirmMovement(Movement $movement): void
    {
        if ($movement->status !== 'draft') {
            throw new \RuntimeException('Solo se pueden confirmar movimientos en estado borrador.');
        }

        DB::transaction(function () use ($movement) {
            foreach ($movement->lines as $line) {
                $this->applyLine($movement, $line);
            }

            $movement->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);
        });
    }

    /**
     * Aplica una línea de movimiento al stock.
     */
    private function applyLine(Movement $movement, MovementLine $line): void
    {
        $stockLevel = StockLevel::firstOrCreate(
            [
                'tenant_id' => $movement->tenant_id,
                'product_id' => $line->product_id,
                'warehouse_id' => $movement->warehouse_id,
                'location_id' => $line->location_id,
                'lot_id' => $line->lot_id,
            ],
            [
                'qty_on_hand' => 0,
                'qty_reserved' => 0,
                'qty_available' => 0,
                'status' => 'available',
            ]
        );

        // Entradas suman, salidas restan
        if ($this->isEntry($movement->type)) {
            $stockLevel->qty_on_hand += abs($line->quantity);
        } else {
            $stockLevel->qty_on_hand -= abs($line->quantity);

            if ($stockLevel->qty_on_hand < 0) {
                throw new \RuntimeException(
                    "Stock insuficiente para {$line->product->name} en {$movement->warehouse->name}. " .
                    "Disponible: {$stockLevel->qty_available}, solicitado: " . abs($line->quantity)
                );
            }
        }

        $stockLevel->recalculate();
        $stockLevel->save();
    }

    /**
     * Determina si un tipo de movimiento es entrada o salida.
     */
    public function isEntry(string $type): bool
    {
        return in_array($type, ['receiving', 'transfer_in', 'return']);
    }

    /**
     * Verifica si hay stock suficiente para una línea de salida.
     */
    public function hasEnoughStock(int $tenantId, int $productId, int $warehouseId, float $quantity, ?int $lotId = null): bool
    {
        $query = StockLevel::where('tenant_id', $tenantId)
            ->where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->where('status', 'available');

        if ($lotId) {
            $query->where('lot_id', $lotId);
        }

        return $query->sum('qty_available') >= $quantity;
    }
}
