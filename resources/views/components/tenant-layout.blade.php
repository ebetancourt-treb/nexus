<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} — BlumOps</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --jade: #059669;
            --jade-dark: #047857;
            --jade-light: #10b981;
            --jade-50: #ecfdf5;
            --jade-100: #d1fae5;
            --text: #1c1c1c;
            --text-secondary: #6b7280;
            --text-light: #9ca3af;
            --border: #e5e7eb;
            --bg-app: #f4f5f7;
            --bg-card: #ffffff;
            --bg-sidebar: #fafafa;
            --sidebar-w: 240px;
            --topbar-h: 56px;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--text);
            background: var(--bg-app);
            line-height: 1.5;
            overflow-x: hidden;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-w);
            height: 100dvh;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 50;
            transition: transform 0.3s ease;
        }

        .sidebar-logo {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0;
            text-decoration: none;
            flex-shrink: 0;
        }

        .sidebar-logo-text {
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: 1rem;
            color: #585858;
            font-weight: 700;
        }

        .sidebar-nav {
            flex: 1;
            padding: 12px;
            overflow-y: auto;
        }

        .sidebar-section {
            margin-bottom: 20px;
        }

        .sidebar-section-label {
            font-size: 0.6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-light);
            padding: 0 8px 8px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.15s ease;
            margin-bottom: 2px;
        }

        .sidebar-link:hover {
            background: var(--jade-50);
            color: var(--jade-dark);
        }

        .sidebar-link.active {
            background: var(--jade-50);
            color: var(--jade);
            font-weight: 600;
        }

        .sidebar-link svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .sidebar-badge {
            margin-left: auto;
            font-size: 0.65rem;
            font-weight: 700;
            background: #fee2e2;
            color: #dc2626;
            padding: 1px 7px;
            border-radius: 50px;
        }

        .sidebar-footer {
            padding: 12px 16px;
            border-top: 1px solid var(--border);
            flex-shrink: 0;
        }

        .sidebar-tenant {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-plan {
            font-size: 0.65rem;
            color: var(--jade);
            font-weight: 600;
        }

        /* ── TOPBAR ── */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-w);
            right: 0;
            height: var(--topbar-h);
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 40;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-avatar {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--jade-50);
            color: var(--jade);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.75rem;
            cursor: pointer;
            transition: background 0.15s;
        }

        .topbar-avatar:hover { background: var(--jade-100); }

        .topbar-user-name {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text);
        }

        .topbar-user-role {
            font-size: 0.65rem;
            color: var(--text-light);
        }

        .btn-menu-mobile {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-secondary);
        }

        .btn-menu-mobile svg { width: 24px; height: 24px; }

        /* ── MAIN CONTENT ── */
        .main-content {
            margin-left: var(--sidebar-w);
            margin-top: var(--topbar-h);
            padding: 24px;
            min-height: calc(100vh - var(--topbar-h));
        }

        /* ── PAGE HEADER ── */
        .page-header {
            margin-bottom: 24px;
        }

        .page-title {
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: 1.3rem;
            color: #585858;
            font-weight: 600;
        }

        .page-subtitle {
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-top: 4px;
        }

        /* ── RESPONSIVE ── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.3);
            z-index: 45;
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.open { display: block; }
            .topbar { left: 0; }
            .main-content { margin-left: 0; }
            .btn-menu-mobile { display: block; }
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- Sidebar overlay mobile --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    {{-- Sidebar --}}
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('tenant.dashboard') }}" class="sidebar-logo">
            <span class="sidebar-logo-text">BlumOps</span>
        </a>

        <nav class="sidebar-nav">
            @php
                $tenant = auth()->user()?->tenant;
                $showSuppliers = $tenant?->hasFeature('suppliers.enabled') ?? false;
                $showPO = $tenant?->hasFeature('purchase_orders.auto') ?? false;
                $showTransfers = $tenant?->hasFeature('transfers.enabled') ?? false;
                $showOperations = $showSuppliers || $showPO || $showTransfers;
            @endphp

            <div class="sidebar-section">
                <div class="sidebar-section-label">General</div>
                <a href="{{ route('tenant.dashboard') }}" class="sidebar-link {{ request()->routeIs('tenant.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                    Dashboard
                </a>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-section-label">Almacén</div>
                <a href="{{ route('tenant.products.index') }}" class="sidebar-link {{ request()->routeIs('tenant.products.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25"/></svg>
                    Productos
                </a>
                <a href="{{ route('tenant.categories.index') }}" class="sidebar-link {{ request()->routeIs('tenant.categories.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
                    Categorías
                </a>
                <a href="{{ route('tenant.warehouses.index') }}" class="sidebar-link {{ request()->routeIs('tenant.warehouses.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72"/></svg>
                    Almacenes
                </a>
                <a href="{{ route('tenant.stock.index') }}" class="sidebar-link {{ request()->routeIs('tenant.stock.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    Existencias
                </a>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-section-label">Movimientos</div>
                <a href="{{ route('tenant.movements.index') }}" class="sidebar-link {{ request()->routeIs('tenant.movements.index') || request()->routeIs('tenant.movements.show') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                    Historial
                </a>
                <a href="{{ route('tenant.movements.create-receiving') }}" class="sidebar-link {{ request()->routeIs('tenant.movements.create-receiving') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 4.5l-15 15m0 0h11.25m-11.25 0V8.25"/></svg>
                    Recepción
                </a>
                <a href="{{ route('tenant.movements.create-dispatch') }}" class="sidebar-link {{ request()->routeIs('tenant.movements.create-dispatch') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25"/></svg>
                    Despacho rápido
                </a>
                <a href="{{ route('tenant.dispatch-orders.index') }}" class="sidebar-link {{ request()->routeIs('tenant.dispatch-orders.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125v-1.5c0-1.036-.84-1.875-1.875-1.875h-.739L15.474 6.525A2.25 2.25 0 0013.476 5.25H8.25"/></svg>
                    Órdenes de despacho
                </a>
            </div>

            @if($showOperations)
            <div class="sidebar-section">
                <div class="sidebar-section-label">Operaciones</div>
                @if($showSuppliers)
                <a href="#" class="sidebar-link">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                    Proveedores
                </a>
                @endif
                @if($showPO)
                <a href="#" class="sidebar-link">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    Órdenes de compra
                </a>
                @endif
                @if($showTransfers)
                <a href="#" class="sidebar-link">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/></svg>
                    Transferencias
                </a>
                @endif
            </div>
            @endif

            <div class="sidebar-section">
                <div class="sidebar-section-label">Configuración</div>
                <a href="{{ route('tenant.profile.edit') }}" class="sidebar-link {{ request()->routeIs('tenant.profile.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    Mi perfil
                </a>
                <a href="{{ route('tenant.billing.plans') }}" class="sidebar-link {{ request()->routeIs('tenant.billing.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                    Plan y facturación
                </a>
            </div>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-tenant">{{ auth()->user()->tenant?->name ?? 'BlumOps' }}</div>
            <div class="sidebar-plan">{{ auth()->user()->tenant?->currentPlan()?->name ?? 'Sin plan' }}</div>
            <form method="POST" action="{{ route('logout') }}" style="margin-top:8px;">
                @csrf
                <button type="submit" style="background:none; border:none; font-family:inherit; font-size:0.72rem; color:var(--text-light); cursor:pointer; padding:0; display:flex; align-items:center; gap:6px;">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="width:14px; height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    {{-- Topbar --}}
    <header class="topbar">
        <div class="topbar-left">
            <button class="btn-menu-mobile" onclick="toggleSidebar()">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
            </button>
            <span class="topbar-title">{{ $header ?? 'Dashboard' }}</span>
        </div>
        <div class="topbar-right">
            <div style="text-align: right;">
                <div class="topbar-user-name">{{ auth()->user()->name }}</div>
                <div class="topbar-user-role">{{ auth()->user()->getRoleNames()->first() ?? '' }}</div>
            </div>
            <a href="{{ route('tenant.profile.edit') }}" class="topbar-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </a>
        </div>
    </header>

    {{-- Main content --}}
    <main class="main-content">
        {{ $slot }}
    </main>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }
    </script>

    @stack('scripts')
</body>
</html>
