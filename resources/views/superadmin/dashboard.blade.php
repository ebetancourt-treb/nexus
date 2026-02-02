<x-app-layout>
    <div class="min-h-screen bg-zinc-950 font-sans text-zinc-300 selection:bg-indigo-500 selection:text-white">
        
        <div class="bg-zinc-900/80 backdrop-blur-md border-b border-zinc-800 sticky top-0 z-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div>
                        <h2 class="text-xl font-bold text-white tracking-tight">Nexus Core</h2>
                        <nav class="flex text-xs text-zinc-500 mt-1">
                            <span class="hover:text-indigo-400 cursor-pointer transition-colors">Inicio</span>
                            <span class="mx-2 text-zinc-700">/</span>
                            <span class="font-medium text-zinc-400">Vista General</span>
                        </nav>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="relative hidden md:block group">
                            <input type="text" placeholder="Buscar empresa..." 
                                   class="pl-9 pr-4 py-2 bg-zinc-950 border border-zinc-800 rounded-lg text-sm text-zinc-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-64 transition-all group-hover:border-zinc-700 placeholder-zinc-600">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-zinc-600 group-hover:text-zinc-400 transition-colors text-xs"></i>
                        </div>

                        <a href="{{ route('superadmin.companies.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-lg shadow-lg shadow-indigo-900/20 transition-all duration-200 border border-transparent hover:border-indigo-400">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Nueva Empresa
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-zinc-900 p-5 rounded-xl border border-zinc-800 shadow-sm hover:border-zinc-700 transition-colors flex items-center justify-between group">
                        <div>
                            <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest">Empresas Totales</p>
                            <h3 class="text-2xl font-bold text-white mt-1 group-hover:text-indigo-400 transition-colors">{{ \App\Models\Tenant::count() }}</h3>
                            <span class="text-[10px] text-emerald-400 font-medium bg-emerald-400/10 px-2 py-0.5 rounded-full mt-2 inline-block border border-emerald-400/20">
                                <i class="fa-solid fa-arrow-trend-up mr-1"></i> +12% mes
                            </span>
                        </div>
                        <div class="h-12 w-12 bg-zinc-800 rounded-lg flex items-center justify-center text-indigo-500 border border-zinc-700 group-hover:bg-indigo-500/10 group-hover:border-indigo-500/50 transition-all">
                            <i class="fa-regular fa-building text-lg"></i>
                        </div>
                    </div>

                    <div class="bg-zinc-900 p-5 rounded-xl border border-zinc-800 shadow-sm hover:border-zinc-700 transition-colors flex items-center justify-between group">
                        <div>
                            <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest">Usuarios Admin</p>
                            <h3 class="text-2xl font-bold text-white mt-1 group-hover:text-indigo-400 transition-colors">{{ \App\Models\User::count() }}</h3>
                            <span class="text-[10px] text-zinc-500 mt-2 inline-block">Activos en plataforma</span>
                        </div>
                        <div class="h-12 w-12 bg-zinc-800 rounded-lg flex items-center justify-center text-indigo-500 border border-zinc-700 group-hover:bg-indigo-500/10 group-hover:border-indigo-500/50 transition-all">
                            <i class="fa-solid fa-users text-lg"></i>
                        </div>
                    </div>

                    <div class="bg-zinc-900 p-5 rounded-xl border border-zinc-800 shadow-sm hover:border-zinc-700 transition-colors flex items-center justify-between group">
                        <div>
                            <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest">Tickets Soporte</p>
                            <h3 class="text-2xl font-bold text-white mt-1 group-hover:text-amber-500 transition-colors">3</h3>
                            <span class="text-[10px] text-amber-500 font-medium bg-amber-500/10 px-2 py-0.5 rounded-full mt-2 inline-block border border-amber-500/20">
                                Pendientes
                            </span>
                        </div>
                        <div class="h-12 w-12 bg-zinc-800 rounded-lg flex items-center justify-center text-amber-500 border border-zinc-700 group-hover:bg-amber-500/10 group-hover:border-amber-500/50 transition-all">
                            <i class="fa-regular fa-life-ring text-lg"></i>
                        </div>
                    </div>

                    <div class="bg-zinc-900 p-5 rounded-xl border border-zinc-800 shadow-sm hover:border-zinc-700 transition-colors flex items-center justify-between group">
                        <div>
                            <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest">Estado Sistema</p>
                            <h3 class="text-lg font-bold text-emerald-500 mt-1 shadow-emerald-500/20 drop-shadow-sm">Operativo</h3>
                            <span class="text-[10px] text-zinc-500 mt-2 inline-block font-mono">Ping: 24ms</span>
                        </div>
                        <div class="h-12 w-12 bg-zinc-800 rounded-lg flex items-center justify-center text-emerald-500 border border-zinc-700 group-hover:bg-emerald-500/10 group-hover:border-emerald-500/50 transition-all">
                            <i class="fa-solid fa-server text-lg"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-zinc-900 rounded-xl shadow-xl border border-zinc-800 overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-800 flex justify-between items-center bg-zinc-900">
                        <h3 class="font-bold text-zinc-100 text-sm">Directorio de Empresas</h3>
                        <div class="flex space-x-2">
                            <button class="text-zinc-400 hover:text-white hover:bg-zinc-800 bg-zinc-900 border border-zinc-700 px-3 py-1.5 rounded-md text-xs font-medium transition-all">
                                <i class="fa-solid fa-filter mr-1"></i> Filtrar
                            </button>
                            <button class="text-zinc-400 hover:text-white hover:bg-zinc-800 bg-zinc-900 border border-zinc-700 px-3 py-1.5 rounded-md text-xs font-medium transition-all">
                                <i class="fa-solid fa-download mr-1"></i> Exportar
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left divide-y divide-zinc-800/50">
                            <thead class="bg-zinc-950/50 text-zinc-500">
                                <tr>
                                    <th class="px-6 py-3 text-[10px] font-bold uppercase tracking-wider">Empresa</th>
                                    <th class="px-6 py-3 text-[10px] font-bold uppercase tracking-wider">Administrador</th>
                                    <th class="px-6 py-3 text-[10px] font-bold uppercase tracking-wider">Plan / Dominio</th>
                                    <th class="px-6 py-3 text-[10px] font-bold uppercase tracking-wider text-center">Estado</th>
                                    <th class="px-6 py-3 text-[10px] font-bold uppercase tracking-wider text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-800 bg-zinc-900">
                                @forelse(\App\Models\Tenant::with('users')->latest()->take(10)->get() as $tenant)
                                <tr class="hover:bg-zinc-800/60 transition-colors duration-150 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-9 w-9 rounded bg-zinc-800 text-indigo-400 border border-zinc-700 flex items-center justify-center font-bold text-sm group-hover:border-indigo-500/50 group-hover:text-indigo-300 transition-colors">
                                                {{ strtoupper(substr($tenant->name, 0, 1)) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-zinc-200">{{ $tenant->name }}</div>
                                                <div class="text-xs text-zinc-500 font-mono">ID: #{{ $tenant->id }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <i class="fa-solid fa-circle-user text-zinc-600 text-xl group-hover:text-zinc-500 transition-colors"></i>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-zinc-300">
                                                    {{ $tenant->users->first()->name ?? 'Sin Asignar' }}
                                                </div>
                                                <div class="text-xs text-zinc-500">
                                                    {{ $tenant->users->first()->email ?? '' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded bg-zinc-950 text-zinc-400 border border-zinc-800 font-mono">
                                            {{ $tenant->domain ?? 'localhost' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 mr-1.5 bg-emerald-500 rounded-full shadow-[0_0_5px_currentColor]"></span>
                                            Activo
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-zinc-500 hover:text-white p-2 rounded-full hover:bg-zinc-700 transition-colors">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="h-16 w-16 bg-zinc-800/50 rounded-full flex items-center justify-center mb-4 border border-zinc-700 border-dashed">
                                                <i class="fa-solid fa-folder-open text-zinc-600 text-2xl"></i>
                                            </div>
                                            <h3 class="text-sm font-medium text-zinc-300">No hay empresas registradas</h3>
                                            <p class="text-sm text-zinc-500 mt-1">La base de datos está vacía.</p>
                                            <a href="{{ route('superadmin.companies.create') }}" class="mt-4 text-indigo-400 hover:text-indigo-300 font-medium text-sm border-b border-indigo-400/30 hover:border-indigo-300 pb-0.5 transition-all">
                                                Crear la primera empresa
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="bg-zinc-900 px-4 py-3 border-t border-zinc-800 sm:px-6 flex justify-between items-center">
                        <div class="text-xs text-zinc-500">
                            Mostrando <span class="font-medium text-zinc-300">1</span> a <span class="font-medium text-zinc-300">10</span> de <span class="font-medium text-zinc-300">{{ \App\Models\Tenant::count() }}</span> resultados
                        </div>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 border border-zinc-700 rounded-md text-xs font-medium text-zinc-400 bg-zinc-800 hover:bg-zinc-700 hover:text-white transition-colors disabled:opacity-50">Anterior</button>
                            <button class="px-3 py-1 border border-zinc-700 rounded-md text-xs font-medium text-zinc-400 bg-zinc-800 hover:bg-zinc-700 hover:text-white transition-colors">Siguiente</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>