<nav x-data="{ open: false }" class="bg-zinc-900 border-b border-zinc-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-indigo-500" />
                    </a>
                </div>
<nav x-data="{ open: false }" class="blum-nav">

    <style>
        /* ── Variables ─────────────────────────────────────── */
        .blum-nav {
            --jade:       #059669;
            --jade-dark:  #047857;
            --jade-light: #10b981;
            --border:     #e5e7eb;
            --text:       #1c1c1c;
            --text-muted: #6b7280;
            --bg:         #ffffff;
            --bg-hover:   #f9fafb;

            font-family: 'Montserrat', sans-serif;
            background: var(--bg);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        /* ── Logo ───────────────────────────────────────────── */
        .blum-logo {
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: #585858;
            text-decoration: none;
            line-height: 1;
            letter-spacing: -0.5px;
            transition: opacity 0.2s;
        }
        .blum-logo:hover { opacity: 0.75; }
        .blum-logo-accent { color: var(--jade); }

        /* ── Desktop nav links ─────────────────────────────── */
        .blum-nav-link {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-muted);
            text-decoration: none;
            padding: 0 4px;
            padding-bottom: 2px;
            border-bottom: 2px solid transparent;
            transition: color 0.2s, border-color 0.2s;
            white-space: nowrap;
        }
        .blum-nav-link:hover,
        .blum-nav-link.active {
            color: var(--text);
            border-bottom-color: var(--jade);
        }

        /* ── User trigger button ───────────────────────────── */
        .blum-user-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-muted);
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 50px;
            cursor: pointer;
            transition: color 0.2s, border-color 0.2s, background 0.2s;
        }
        .blum-user-btn:hover {
            color: var(--text);
            border-color: #d1d5db;
            background: var(--bg-hover);
        }

        /* ── Avatar circle ─────────────────────────────────── */
        .blum-avatar {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--jade-dark), var(--jade-light));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        /* ── Dropdown menu ─────────────────────────────────── */
        .blum-dropdown {
            min-width: 180px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            overflow: hidden;
            padding: 4px;
        }

        .blum-dropdown-item {
            display: block;
            width: 100%;
            padding: 8px 12px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 7px;
            border: none;
            background: transparent;
            cursor: pointer;
            text-align: left;
            transition: background 0.15s, color 0.15s;
        }
        .blum-dropdown-item:hover {
            background: var(--bg-hover);
            color: var(--text);
        }
        .blum-dropdown-item.danger:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        .blum-dropdown-divider {
            height: 1px;
            background: var(--border);
            margin: 4px 0;
        }

        /* ── Mobile menu ───────────────────────────────────── */
        .blum-mobile-menu {
            border-top: 1px solid var(--border);
            background: #fff;
            padding: 12px 0 16px;
        }

        .blum-mobile-link {
            display: block;
            padding: 9px 20px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.15s, background 0.15s;
            border-left: 3px solid transparent;
        }
        .blum-mobile-link:hover,
        .blum-mobile-link.active {
            color: var(--jade);
            background: #f0fdf9;
            border-left-color: var(--jade);
        }
        .blum-mobile-link.danger:hover {
            color: #dc2626;
            background: #fef2f2;
            border-left-color: #dc2626;
        }

        .blum-mobile-user {
            padding: 12px 20px 8px;
            border-top: 1px solid var(--border);
            margin-top: 8px;
        }

        /* ── Hamburger button ──────────────────────────────── */
        .blum-hamburger {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 7px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--text-muted);
            cursor: pointer;
            transition: background 0.15s, color 0.15s;
        }
        .blum-hamburger:hover {
            background: var(--bg-hover);
            color: var(--text);
        }
    </style>

    {{-- ────────────────────────────────────────────────────────── --}}
    {{-- DESKTOP BAR                                               --}}
    {{-- ────────────────────────────────────────────────────────── --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-14">

            {{-- Left: Logo + nav links --}}
            <div class="flex items-center gap-8">

                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="blum-logo">
                    Blum<span class="blum-logo-accent">Ops</span>
                </a>

                {{-- Desktop links --}}
                <div class="hidden sm:flex items-center gap-6">
                    <a href="{{ route('dashboard') }}"
                       class="blum-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                    {{-- Aquí irán más links próximamente --}}
                </div>
            </div>

            {{-- Right: User dropdown --}}
            <div class="hidden sm:flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="blum-user-btn">
                            {{-- Avatar con inicial --}}
                            <span class="blum-avatar">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            {{ Auth::user()->name }}
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="blum-dropdown">
                            {{-- User info --}}
                            <div class="px-3 py-2 mb-1">
                                <p class="text-xs font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="blum-dropdown-divider"></div>

                            <a href="{{ route('profile.edit') }}" class="blum-dropdown-item">
                                <span class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                    </svg>
                                    Mi perfil
                                </span>
                            </a>

                            <div class="blum-dropdown-divider"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="blum-dropdown-item danger w-full">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                                        </svg>
                                        Cerrar sesión
                                    </span>
                                </button>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Mobile hamburger --}}
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="blum-hamburger">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- ────────────────────────────────────────────────────────── --}}
    {{-- MOBILE MENU                                               --}}
    {{-- ────────────────────────────────────────────────────────── --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden blum-mobile-menu">

        {{-- Nav links --}}
        <div class="space-y-0.5 px-2">
            <a href="{{ route('dashboard') }}"
               class="blum-mobile-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
            {{-- Aquí irán más links próximamente --}}
        </div>

        {{-- User section --}}
        <div class="blum-mobile-user">
            <div class="flex items-center gap-3 mb-3">
                <span class="blum-avatar" style="width:32px;height:32px;font-size:0.75rem;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
                <div>
                    <p class="text-sm font-semibold text-gray-800 leading-none">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <div class="space-y-0.5 px-0">
                <a href="{{ route('profile.edit') }}" class="blum-mobile-link">
                    Mi perfil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="blum-mobile-link danger w-full text-left bg-transparent border-0 cursor-pointer">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>

    </div>
</nav>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-zinc-400 hover:text-white focus:text-white">
                        Dashboard
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-zinc-400 bg-zinc-900 hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-zinc-400 hover:text-white hover:bg-zinc-800 focus:outline-none focus:bg-zinc-800 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-zinc-900 border-b border-zinc-800">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-zinc-400 hover:text-indigo-400 hover:bg-zinc-800 hover:border-indigo-500">
                Dashboard
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-zinc-800">
            <div class="px-4">
                <div class="font-medium text-base text-zinc-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-zinc-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-zinc-400 hover:text-indigo-400 hover:bg-zinc-800">
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" class="text-zinc-400 hover:text-red-400 hover:bg-zinc-800"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>