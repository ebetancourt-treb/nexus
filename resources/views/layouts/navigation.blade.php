<nav x-data="{ open: false }" class="blum-nav">
    <style>
        /* ── Variables CSS ────────────────────────────────────── */
        .blum-nav {
            --jade: #059669;
            --jade-dark: #047857;
            --jade-light: #10b981;
            --border: #e5e7eb;
            --text: #1c1c1c;
            --text-muted: #6b7280;
            --text-secondary: #666;
            --bg: #ffffff;
            --bg-app: #f9fafb;

            font-family: 'Montserrat', sans-serif;
            background: var(--bg);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        /* ── Container ────────────────────────────────────────── */
        .blum-nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 56px;
        }

        /* ── Logo ─────────────────────────────────────────────── */
        .blum-logo {
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: #585858;
            text-decoration: none;
            line-height: 1;
            letter-spacing: -0.5px;
            transition: opacity 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0;
        }

        .blum-logo:hover {
            opacity: 0.75;
        }

        .blum-logo-accent {
            color: var(--jade);
        }

        /* ── Left Section (Logo + Links) ──────────────────────– */
        .blum-nav-left {
            display: flex;
            align-items: center;
            gap: 40px;
        }

        .blum-nav-links {
            display: none;
            align-items: center;
            gap: 24px;
        }

        .blum-nav-links.desktop {
            display: flex;
        }

        .blum-nav-link {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-muted);
            text-decoration: none;
            padding-bottom: 2px;
            border-bottom: 2px solid transparent;
            transition: color 0.2s ease, border-color 0.2s ease;
            white-space: nowrap;
        }

        .blum-nav-link:hover,
        .blum-nav-link.active {
            color: var(--text);
            border-bottom-color: var(--jade);
        }

        /* ── Right Section (User Dropdown) ─────────────────────– */
        .blum-nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* ── User Button ──────────────────────────────────────── */
        .blum-user-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px 6px 6px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-muted);
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .blum-user-btn:hover {
            color: var(--text);
            border-color: #d1d5db;
            background: var(--bg-app);
        }

        /* ── Avatar ───────────────────────────────────────────── */
        .blum-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--jade-dark), var(--jade-light));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        /* ── Dropdown ─────────────────────────────────────────– */
        .blum-dropdown {
            position: absolute;
            right: 0;
            top: 100%;
            min-width: 200px;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            padding: 8px;
            margin-top: 4px;
        }

        .blum-dropdown-header {
            padding: 12px 12px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 4px;
        }

        .blum-dropdown-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 2px;
        }

        .blum-dropdown-email {
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        .blum-dropdown-item {
            display: flex;
            align-items: center;
            gap: 8px;
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
            transition: all 0.15s ease;
        }

        .blum-dropdown-item:hover {
            background: var(--bg-app);
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

        .blum-dropdown-icon {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        /* ── Hamburger Button ─────────────────────────────────– */
        .blum-hamburger {
            display: none;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .blum-hamburger:hover {
            background: var(--bg-app);
            color: var(--text);
        }

        .blum-hamburger svg {
            width: 20px;
            height: 20px;
        }

        @media (max-width: 640px) {
            .blum-hamburger {
                display: flex;
            }

            .blum-nav-links.desktop {
                display: none;
            }

            .blum-nav-left {
                gap: 0;
            }
        }

        /* ── Mobile Menu ──────────────────────────────────────– */
        .blum-mobile-menu {
            display: none;
            border-top: 1px solid var(--border);
            background: var(--bg);
            padding: 12px 0 16px;
        }

        .blum-mobile-menu.open {
            display: block;
        }

        .blum-mobile-links {
            padding: 8px 0;
            border-bottom: 1px solid var(--border);
            margin-bottom: 12px;
        }

        .blum-mobile-link {
            display: block;
            padding: 10px 24px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.15s ease;
            border-left: 3px solid transparent;
        }

        .blum-mobile-link:hover,
        .blum-mobile-link.active {
            color: var(--jade);
            background: rgba(5, 150, 105, 0.05);
            border-left-color: var(--jade);
        }

        .blum-mobile-link.danger:hover {
            color: #dc2626;
            background: #fef2f2;
            border-left-color: #dc2626;
        }

        .blum-mobile-user {
            padding: 12px 24px;
            border-top: 1px solid var(--border);
            margin-top: 8px;
        }

        .blum-mobile-user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .blum-mobile-user-details {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .blum-mobile-user-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text);
        }

        .blum-mobile-user-email {
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        .blum-mobile-actions {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        /* ── Dropdown Positioning ─────────────────────────────– */
        .blum-user-dropdown-wrapper {
            position: relative;
            display: none;
        }

        .blum-user-dropdown-wrapper.active {
            display: block;
        }

        @media (max-width: 640px) {
            .blum-user-dropdown-wrapper {
                display: none !important;
            }

            .blum-nav-container {
                height: 56px;
            }
        }
    </style>

    {{-- Desktop Navigation Bar --}}
    <div class="blum-nav-container">
        {{-- Left: Logo + Nav Links --}}
        <div class="blum-nav-left">
            <a href="{{ route('dashboard') }}" class="blum-logo">
                Blum<span class="blum-logo-accent">Ops</span>
            </a>

            <div class="blum-nav-links desktop">
                <a href="{{ route('dashboard') }}"
                   class="blum-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
                {{-- Más links próximamente --}}
            </div>
        </div>

        {{-- Right: User Menu + Hamburger --}}
        <div class="blum-nav-right">
            {{-- Desktop User Dropdown --}}
            <div class="blum-user-dropdown-wrapper" x-data="{ userOpen: false }" @click.away="userOpen = false">
                <button @click="userOpen = !userOpen" class="blum-user-btn">
                    <span class="blum-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                    <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                              clip-rule="evenodd"/>
                    </svg>
                </button>

                {{-- Dropdown Menu --}}
                <div x-show="userOpen" class="blum-dropdown">
                    <div class="blum-dropdown-header">
                        <div class="blum-dropdown-name">{{ Auth::user()->name }}</div>
                        <div class="blum-dropdown-email">{{ Auth::user()->email }}</div>
                    </div>

                    <div class="blum-dropdown-divider"></div>

                    <a href="{{ route('tenant.profile.edit') }}" class="blum-dropdown-item">
                        <svg class="blum-dropdown-icon" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                        <span>Mi perfil</span>
                    </a>

                    <div class="blum-dropdown-divider"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="blum-dropdown-item danger">
                            <svg class="blum-dropdown-icon" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                            </svg>
                            <span>Cerrar sesión</span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Mobile Hamburger --}}
            <button @click="open = !open" class="blum-hamburger">
                <svg :class="{ 'hidden': open, 'block': !open }" class="block" stroke="currentColor" fill="none"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg :class="{ 'hidden': !open, 'block': open }" class="hidden" stroke="currentColor" fill="none"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div :class="{ 'open': open, 'hidden sm:hidden': !open }" class="blum-mobile-menu hidden sm:hidden">
        {{-- Navigation Links --}}
        <div class="blum-mobile-links">
            <a href="{{ route('dashboard') }}"
               class="blum-mobile-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
            {{-- Más links próximamente --}}
        </div>

        {{-- User Section --}}
        <div class="blum-mobile-user">
            <div class="blum-mobile-user-info">
                <span class="blum-avatar" style="width: 36px; height: 36px; font-size: 0.75rem;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
                <div class="blum-mobile-user-details">
                    <span class="blum-mobile-user-name">{{ Auth::user()->name }}</span>
                    <span class="blum-mobile-user-email">{{ Auth::user()->email }}</span>
                </div>
            </div>

            <div class="blum-mobile-actions">
                <a href="{{ route('tenant.profile.edit') }}" class="blum-mobile-link" @click="open = false">
                    Mi perfil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="blum-mobile-link danger w-full text-left bg-transparent border-0 cursor-pointer p-0 pl-6"
                            @click="open = false">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>