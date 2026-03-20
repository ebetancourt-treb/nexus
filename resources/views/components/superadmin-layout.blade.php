<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SuperAdmin' }} — BlumOps</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --sa-bg: #0f172a; --sa-sidebar: #1e293b; --sa-card: #1e293b;
            --sa-border: #334155; --sa-text: #e2e8f0; --sa-text-secondary: #94a3b8;
            --sa-text-light: #64748b; --sa-accent: #059669; --sa-accent-dark: #047857;
            --sa-content-bg: #0f172a; --sa-hover: #334155;
        }
        body { font-family: 'Montserrat', sans-serif; background: var(--sa-bg); color: var(--sa-text); -webkit-font-smoothing: antialiased; }
        a { color: inherit; text-decoration: none; }

        .sa-layout { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sa-sidebar { width: 240px; background: var(--sa-sidebar); border-right: 1px solid var(--sa-border); display: flex; flex-direction: column; position: fixed; top: 0; bottom: 0; z-index: 50; }
        .sa-sidebar-header { padding: 20px 20px 16px; border-bottom: 1px solid var(--sa-border); }
        .sa-logo { font-family: 'Special Gothic Expanded One', sans-serif; font-size: 1.1rem; color: #fff; }
        .sa-logo-badge { display: inline-block; padding: 2px 8px; background: var(--sa-accent); color: #fff; border-radius: 4px; font-size: 0.55rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-left: 8px; vertical-align: middle; }
        .sa-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }
        .sa-nav-section { margin-bottom: 20px; }
        .sa-nav-title { font-size: 0.6rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--sa-text-light); padding: 0 8px; margin-bottom: 8px; }
        .sa-nav-link { display: flex; align-items: center; gap: 10px; padding: 8px 12px; border-radius: 6px; font-size: 0.78rem; font-weight: 500; color: var(--sa-text-secondary); transition: all 0.15s; }
        .sa-nav-link:hover { background: var(--sa-hover); color: var(--sa-text); }
        .sa-nav-link.active { background: rgba(5,150,105,0.15); color: var(--sa-accent); }
        .sa-nav-link svg { width: 18px; height: 18px; flex-shrink: 0; }
        .sa-sidebar-footer { padding: 16px 20px; border-top: 1px solid var(--sa-border); }
        .sa-user-info { font-size: 0.75rem; color: var(--sa-text-secondary); margin-bottom: 8px; }
        .sa-btn-logout { padding: 6px 14px; background: transparent; color: var(--sa-text-light); border: 1px solid var(--sa-border); border-radius: 6px; font-size: 0.72rem; font-family: inherit; cursor: pointer; width: 100%; }
        .sa-btn-logout:hover { border-color: #ef4444; color: #ef4444; }

        /* Content */
        .sa-content { flex: 1; margin-left: 240px; padding: 24px 32px; min-height: 100vh; }
        .sa-page-header { margin-bottom: 24px; }
        .sa-page-title { font-family: 'Special Gothic Expanded One', sans-serif; font-size: 1.2rem; color: #fff; }
        .sa-page-subtitle { font-size: 0.78rem; color: var(--sa-text-secondary); margin-top: 4px; }

        /* Cards */
        .sa-card { background: var(--sa-card); border: 1px solid var(--sa-border); border-radius: 10px; overflow: hidden; }
        .sa-card-header { padding: 14px 20px; border-bottom: 1px solid var(--sa-border); display: flex; align-items: center; justify-content: space-between; }
        .sa-card-title { font-size: 0.82rem; font-weight: 600; color: var(--sa-text); }
        .sa-card-body { padding: 16px 20px; }

        /* Stats */
        .sa-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 24px; }
        .sa-stat { background: var(--sa-card); border: 1px solid var(--sa-border); border-radius: 10px; padding: 16px 20px; }
        .sa-stat-label { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--sa-text-light); }
        .sa-stat-value { font-size: 1.6rem; font-weight: 800; color: #fff; margin-top: 4px; }
        .sa-stat-value.accent { color: var(--sa-accent); }
        .sa-stat-sub { font-size: 0.65rem; color: var(--sa-text-light); margin-top: 2px; }

        /* Tables */
        .sa-table { width: 100%; border-collapse: collapse; }
        .sa-table th { padding: 10px 16px; text-align: left; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--sa-text-light); border-bottom: 1px solid var(--sa-border); }
        .sa-table td { padding: 12px 16px; font-size: 0.8rem; color: var(--sa-text-secondary); border-bottom: 1px solid rgba(51,65,85,0.5); }
        .sa-table tr:hover td { background: rgba(51,65,85,0.3); }

        /* Badges */
        .sa-badge { display: inline-flex; padding: 2px 10px; border-radius: 50px; font-size: 0.6rem; font-weight: 700; }
        .sa-badge-green { background: rgba(5,150,105,0.15); color: #34d399; }
        .sa-badge-red { background: rgba(239,68,68,0.15); color: #f87171; }
        .sa-badge-amber { background: rgba(245,158,11,0.15); color: #fbbf24; }
        .sa-badge-blue { background: rgba(59,130,246,0.15); color: #60a5fa; }
        .sa-badge-gray { background: rgba(100,116,139,0.15); color: #94a3b8; }

        /* Buttons */
        .sa-btn { padding: 6px 14px; border-radius: 6px; font-size: 0.72rem; font-weight: 600; font-family: inherit; cursor: pointer; border: 1px solid var(--sa-border); background: transparent; color: var(--sa-text-secondary); transition: all 0.15s; }
        .sa-btn:hover { border-color: var(--sa-accent); color: var(--sa-accent); }
        .sa-btn-primary { background: var(--sa-accent); color: #fff; border-color: var(--sa-accent); }
        .sa-btn-primary:hover { background: var(--sa-accent-dark); }
        .sa-btn-danger:hover { border-color: #ef4444; color: #ef4444; }

        /* Filters */
        .sa-filters { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; align-items: center; }
        .sa-filter-input { padding: 8px 12px; background: var(--sa-sidebar); border: 1px solid var(--sa-border); border-radius: 8px; font-size: 0.8rem; font-family: inherit; color: var(--sa-text); min-width: 220px; }
        .sa-filter-input:focus { outline: none; border-color: var(--sa-accent); }
        .sa-filter-input::placeholder { color: var(--sa-text-light); }
        .sa-filter-select { padding: 8px 12px; background: var(--sa-sidebar); border: 1px solid var(--sa-border); border-radius: 8px; font-size: 0.8rem; font-family: inherit; color: var(--sa-text); cursor: pointer; }

        .sa-flash-success { padding: 12px 16px; background: rgba(5,150,105,0.1); border: 1px solid rgba(5,150,105,0.2); border-radius: 8px; margin-bottom: 20px; font-size: 0.8rem; color: #34d399; }
        .sa-flash-error { padding: 12px 16px; background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); border-radius: 8px; margin-bottom: 20px; font-size: 0.8rem; color: #f87171; }
        .sa-empty { padding: 32px; text-align: center; font-size: 0.82rem; color: var(--sa-text-light); }

        .sa-grid-2 { display: grid; grid-template-columns: 1.5fr 1fr; gap: 20px; margin-bottom: 24px; }

        @media (max-width: 1024px) { .sa-stats { grid-template-columns: repeat(2, 1fr); } .sa-grid-2 { grid-template-columns: 1fr; } }
        @media (max-width: 768px) { .sa-sidebar { display: none; } .sa-content { margin-left: 0; } }

        @stack('styles')
    </style>
</head>
<body>
<div class="sa-layout">
    <!-- Sidebar -->
    <aside class="sa-sidebar">
        <div class="sa-sidebar-header">
            <span class="sa-logo">BlumOps</span>
            <span class="sa-logo-badge">Admin</span>
        </div>
        <nav class="sa-nav">
            <div class="sa-nav-section">
                <div class="sa-nav-title">Plataforma</div>
                <a href="{{ route('superadmin.dashboard') }}" class="sa-nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6z"/></svg>
                    Dashboard
                </a>
            </div>
            <div class="sa-nav-section">
                <div class="sa-nav-title">Gestión</div>
                <a href="{{ route('superadmin.tenants.index') }}" class="sa-nav-link {{ request()->routeIs('superadmin.tenants.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                    Tenants
                </a>
                <a href="{{ route('superadmin.subscriptions.index') }}" class="sa-nav-link {{ request()->routeIs('superadmin.subscriptions.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                    Suscripciones
                </a>
                <a href="{{ route('superadmin.audit-logs.index') }}" class="sa-nav-link {{ request()->routeIs('superadmin.audit-logs.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Audit Log
                </a>
            </div>
        </nav>
        <div class="sa-sidebar-footer">
            <div class="sa-user-info">{{ auth()->user()->name }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sa-btn-logout">Cerrar sesión</button>
            </form>
        </div>
    </aside>

    <!-- Content -->
    <main class="sa-content">
        @if(session('success')) <div class="sa-flash-success">{{ session('success') }}</div> @endif
        @if($errors->any()) <div class="sa-flash-error">{{ $errors->first() }}</div> @endif
        {{ $slot }}
    </main>
</div>
@stack('scripts')
</body>
</html>
