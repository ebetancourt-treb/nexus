<x-superadmin-layout>
    <x-slot:title>Dashboard</x-slot:title>

    <div class="sa-page-header">
        <div class="sa-page-title">Panel de plataforma</div>
        <div class="sa-page-subtitle">Métricas globales de BlumOps · {{ now()->format('d M Y') }}</div>
    </div>

    <div class="sa-stats">
        <div class="sa-stat">
            <div class="sa-stat-label">Tenants</div>
            <div class="sa-stat-value">{{ $totalTenants }}</div>
            <div class="sa-stat-sub">{{ $activeTenants }} activos</div>
        </div>
        <div class="sa-stat">
            <div class="sa-stat-label">Usuarios</div>
            <div class="sa-stat-value">{{ $totalUsers }}</div>
            <div class="sa-stat-sub">en toda la plataforma</div>
        </div>
        <div class="sa-stat">
            <div class="sa-stat-label">MRR</div>
            <div class="sa-stat-value accent">${{ number_format($mrr, 0) }}</div>
            <div class="sa-stat-sub">MXN recurrente mensual</div>
        </div>
        <div class="sa-stat">
            <div class="sa-stat-label">Trials activos</div>
            <div class="sa-stat-value">{{ $activeTrials }}</div>
            <div class="sa-stat-sub">{{ $trialsExpiringSoon }} vencen en 7 días · {{ $expiredTrials }} expirados</div>
        </div>
    </div>

    <div class="sa-stats" style="grid-template-columns: repeat(3, 1fr);">
        <div class="sa-stat">
            <div class="sa-stat-label">Movimientos hoy</div>
            <div class="sa-stat-value">{{ number_format($movementsToday) }}</div>
        </div>
        <div class="sa-stat">
            <div class="sa-stat-label">Movimientos mes</div>
            <div class="sa-stat-value">{{ number_format($movementsThisMonth) }}</div>
        </div>
        <div class="sa-stat">
            <div class="sa-stat-label">Productos registrados</div>
            <div class="sa-stat-value">{{ number_format($totalProducts) }}</div>
        </div>
    </div>

    <div class="sa-grid-2">
        <div class="sa-card">
            <div class="sa-card-header"><span class="sa-card-title">Registros — últimos 30 días</span></div>
            <div class="sa-card-body"><canvas id="regChart" height="180"></canvas></div>
        </div>

        <div class="sa-card">
            <div class="sa-card-header">
                <span class="sa-card-title">Tenants recientes</span>
                <a href="{{ route('superadmin.tenants.index') }}" style="font-size:0.72rem; color:var(--sa-accent);">Ver todos</a>
            </div>
            <div class="sa-card-body" style="padding:0;">
                <table class="sa-table">
                    <thead><tr><th>Empresa</th><th>Plan</th><th>Usuarios</th><th>Fecha</th></tr></thead>
                    <tbody>
                    @forelse($recentTenants as $t)
                        @php $sub = $t->subscriptions->first(); @endphp
                        <tr>
                            <td><a href="{{ route('superadmin.tenants.show', $t) }}" style="color:var(--sa-text); font-weight:600;">{{ $t->company_name }}</a></td>
                            <td>
                                @if($sub?->status === 'trialing')
                                    <span class="sa-badge sa-badge-amber">Trial</span>
                                @else
                                    <span class="sa-badge sa-badge-green">{{ $sub?->plan?->name ?? '—' }}</span>
                                @endif
                            </td>
                            <td style="font-size:0.75rem;">{{ $t->users_count }}</td>
                            <td style="font-size:0.72rem; color:var(--sa-text-light);">{{ $t->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="sa-empty">Sin tenants registrados</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        new Chart(document.getElementById('regChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json($chartData->pluck('date')),
                datasets: [{
                    label: 'Registros',
                    data: @json($chartData->pluck('total')),
                    backgroundColor: 'rgba(5, 150, 105, 0.6)',
                    borderRadius: 4,
                }],
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1, color: '#64748b', font: { size: 10 } }, grid: { color: '#1e293b' } },
                    x: { ticks: { color: '#64748b', font: { size: 9 }, maxRotation: 45 }, grid: { display: false } },
                },
                plugins: { legend: { display: false } },
            },
        });
    </script>
    @endpush
</x-superadmin-layout>
