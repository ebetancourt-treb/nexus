<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    /**
     * Busca productos por barcode, SKU o nombre.
     * Se usa desde JS en los formularios de movimientos.
     * GET /app/api/products/search?q=7501234
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q', '');

        if (strlen($query) < 1) {
            return response()->json([]);
        }

        $products = Product::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('barcode', $query)           // Match exacto por barcode (scanner)
                  ->orWhere('sku', $query)              // Match exacto por SKU
                  ->orWhere('name', 'like', "%{$query}%")  // Búsqueda parcial por nombre
                  ->orWhere('sku', 'like', "%{$query}%")   // Búsqueda parcial por SKU
                  ->orWhere('barcode', 'like', "%{$query}%"); // Búsqueda parcial por barcode
            })
            ->orderByRaw("CASE WHEN barcode = ? THEN 0 WHEN sku = ? THEN 1 ELSE 2 END", [$query, $query])
            ->take(10)
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'sku' => $p->sku,
                    'barcode' => $p->barcode,
                    'unit_of_measure' => $p->unit_of_measure,
                    'cost_price' => $p->cost_price,
                    'track_lots' => $p->track_lots,
                    'track_serials' => $p->track_serials,
                ];
            });

        return response()->json($products);
    }
}
