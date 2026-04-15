<x-tenant-layout>
    <x-slot:title>Dashboard</x-slot:title>
    <x-slot:header>Dashboard</x-slot:header>

    @push('styles')
    <style>
        .trial-banner { display: flex; align-items: center; justify-content: space-between; padding: 12px 20px; background: var(--jade-50); border: 1px solid var(--jade-100); border-radius: 10px; margin-bottom: 24px; }
        .trial-text { font-size: 0.82rem; font-weight: 500; color: var(--jade-dark); }
        .trial-text span { font-weight: 700; }
        .trial-plan { font-size: 0.75rem; color: var(--jade); }
        .btn-plan { padding: 8px 20px; background: var(--jade); color: #fff; border: none; border-radius: 8px; font-size: 0.78rem; font-weight: 600; font-family: inherit; cursor: pointer; text-decoration: none; }

        .stats-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; margin-bottom: 24px; }
        .stat-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; padding: 16px 20px; }
        .stat-label { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-light); }
        .stat-value { font-size: 1.5rem; font-weight: 700; color: var(--text); margin-top: 4px; }
        .stat-sub { font-size: 0.68rem; color: var(--text-light); margin-top: 2px; }
        .stat-value-jade { color: var(--jade); }

        .content-grid { display: grid; grid-template-columns: 1.5fr 1fr; gap: 20px; margin-bottom: 24px; }
        .dash-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
        .dash-card-header { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--border); }
        .dash-card-title { font-size: 0.82rem; font-weight: 600; color: var(--text); }
        .dash-card-body { padding: 16px 20px; }

        .chart-container { height: 200px; }

        .alert-item { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid #f3f4f6; font-size: 0.78rem; }
        .alert-item:last-child { border-bottom: none; }
        .alert-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
        .alert-dot.red { background: #ef4444; }
        .alert-dot.amber { background: #f59e0b; }
        .alert-name { font-weight: 600; color: var(--text); flex: 1; }
        .alert-stock { font-weight: 600; color: #dc2626; font-size: 0.75rem; }

        .activity-item { display: flex; align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid #f3f4f6; font-size: 0.78rem; }
        .activity-item:last-child { border-bottom: none; }
        .activity-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; }
        .activity-icon.entry { background: #dcfce7; color: #16a34a; }
        .activity-icon.exit { background: #fee2e2; color: #dc2626; }
        .activity-icon.other { background: #f3f4f6; color: #6b7280; }
        .activity-meta { font-size: 0.68rem; color: var(--text-light); margin-top: 2px; }
        .badge { display: inline-flex; padding: 2px 8px; border-radius: 50px; font-size: 0.6rem; font-weight: 600; }
        .badge-green { background: #dcfce7; color: #16a34a; }
        .badge-red { background: #fee2e2; color: #dc2626; }

        .empty-state { padding: 24px; text-align: center; font-size: 0.82rem; color: var(--text-light); }

        .quick-actions { display: flex; gap: 10px; margin-bottom: 24px; }
        .quick-action { padding: 10px 20px; background: #fff; border: 1px solid var(--border); border-radius: 8px; font-size: 0.78rem; font-weight: 600; font-family: inherit; color: var(--text-secondary); text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.15s; }
        .quick-action:hover { border-color: var(--jade); color: var(--jade); }
        .quick-action svg { width: 16px; height: 16px; }

        @media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(3, 1fr); } .content-grid { grid-template-columns: 1fr; } }
        @media (max-width: 640px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } .quick-actions { flex-wrap: wrap; } }
    </style>
    @endpush

    {{-- Trial banner --}}
    @if($trialDaysLeft !== null)
        <div class="trial-banner">
            <div>
                <div class="trial-text">Tu prueba gratuita termina en <span>{{ $trialDaysLeft }} días</span></div>
                <div class="trial-plan">Plan actual: {{ $plan?->name }}</div>
            </div>
        </div>
    @endif

    {{-- Quick Actions --}}
    <div class="quick-actions">
        <a href="{{ route('tenant.movements.create-receiving') }}" class="quick-action">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 4.5l-15 15m0 0h11.25m-11.25 0V8.25"/></svg>
            Nueva recepción
        </a>
        <a href="{{ route('tenant.movements.create-dispatch') }}" class="quick-action">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25"/></svg>
            Nuevo despacho
        </a>
        <a href="{{ route('tenant.products.create') }}" class="quick-action">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Agregar producto
        </a>
        <a href="{{ route('tenant.stock.index') }}" class="quick-action">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z"/></svg>
            Ver existencias
        </a>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Almacenes</div>
            <div class="stat-value">{{ $stats['warehouses'] }}</div>
            <div class="stat-sub">de {{ $stats['warehouses_limit'] }} permitidos</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Productos</div>
            <div class="stat-value">{{ number_format($stats['products']) }}</div>
            <div class="stat-sub">de {{ number_format($stats['products_limit']) }} permitidos</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Unidades en stock</div>
            <div class="stat-value stat-value-jade">{{ number_format($stats['total_units']) }}</div>
            <div class="stat-sub">en todos los almacenes</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Valor del inventario</div>
            <div class="stat-value">${{ number_format($stats['inventory_value'], 0) }}</div>
            <div class="stat-sub">MXN a costo</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Movimientos hoy</div>
            <div class="stat-value">{{ $stats['movements_today'] }}</div>
            <div class="stat-sub">entradas y salidas</div>
        </div>
    </div>

    {{-- Chart + Alerts --}}
    <div class="content-grid">
        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">Movimientos — últimos 14 días</span>
                <div style="display:flex; gap:12px; font-size:0.68rem;">
                    <span style="display:flex; align-items:center; gap:4px;"><span style="width:8px;height:8px;border-radius:2px;background:var(--jade);"></span> Entradas</span>
                    <span style="display:flex; align-items:center; gap:4px;"><span style="width:8px;height:8px;border-radius:2px;background:#e5e7eb;"></span> Salidas</span>
                </div>
            </div>
            <div class="dash-card-body">
                <div class="chart-container">
                    <canvas id="movementsChart"></canvas>
                </div>
            </div>
        </div>

        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">Stock bajo</span>
                @if($lowStockAlerts->count() > 0)
                    <a href="{{ route('tenant.stock.index', ['low_stock' => 1]) }}" style="font-size:0.72rem; color:var(--jade); text-decoration:none;">Ver todos</a>
                @endif
            </div>
            <div class="dash-card-body">
                @forelse($lowStockAlerts as $product)
                    <div class="alert-item">
                        <div class="alert-dot red"></div>
                        <span class="alert-name">{{ $product->name }}</span>
                        <span class="alert-stock">{{ $product->sku }}</span>
                    </div>
                @empty
                    <div class="empty-state">Sin alertas de stock bajo</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Activity --}}
    <div class="dash-card">
        <div class="dash-card-header">
            <span class="dash-card-title">Actividad reciente</span>
            <a href="{{ route('tenant.movements.index') }}" style="font-size:0.72rem; color:var(--jade); text-decoration:none;">Ver historial completo</a>
        </div>
        <div class="dash-card-body">
            @forelse($recentMovements as $movement)
                @php
                    $isEntry = in_array($movement->type, ['receiving', 'transfer_in', 'return']);
                    $typeLabels = [
                        'receiving' => 'Recepción', 'dispatch' => 'Despacho', 'adjustment' => 'Ajuste',
                        'transfer_out' => 'Transfer. salida', 'transfer_in' => 'Transfer. entrada',
                        'return' => 'Devolución', 'cycle_count' => 'Conteo',
                    ];
                @endphp
                <div class="activity-item">
                    <div class="activity-icon {{ $isEntry ? 'entry' : 'exit' }}">
                        @if($isEntry) ↓ @else ↑ @endif
                    </div>
                    <div style="flex:1;">
                        <div>
                            <span class="badge {{ $isEntry ? 'badge-green' : 'badge-red' }}">{{ $typeLabels[$movement->type] ?? 'Movimiento' }}</span>
                            @if($movement->reference) <span style="font-size:0.75rem; color:var(--text-secondary); margin-left:4px;">{{ $movement->reference }}</span> @endif
                        </div>
                        <div class="activity-meta">{{ $movement->warehouse?->name }} · {{ $movement->user?->name }} · {{ $movement->created_at->diffForHumans() }}</div>
                    </div>
                    <a href="{{ route('tenant.movements.show', $movement) }}" style="font-size:0.72rem; color:var(--jade); text-decoration:none;">Detalle</a>
                </div>
            @empty
                <div class="empty-state">Aún no hay movimientos registrados. Haz tu primera entrada de mercancía para comenzar.</div>
            @endforelse
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('movementsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartData->pluck('date')),
                datasets: [
                    {
                        label: 'Entradas',
                        data: @json($chartData->pluck('entries')),
                        backgroundColor: 'rgba(5, 150, 105, 0.7)',
                        borderRadius: 4,
                    },
                    {
                        label: 'Salidas',
                        data: @json($chartData->pluck('exits')),
                        backgroundColor: 'rgba(229, 231, 235, 0.8)',
                        borderRadius: 4,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 } }, grid: { color: '#f3f4f6' } },
                    x: { ticks: { font: { size: 10 } }, grid: { display: false } },
                },
                plugins: { legend: { display: false } },
            },
        });
    </script>
    @endpush
</x-tenant-layout>
