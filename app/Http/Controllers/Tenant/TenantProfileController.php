<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class TenantProfileController extends Controller
{
    public function edit(): View
    {
        $user = auth()->user();
        $tenant = $user->tenant;
        $subscription = $tenant?->activeSubscription;
        $plan = $subscription?->plan;

        return view('tenant.profile.edit', compact('user', 'tenant', 'subscription', 'plan'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
        ]);

        $request->user()->update($request->only('name', 'email'));

        if ($request->user()->wasChanged('email')) {
            $request->user()->email_verified_at = null;
            $request->user()->save();
        }

        return back()->with('success', 'Información actualizada correctamente.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ], [
            'current_password.current_password' => 'La contraseña actual no es correcta.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }

    public function updateCompany(Request $request): RedirectResponse
    {
        $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'rfc' => ['nullable', 'string', 'max:13'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $tenant = auth()->user()->tenant;
        $tenant->update([
            'name' => $request->company_name,
            'rfc' => $request->rfc,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Información de la empresa actualizada.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ], [
            'password.current_password' => 'La contraseña no es correcta.',
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
