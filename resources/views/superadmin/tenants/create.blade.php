<x-app-layout>
    <div class="min-h-screen bg-zinc-950 text-zinc-300 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Registrar Nueva Empresa</h2>
                    <p class="text-sm text-zinc-500 mt-1">Configura la entidad y su primer administrador.</p>
                </div>
                <a href="{{ route('superadmin.tenants.index') }}" class="text-sm text-zinc-400 hover:text-white flex items-center transition-colors">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Volver
                </a>
            </div>

            <div class="bg-zinc-900 border border-zinc-800 rounded-xl shadow-xl overflow-hidden">
                <form method="POST" action="{{ route('superadmin.tenants.store') }}" class="p-6 md:p-8 space-y-8">
                    @csrf

                    <div>
                        <div class="flex items-center mb-4">
                            <div class="h-8 w-8 rounded-full bg-indigo-500/10 flex items-center justify-center text-indigo-500 border border-indigo-500/20 mr-3">
                                <i class="fa-regular fa-building text-sm"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Datos de la Organización</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label for="company_name" class="block text-xs font-bold text-zinc-500 uppercase tracking-wider mb-2">Nombre Comercial</label>
                                <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" required autofocus
                                    class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2.5 text-white placeholder-zinc-600 focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-all"
                                    placeholder="Ej. Industrias Stark S.A. de C.V.">
                                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                            </div>

                            
                        </div>
                    </div>

                    <div class="border-t border-zinc-800"></div>

                    <div>
                        <div class="flex items-center mb-4">
                            <div class="h-8 w-8 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500 border border-emerald-500/20 mr-3">
                                <i class="fa-solid fa-user-shield text-sm"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Cuenta de Administrador</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="admin_name" class="block text-xs font-bold text-zinc-500 uppercase tracking-wider mb-2">Nombre Completo</label>
                                <input type="text" name="admin_name" id="admin_name" value="{{ old('admin_name') }}" required
                                    class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2.5 text-white placeholder-zinc-600 focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition-all"
                                    placeholder="Ej. Tony Stark">
                                <x-input-error :messages="$errors->get('admin_name')" class="mt-2" />
                            </div>

                            <div>
                                <label for="admin_email" class="block text-xs font-bold text-zinc-500 uppercase tracking-wider mb-2">Correo Electrónico</label>
                                <input type="email" name="admin_email" id="admin_email" value="{{ old('admin_email') }}" required
                                    class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2.5 text-white placeholder-zinc-600 focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition-all"
                                    placeholder="admin@starkindustries.com">
                                <x-input-error :messages="$errors->get('admin_email')" class="mt-2" />
                            </div>

                            <div>
                                <label for="password" class="block text-xs font-bold text-zinc-500 uppercase tracking-wider mb-2">Contraseña Temporal</label>
                                <input type="password" name="password" id="password" required autocomplete="new-password"
                                    class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2.5 text-white placeholder-zinc-600 focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition-all">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-xs font-bold text-zinc-500 uppercase tracking-wider mb-2">Confirmar Contraseña</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2.5 text-white placeholder-zinc-600 focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition-all">
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex items-center justify-end">
                        <button type="button" onclick="window.location='{{ route('superadmin.tenants.index') }}'" class="mr-4 text-sm text-zinc-500 hover:text-white transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold rounded-lg shadow-lg shadow-indigo-900/20 transition-all duration-200 border border-transparent hover:border-indigo-400">
                            <i class="fa-solid fa-save mr-2"></i>
                            Guardar Empresa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>