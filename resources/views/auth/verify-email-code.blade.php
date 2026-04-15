<x-guest-layout>
    <div class="mb-4 text-center">
        <div style="width:56px; height:56px; background:#ecfdf5; border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <svg fill="none" stroke="#059669" stroke-width="1.5" viewBox="0 0 24 24" style="width:28px; height:28px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
            </svg>
        </div>
        <h2 class="text-lg font-bold text-gray-900">Verifica tu correo electrónico</h2>
        <p class="text-sm text-gray-500 mt-2">
            Enviamos un código de 6 dígitos a<br>
            <strong class="text-gray-700">{{ auth()->user()->email }}</strong>
        </p>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-800">
            {{ session('info') }}
        </div>
    @endif

    <!-- Formulario de código -->
    <form method="POST" action="{{ route('verification.verify') }}" class="mb-4">
        @csrf

        <div class="mb-4">
            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Código de verificación</label>
            <input
                type="text"
                name="code"
                id="code"
                maxlength="6"
                inputmode="numeric"
                pattern="[0-9]*"
                autocomplete="one-time-code"
                autofocus
                required
                placeholder="000000"
                class="block w-full text-center text-2xl font-bold tracking-widest border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500"
                style="letter-spacing: 0.5em; padding: 12px;"
            >
            @error('code')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <x-primary-button class="w-full justify-center" style="padding: 12px;">
            Verificar código
        </x-primary-button>
    </form>

    <!-- Reenviar código -->
    <div class="text-center">
        <p class="text-sm text-gray-500 mb-3">¿No recibiste el código?</p>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="text-sm font-semibold text-green-600 hover:text-green-800 underline">
                Reenviar código
            </button>
        </form>
    </div>

    <!-- Separador -->
    <div class="mt-6 pt-4 border-t border-gray-200 text-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-xs text-gray-400 hover:text-gray-600">
                Cerrar sesión
            </button>
        </form>
    </div>
</x-guest-layout>
