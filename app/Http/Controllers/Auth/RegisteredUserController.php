<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\EmailVerificationCode;
use App\Services\TenantService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request, TenantService $tenantService): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'company_name' => ['required', 'string', 'max:255'],
            'plan' => ['nullable', 'string', 'in:starter,profesional,enterprise'],
        ]);

        $user = $tenantService->createTenantWithTrial([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'company_name' => $request->company_name,
            'plan' => $request->input('plan', 'profesional'),
        ]);

        // NO verificar email automáticamente — enviar código OTP
        Auth::login($user);

        // Generar y enviar código
        $verification = EmailVerificationCode::generateFor($user);

        Mail::to($user->email)->send(new VerificationCodeMail(
            code: $verification->code,
            userName: $user->name,
        ));

        return redirect()->route('verification.notice');
    }
}
