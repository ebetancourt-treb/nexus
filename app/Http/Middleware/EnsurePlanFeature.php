<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePlanFeature
{
    /**
     * Uso en rutas: ->middleware('plan_feature:lots.enabled')
     */
    public function handle(Request $request, Closure $next, string $featureKey): Response
    {
        $user = $request->user();

        if (! $user || ! $user->tenant_id) {
            abort(403, 'No perteneces a ninguna organización.');
        }

        $tenant = $user->tenant;

        if (! $tenant || ! $tenant->is_active) {
            abort(403, 'Tu organización está desactivada.');
        }

        $subscription = $tenant->activeSubscription;

        if (! $subscription) {
            abort(403, 'No tienes una suscripción activa.');
        }

        $hasFeature = $subscription->plan
            ->features()
            ->where('feature_key', $featureKey)
            ->where('enabled', true)
            ->exists();

        if (! $hasFeature) {
            abort(403, 'Tu plan no incluye esta funcionalidad. Actualiza tu plan para acceder.');
        }

        return $next($request);
    }
}
