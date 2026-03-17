<x-app-layout>
    <style>
        :root {
            --jade: #059669;
            --jade-dark: #047857;
            --jade-light: #10b981;
            --text: #1c1c1c;
            --text-light: #6b7280;
            --text-secondary: #666;
            --border: #e5e7eb;
            --bg-app: #f9fafb;
            --bg-light: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
        }

        .dashboard-wrapper {
            background: var(--bg-app);
            min-height: 100vh;
            padding: 24px;
        }

        /* Header Sticky */
        .dashboard-header {
            background: var(--bg-light);
            border-bottom: 1px solid var(--border);
            padding: 20px 0;
            margin-bottom: 32px;
            border-radius: 12px;
            position: sticky;
            top: 0;
            z-index: 10;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .dashboard-header-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
        }

        .dashboard-title {
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: #585858;
        }

        .dashboard-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .search-box {
            position: relative;
            display: none;
        }

        .search-box.visible {
            display: block;
        }

        .search-input {
            padding: 8px 12px 8px 36px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.875rem;
            width: 250px;
            background: var(--bg-app);
            color: var(--text);
            transition: all 0.2s ease;
        }

        .search-input::placeholder {
            color: var(--text-light);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--jade);
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            font-size: 0.875rem;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: linear-gradient(135deg, #047857 0%, #059669 50%, #10b981 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .btn-action::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.35) 50%, transparent);
            transition: left 0.5s ease;
        }

        .btn-action:hover::before {
            left: 100%;
        }

        .btn-action:hover {
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.35);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: transparent;
            color: var(--text-light);
            border: 1px solid var(--border);
            box-shadow: none;
        }

        .btn-secondary:hover {
            background: var(--bg-app);
            border-color: var(--jade);
            color: var(--jade);
        }

        /* Main Content */
        .dashboard-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 48px;
        }

        .stat-card {
            background: var(--bg-light);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
            transition: left 0.5s ease;
        }

        .stat-card:hover {
            border-color: var(--jade);
            box-shadow: 0 8px 24px rgba(5, 150, 105, 0.12);
            transform: translateY(-2px);
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-light);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            background: rgba(5, 150, 105, 0.1);
            color: var(--jade);
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1);
            background: rgba(5, 150, 105, 0.15);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 8px;
        }

        .stat-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 12px;
            background: rgba(5, 150, 105, 0.1);
            color: var(--jade);
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Table Section */
        .table-section {
            background: var(--bg-light);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            background: var(--bg-app);
        }

        .table-title {
            font-weight: 600;
            color: var(--text);
            font-size: 0.95rem;
        }

        .table-actions {
            display: flex;
            gap: 8px;
        }

        .table-content {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: var(--bg-app);
            border-bottom: 1px solid var(--border);
        }

        th {
            padding: 12px 16px;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-light);
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background-color 0.2s ease;
        }

        tbody tr:hover {
            background: var(--bg-app);
        }

        td {
            padding: 16px;
            font-size: 0.875rem;
            color: var(--text);
        }

        .table-avatar {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(5, 150, 105, 0.1);
            color: var(--jade);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .table-cell-flex {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .table-cell-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .table-cell-name {
            font-weight: 600;
            color: var(--text);
        }

        .table-cell-email {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-pulse {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #10b981;
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: none;
            background: transparent;
            color: var(--text-light);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .btn-icon:hover {
            background: var(--bg-app);
            color: var(--jade);
        }

        .plan-badge {
            padding: 4px 12px;
            background: var(--bg-app);
            color: var(--text-light);
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1px solid var(--border);
        }

        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            background: var(--bg-app);
            font-size: 0.75rem;
            color: var(--text-light);
        }

        .pagination-controls {
            display: flex;
            gap: 8px;
        }

        .pagination-btn {
            padding: 6px 12px;
            border: 1px solid var(--border);
            background: var(--bg-light);
            color: var(--text-light);
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .pagination-btn:hover:not(:disabled) {
            border-color: var(--jade);
            color: var(--jade);
            background: var(--bg-app);
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Empty State */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 24px;
            text-align: center;
        }

        .empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 12px;
            background: rgba(5, 150, 105, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--text-light);
            margin-bottom: 16px;
        }

        .empty-title {
            font-weight: 600;
            color: var(--text);
            margin-bottom: 8px;
        }

        .empty-description {
            font-size: 0.875rem;
            color: var(--text-light);
            margin-bottom: 24px;
        }

        .empty-action {
            color: var(--jade);
            font-weight: 600;
            text-decoration: none;
            font-size: 0.875rem;
            transition: opacity 0.2s ease;
        }

        .empty-action:hover {
            opacity: 0.7;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-header-content {
                flex-direction: column;
                gap: 16px;
            }

            .search-box.visible {
                width: 100%;
            }

            .search-input {
                width: 100%;
            }

            .dashboard-actions {
                flex-wrap: wrap;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .table-header {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
            }

            .table-actions {
                width: 100%;
                justify-content: flex-start;
            }

            th, td {
                padding: 12px;
                font-size: 0.75rem;
            }

            .table-cell-flex {
                gap: 8px;
            }

            .pagination-controls {
                gap: 4px;
            }
        }
    </style>

    <div class="dashboard-wrapper">
        

        <!-- Main Content -->
        <div class="dashboard-content">
            <!-- Statistics Grid -->
            <div class="stats-grid">
                <!-- Empresas Totales -->
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <p class="stat-label">Empresas Totales</p>
                            <div class="stat-number">{{ \App\Models\Tenant::count() }}</div>
                            <span class="stat-badge">
                                <i class="fa-solid fa-arrow-trend-up"></i>
                                +12% mes
                            </span>
                        </div>
                        <div class="stat-icon">
                            <i class="fa-regular fa-building"></i>
                        </div>
                    </div>
                </div>

                <!-- Usuarios Admin -->
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <p class="stat-label">Usuarios Admin</p>
                            <div class="stat-number">{{ \App\Models\User::count() }}</div>
                            <span class="stat-badge">
                                Activos en plataforma
                            </span>
                        </div>
                        <div class="stat-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                </div>

                <!-- Tickets Soporte -->
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <p class="stat-label">Tickets Soporte</p>
                            <div class="stat-number">3</div>
                            <span class="stat-badge" style="background: rgba(217, 119, 6, 0.1); color: #d97706;">
                                Pendientes
                            </span>
                        </div>
                        <div class="stat-icon" style="background: rgba(217, 119, 6, 0.1); color: #d97706;">
                            <i class="fa-regular fa-life-ring"></i>
                        </div>
                    </div>
                </div>

                <!-- Estado Sistema -->
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <p class="stat-label">Estado Sistema</p>
                            <div class="stat-number" style="color: #10b981;">Operativo</div>
                            <span class="stat-badge" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                <i class="fa-solid fa-check-circle"></i>
                                Ping: 24ms
                            </span>
                        </div>
                        <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                            <i class="fa-solid fa-server"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="table-section">
                <div class="table-header">
                    <h2 class="table-title">Directorio de Empresas</h2>
                    <div class="table-actions">
                        <button class="btn-action btn-secondary">
                            <i class="fa-solid fa-filter"></i>
                            Filtrar
                        </button>
                        <button class="btn-action btn-secondary">
                            <i class="fa-solid fa-download"></i>
                            Exportar
                        </button>
                    </div>
                </div>
                <div class="dashboard-header">
            <div class="dashboard-header-content">
               
                
                <div class="dashboard-actions text-align-left">
                    <div class="search-box visible">
                        <input 
                            type="text" 
                            class="search-input" 
                            placeholder="Buscar empresa..."
                        >
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    </div>
                    
                    <a href="{{ route('superadmin.tenants.create') }}" class="btn-action">
                        <i class="fa-solid fa-plus"></i>
                        Nueva Empresa
                    </a>
                </div>
            </div>
        </div>

                <div class="table-content">
                    <table>
                        <thead>
                            <tr>
                                <th>Empresa</th>
                                <th>Administrador</th>
                                <th>Plan</th>
                                <th style="text-align: center;">Estado</th>
                                <th style="text-align: right;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Tenant::with('users')->latest()->take(10)->get() as $tenant)
                            <tr>
                                <td>
                                    <div class="table-cell-flex">
                                        <div class="table-avatar">
                                            {{ strtoupper(substr($tenant->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="table-cell-name">{{ $tenant->name }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="table-cell-flex">
                                        <i class="fa-solid fa-circle-user" style="color: var(--text-light); font-size: 1.25rem;"></i>
                                        <div class="table-cell-info">
                                            <span class="table-cell-name">
                                                {{ $tenant->users->first()->name ?? 'Sin Asignar' }}
                                            </span>
                                            <span class="table-cell-email">
                                                {{ $tenant->users->first()->email ?? '' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="plan-badge">
                                        {{ $tenant->domain ?? 'Plan Normal' }}
                                    </span>
                                </td>

                                <td style="text-align: center;">
                                    <span class="status-badge">
                                        <div class="status-pulse"></div>
                                        Activo
                                    </span>
                                </td>

                                <td style="text-align: right;">
                                    <button class="btn-icon">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fa-solid fa-folder-open"></i>
                                        </div>
                                        <h3 class="empty-title">No hay empresas registradas</h3>
                                        <p class="empty-description">La base de datos está vacía.</p>
                                        <a href="{{ route('superadmin.tenants.create') }}" class="empty-action">
                                            Crear la primera empresa
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="table-footer">
                    <div>
                        Mostrando <strong>1</strong> a <strong>10</strong> de <strong>{{ \App\Models\Tenant::count() }}</strong> resultados
                    </div>
                    <div class="pagination-controls">
                        <button class="pagination-btn" disabled>Anterior</button>
                        <button class="pagination-btn">Siguiente</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>