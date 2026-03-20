<?php

namespace App\Http\Middleware;

use App\Models\Warehouse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetActiveWarehouse
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si no hay almacén en sesión, setear el default del tenant
        if (! session()->has('active_warehouse_id') && $request->user()?->tenant_id) {
            $defaultWarehouse = Warehouse::where('is_default', true)->first()
                ?? Warehouse::first();

            if ($defaultWarehouse) {
                session(['active_warehouse_id' => $defaultWarehouse->id]);
            }
        }

        return $next($request);
    }
}
