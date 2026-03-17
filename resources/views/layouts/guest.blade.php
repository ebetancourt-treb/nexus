<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BlumOps') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --jade:      #059669;
                --jade-dark: #047857;
                --jade-light:#10b981;
            }

            body {
                font-family: 'Montserrat', sans-serif;
            }

            .logo-font {
                font-family: 'Special Gothic Expanded One', sans-serif;
            }

            /* Dot-grid background */
            .guest-bg {
                background-color: #f9fafb;
                background-image: radial-gradient(circle, #d1d5db 1px, transparent 1px);
                background-size: 24px 24px;
            }

            /* Card */
            .guest-card {
                background: #ffffff;
                border: 1px solid #e5e7eb;
                border-radius: 16px;
                box-shadow: 0 8px 32px rgba(0,0,0,0.06);
            }

            /* Input */
            .blum-input {
                font-family: 'Montserrat', sans-serif;
                font-size: 0.875rem;
                width: 100%;
                padding: 0.75rem 0.75rem 0.75rem 2.8rem;
                background: #f9fafb;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                color: #1c1c1c;
                transition: border-color 0.2s, box-shadow 0.2s;
                outline: none;
                min-height: 2.5rem;
            }

            .blum-input::placeholder {
                color: #9ca3af;
            }

            .blum-input:focus {
                border-color: var(--jade);
                box-shadow: 0 0 0 3px rgba(5,150,105,0.12);
            }

            /* Checkbox */
            .blum-checkbox {
                accent-color: var(--jade);
                width: 15px;
                height: 15px;
                border-radius: 4px;
            }

            /* Button */
            .blum-btn {
                font-family: 'Montserrat', sans-serif;
                font-weight: 600;
                font-size: 0.875rem;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 0.7rem 1.5rem;
                border: none;
                border-radius: 50px;
                color: #fff;
                background: linear-gradient(135deg, #047857 0%, #059669 50%, #10b981 100%);
                cursor: pointer;
                position: relative;
                overflow: hidden;
                transition: box-shadow 0.3s, transform 0.2s;
            }

            .blum-btn::before {
                content: '';
                position: absolute;
                top: 0; left: -100%;
                width: 100%; height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.35) 50%, transparent);
                transition: left 0.5s ease;
            }

            .blum-btn:hover::before  { left: 100%; }

            .blum-btn:hover {
                box-shadow: 0 6px 20px rgba(5,150,105,0.35);
                transform: translateY(-1px);
            }

            .blum-btn:active {
                transform: translateY(0);
                box-shadow: 0 2px 8px rgba(5,150,105,0.25);
            }

            /* Link jade */
            .blum-link {
                color: var(--jade);
                font-size: 0.8rem;
                font-weight: 500;
                text-decoration: none;
                transition: opacity 0.2s;
            }
            .blum-link:hover { opacity: 0.7; text-decoration: underline; }

            /* Label */
            .blum-label {
                display: block;
                font-size: 0.7rem;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                color: #6b7280;
                margin-bottom: 6px;
            }

            /* Icon wrapper inside input - CENTRADO PERFECTAMENTE */
            .input-icon {
                position: absolute;
                top: 50%;
                left: 0.75rem;
                transform: translateY(-50%);
                display: flex;
                align-items: center;
                justify-content: center;
                pointer-events: none;
                color: #9ca3af;
                font-size: 1.5rem;
                width: 1.5rem;
                height: 1.5rem;
            }

            /* Remember me label */
            .blum-remember {
                font-size: 0.8rem;
                color: #6b7280;
                font-weight: 400;
                user-select: none;
            }

            /* Divider */
            .blum-divider {
                border: none;
                border-top: 1px solid #e5e7eb;
                margin: 0;
            }
        </style>
    </head>

    <body class="guest-bg antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

            {{-- Logo --}}
            <div class="mb-8">
                <a href="/" class="flex items-center gap-1 group">
                    <span class="logo-font text-xl font-bold text-[#585858] tracking-tight leading-none
                                 group-hover:opacity-80 transition-opacity">
                        Blum<span class="text-[#059669]">Ops</span>
                    </span>
                </a>
            </div>

            {{-- Card --}}
            <div class="guest-card w-full sm:max-w-md overflow-hidden">

                {{-- Card header --}}
                <div class="px-8 pt-8 pb-6">
                    <p class="text-xs font-light tracking-widest uppercase text-[#9ca3af] mb-1">
                        Sistema de inventarios
                    </p>
                    <h1 class="logo-font text-2xl text-[#585858] leading-tight">
                        Accede a tu cuenta
                    </h1>
                </div>

                <hr class="blum-divider">

                {{-- Slot content (login form) --}}
                <div class="px-8 py-7">
                    {{ $slot }}
                </div>

            </div>

            {{-- Footer --}}
            <p class="mt-8 text-xs text-[#9ca3af] font-light">
                &copy; {{ date('Y') }} <a href="https://treblum.com" target="_blank" class="blum-link">Treblum™</a>. Todos los derechos reservados.
            </p>

        </div>
    </body>
</html>