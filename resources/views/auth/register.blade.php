<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        @php
            $selectedPlan = request('plan', 'profesional');
            $planInfo = [
                'starter' => ['name' => 'Starter', 'price' => '$349', 'desc' => '1 almacén · 1,000 productos · 3 usuarios'],
                'profesional' => ['name' => 'Profesional', 'price' => '$899', 'desc' => '3 almacenes · Productos ilimitados · 10 usuarios · Lotes y series'],
                'enterprise' => ['name' => 'Enterprise', 'price' => '$2,499', 'desc' => 'Ilimitado · API · Consultoría · Soporte dedicado'],
            ];
            $plan = $planInfo[$selectedPlan] ?? $planInfo['profesional'];
        @endphp

        <!-- Plan seleccionado -->
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-green-800">Plan {{ $plan['name'] }} — {{ $plan['price'] }} MXN/mes</p>
                    <p class="text-xs text-green-600 mt-1">{{ $plan['desc'] }}</p>
                </div>
                <span class="text-xs font-bold text-green-700 bg-green-100 px-2 py-1 rounded">7 días gratis</span>
            </div>
        </div>

        <input type="hidden" name="plan" value="{{ $selectedPlan }}">

        <!-- Selector de plan (compacto) -->
        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700 mb-2">Cambiar plan</label>
            <div class="grid grid-cols-3 gap-2">
                @foreach(['starter' => 'Starter', 'profesional' => 'Profesional', 'enterprise' => 'Enterprise'] as $slug => $name)
                    <a href="{{ route('register', ['plan' => $slug]) }}"
                       class="text-center py-2 px-3 rounded-lg text-xs font-semibold border transition-all
                              {{ $selectedPlan === $slug ? 'bg-green-600 text-white border-green-600' : 'bg-white text-gray-600 border-gray-200 hover:border-green-400 hover:text-green-600' }}">
                        {{ $name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Company Name -->
        <div>
            <x-input-label for="company_name" :value="__('Nombre de tu empresa')" />
            <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" required autofocus placeholder="Ej. Distribuidora López S.A. de C.V." />
            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Tu nombre completo')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required placeholder="Ej. Juan López García" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required placeholder="juan@tuempresa.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms -->
        <div class="mt-4">
            <p class="text-xs text-gray-500">
                Al crear tu cuenta aceptas los <a href="#" class="underline text-green-600">términos de servicio</a> y la <a href="#" class="underline text-green-600">política de privacidad</a> de BlumOps.
            </p>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md" href="{{ route('login') }}">
                {{ __('¿Ya tienes cuenta?') }}
            </a>

            <x-primary-button>
                {{ __('Crear cuenta gratis') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
