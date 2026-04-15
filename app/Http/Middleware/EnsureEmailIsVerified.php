<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && !$user->isSuperAdmin() && is_null($user->email_verified_at)) {
            // Permitir rutas de verificación y logout
            $allowed = [
                'verification.notice',
                'verification.send',
                'verification.verify',
                'logout',
            ];

            if (!$request->routeIs($allowed)) {
                return redirect()->route('verification.notice');
            }
        }

        return $next($request);
    }
}
