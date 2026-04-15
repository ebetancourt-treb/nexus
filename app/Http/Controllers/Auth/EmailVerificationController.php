<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\EmailVerificationCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    /**
     * Mostrar la pantalla de verificación de código.
     */
    public function show(): View|RedirectResponse
    {
        $user = auth()->user();

        // Si ya está verificado, redirigir al dashboard
        if ($user->email_verified_at) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-email-code');
    }

    /**
     * Enviar (o reenviar) el código de verificación por email.
     */
    public function send(): RedirectResponse
    {
        $user = auth()->user();

        if ($user->email_verified_at) {
            return redirect()->route('dashboard');
        }

        // Rate limit: no enviar si hay un código válido creado hace menos de 60 segundos
        $recentCode = EmailVerificationCode::where('user_id', $user->id)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->where('created_at', '>', now()->subSeconds(60))
            ->first();

        if ($recentCode) {
            return back()->with('info', 'Ya se envió un código hace menos de 1 minuto. Revisa tu correo.');
        }

        $verification = EmailVerificationCode::generateFor($user);

        Mail::to($user->email)->send(new VerificationCodeMail(
            code: $verification->code,
            userName: $user->name,
        ));

        return back()->with('success', 'Código enviado a ' . $user->email);
    }

    /**
     * Verificar el código ingresado.
     */
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ], [
            'code.required' => 'Ingresa el código de 6 dígitos.',
            'code.size' => 'El código debe ser de 6 dígitos.',
        ]);

        $user = auth()->user();

        if ($user->email_verified_at) {
            return redirect()->route('dashboard');
        }

        $verification = EmailVerificationCode::where('user_id', $user->id)
            ->where('code', $request->code)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            return back()->withErrors(['code' => 'Código incorrecto o expirado. Solicita uno nuevo.']);
        }

        // Marcar código como usado
        $verification->update(['used' => true]);

        // Verificar email del usuario
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('dashboard')
            ->with('success', '¡Correo verificado! Bienvenido a BlumOps.');
    }
}
