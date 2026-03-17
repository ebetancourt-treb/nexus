<x-guest-layout>
    {{-- Session status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="blum-label">
                Correo Electrónico
            </label>
            <div class="relative">
                <span class="input-icon">
                    <i class="fa-regular fa-envelope"></i>
                </span>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="nombre@empresa.com"
                    class="blum-input"
                >
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="blum-label">
                Contraseña
            </label>
            <div class="relative">
                <span class="input-icon">
                    <i class="fa-solid fa-lock"></i>
                </span>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="blum-input"
                >
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Remember me + Forgot password --}}
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="blum-checkbox"
                >
                <span class="blum-remember">Recuérdame</span>
            </label>

            @if (Route::has('password.request'))
                <a class="blum-link" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        {{-- Submit --}}
        <div class="pt-1">
            <button type="submit" class="blum-btn">
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                Iniciar Sesión
            </button>
        </div>

    </form>
</x-guest-layout>