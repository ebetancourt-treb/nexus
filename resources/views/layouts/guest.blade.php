<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'NexusCore') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,900&display=swap" rel="stylesheet" />
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-zinc-300 antialiased bg-zinc-950 selection:bg-indigo-500 selection:text-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            <div class="mb-6">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-blue-700 rounded-lg flex items-center justify-center text-white shadow-lg shadow-indigo-500/20 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-cubes-stacked text-xl"></i>
                    </div>
                    <span class="font-black text-xl text-white tracking-wider">
                        NEXUS<span class="text-indigo-500">CORE</span>
                    </span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-zinc-900 border border-zinc-800 shadow-2xl overflow-hidden sm:rounded-xl">
                {{ $slot }}
            </div>
            <div class="mt-8 text-xs text-zinc-600">
                &copy; {{ date('Y') }} NexusCore System. Acceso seguro.
            </div>
        </div>
    </body>
</html>