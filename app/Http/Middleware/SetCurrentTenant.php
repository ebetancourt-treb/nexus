<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\PermissionRegistrar;
use Symfony\Component\HttpFoundation\Response;

class SetCurrentTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->tenant_id) {
            // Bindear tenant_id al service container (lo usa BelongsToTenant trait)
            app()->instance('current_tenant_id', $user->tenant_id);

            // Configurar Spatie Permission para scopear por tenant (team)
            app(PermissionRegistrar::class)->setPermissionsTeamId($user->tenant_id);
        }

        return $next($request);
    }
}
