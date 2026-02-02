<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smoth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'NexusCore') }} - WMS</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,900&display=swap" rel="stylesheet" />
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-zinc-950 text-zinc-300 selection:bg-indigo-500 selection:text-white">

        <div class="fixed inset-0 z-0 pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-indigo-900/20 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-blue-900/10 rounded-full blur-[120px]"></div>
        </div>

        <nav class="relative z-10 w-full border-b border-zinc-800 bg-zinc-950/80 backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <div class="flex-shrink-0 flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-blue-700 rounded-lg flex items-center justify-center text-white shadow-lg shadow-indigo-500/20">
                            <i class="fa-solid fa-cubes-stacked text-xl"></i>
                        </div>
                        <span class="font-black text-xl text-white tracking-wider">
                            NEXUS<span class="text-indigo-500">CORE</span>
                        </span>
                    </div>

                    <div class="flex items-center gap-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-zinc-300 hover:text-white transition-colors">
                                    Ir al Dashboard <i class="fa-solid fa-arrow-right ml-2"></i>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-md bg-indigo-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all duration-200">
                                    <i class="fa-solid fa-right-to-bracket mr-2"></i> Iniciar Sesión
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <main class="relative z-10">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 py-24 sm:py-32 flex flex-col items-center text-center">
                
                <div class="mb-8 inline-flex items-center rounded-full border border-indigo-500/30 bg-indigo-500/10 px-3 py-1 text-sm font-medium text-indigo-400">
                    <span class="flex h-2 w-2 rounded-full bg-indigo-500 mr-2 animate-pulse"></span>
                    Sistema Nexus Core
                </div>

                <h1 class="text-5xl md:text-7xl font-black text-white tracking-tight mb-6">
                    Control Total de tu <br class="hidden md:block" />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-blue-500 to-indigo-400">
                        Infraestructura Logística
                    </span>
                </h1>

                <p class="mt-2 text-lg leading-8 text-zinc-400 max-w-2xl mx-auto">
                    Gestione múltiples almacenes, controle inventarios en tiempo real y optimice sus operaciones con la plataforma diseñada para la industria moderna.
                </p>

                <div class="mt-10 flex items-center justify-center gap-x-6">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="rounded-lg bg-white px-8 py-3.5 text-sm font-bold text-zinc-900 shadow-xl hover:bg-zinc-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-all">
                            Acceder al Sistema
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-lg bg-white px-8 py-3.5 text-sm font-bold text-zinc-900 shadow-xl hover:bg-zinc-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-all">
                            Ingresar al Portal
                        </a>
                        <a href="#features" class="text-sm font-semibold leading-6 text-white hover:text-indigo-400 transition-colors">
                            Conocer más <span aria-hidden="true">→</span>
                        </a>
                    @endauth
                </div>

                <div class="mt-16 flow-root sm:mt-24 w-full">
                    <div class="relative rounded-xl bg-zinc-900/50 border border-zinc-800 p-2 ring-1 ring-inset ring-zinc-700/50 lg:-m-4 lg:rounded-2xl lg:p-4">
                        <div class="bg-zinc-950 rounded-lg overflow-hidden aspect-[16/9] shadow-2xl relative flex items-center justify-center group">
                             <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-transparent to-transparent z-10"></div>
                             
                             <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#6366f1 1px, transparent 1px); background-size: 30px 30px;"></div>

                             <div class="text-center z-20">
                                <i class="fa-solid fa-chart-line text-6xl text-zinc-800 group-hover:text-indigo-600 transition-colors duration-500 mb-4"></i>
                                <p class="text-zinc-600 font-mono text-sm group-hover:text-zinc-400 transition-colors">WMS DASHBOARD PREVIEW</p>
                             </div>
                        </div>
                    </div>
                </div>

            </div>

            <div id="features" class="scroll-mt-24 bg-zinc-900/50 border-t border-zinc-800 py-24">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                        <div class="flex flex-col items-start">
                            <div class="rounded-lg bg-indigo-500/10 p-3 ring-1 ring-indigo-500/20 mb-4">
                                <i class="fa-solid fa-network-wired text-indigo-400 text-xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-white">Multi-Usuario</h3>
                            <p class="mt-2 text-base text-zinc-400">Arquitectura diseñada para gestionar múltiples usuarios para manejo del sistema.</p>
                        </div>
                        <div class="flex flex-col items-start">
                            <div class="rounded-lg bg-indigo-500/10 p-3 ring-1 ring-indigo-500/20 mb-4">
                                <i class="fa-solid fa-bolt text-indigo-400 text-xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-white">Tiempo Real</h3>
                            <p class="mt-2 text-base text-zinc-400">Sincronización instantánea de stock, entradas y salidas. Sin retrasos en la información crítica.</p>
                        </div>
                        <div class="flex flex-col items-start">
                            <div class="rounded-lg bg-indigo-500/10 p-3 ring-1 ring-indigo-500/20 mb-4">
                                <i class="fa-solid fa-lock text-indigo-400 text-xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-white">Seguridad Robusta</h3>
                            <p class="mt-2 text-base text-zinc-400">Roles, permisos granulares y encriptación de datos para proteger la integridad de su negocio.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="border-t border-zinc-800 bg-zinc-950 py-12 relative z-10">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center gap-2 mb-4 md:mb-0">
                    <i class="fa-solid fa-cubes-stacked text-zinc-600"></i>
                    <span class="text-zinc-500 font-bold text-sm">NexusCore WMS</span>
                </div>
                <p class="text-zinc-600 text-sm">
                    &copy; {{ date('Y') }} Todos los derechos reservados. Acceso restringido a personal autorizado.
                </p>
            </div>
        </footer>

    </body>
</html>