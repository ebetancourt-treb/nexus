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
            height: 100vh;
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

        @include('components.sidebar-nav')



        <div class="sidebar-footer">
            <div class="sidebar-tenant">{{ auth()->user()->tenant?->name ?? 'BlumOps' }}</div>
            <div class="sidebar-plan">{{ auth()->user()->tenant?->currentPlan()?->name ?? 'Sin plan' }}</div>
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
