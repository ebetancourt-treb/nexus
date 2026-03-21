<x-superadmin-layout>
    <x-slot:title>Audit Log</x-slot:title>

    <div class="sa-page-header">
        <div class="sa-page-title">Audit Log</div>
        <div class="sa-page-subtitle">Registro de actividad en toda la plataforma</div>
    </div>

    <form method="GET" action="{{ route('superadmin.audit-logs.index') }}" class="sa-filters">
        <input type="text" name="search" class="sa-filter-input" placeholder="Buscar por acción, entidad o usuario..." value="{{ request('search') }}">
        <button type="submit" class="sa-btn">Buscar</button>
        @if(request('search'))
            <a href="{{ route('superadmin.audit-logs.index') }}" class="sa-btn">Limpiar</a>
        @endif
    </form>

    <div class="sa-card">
        @if($logs->count() > 0)
            <table class="sa-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tenant</th>
                        <th>Usuario</th>
                        <th>Acción</th>
                        <th>Entidad</th>
                        <th>ID</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td style="font-size:0.72rem; color:var(--sa-text-light); white-space:nowrap;">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                        <td style="font-size:0.78rem;">{{ $log->tenant?->company_name ?? 'Sistema' }}</td>
                        <td style="font-size:0.78rem;">{{ $log->user?->name ?? '—' }}</td>
                        <td>
                            @php
                                $eventColors = ['created' => 'sa-badge-green', 'updated' => 'sa-badge-blue', 'deleted' => 'sa-badge-red', 'login' => 'sa-badge-amber', 'status_changed' => 'sa-badge-amber'];
                            @endphp
                            <span class="sa-badge {{ $eventColors[$log->event] ?? 'sa-badge-gray' }}">{{ $log->event }}</span>
                        </td>
                        <td style="font-size:0.78rem; color:var(--sa-text-secondary);">{{ class_basename($log->auditable_type) }}</td>
                        <td style="font-size:0.72rem; color:var(--sa-text-light);">{{ $log->auditable_id ?? '—' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if($logs->hasPages())
                <div style="padding:12px 16px; border-top:1px solid var(--sa-border);">{{ $logs->links() }}</div>
            @endif
        @else
            <div class="sa-empty">No hay registros en el audit log aún. Los registros aparecerán conforme los tenants usen la plataforma.</div>
        @endif
    </div>
</x-superadmin-layout>
