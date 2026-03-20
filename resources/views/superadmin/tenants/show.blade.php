<x-superadmin-layout>
    <x-slot:title>{{ $tenant->company_name }}</x-slot:title>

    <div class="sa-page-header" style="display:flex; justify-content:space-between; align-items:flex-start;">
        <div>
            <div class="sa-page-title">{{ $tenant->company_name }}</div>
            <div class="sa-page-subtitle">
                @if($tenant->rfc) RFC: {{ $tenant->rfc }} · @endif
                Registrado {{ $tenant->created_at->format('d/m/Y H:i') }}
                · @if($tenant->is_active) <span class="sa-badge sa-badge-green">Activo</span> @else <span class="sa-badge sa-badge-red">Inactivo</span> @endif
            </div>
        </div>
        <div style="display:flex; gap:8px;">
            <a href="{{ route('superadmin.tenants.index') }}" class="sa-btn">Volver</a>
            <form action="{{ route('superadmin.tenants.toggle', $tenant) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="sa-btn {{ $tenant->is_active ? 'sa-btn-danger' : 'sa-btn-primary' }}">
                    {{ $tenant->is_active ? 'Desactivar tenant' : 'Activar tenant' }}
                </button>
            </form>
        </div>
    </div>

    <div class="sa-stats" style="grid-template-columns: repeat(3, 1fr);">
        <div class="sa-stat">
            <div class="sa-stat-label">Usuarios</div>
            <div class="sa-stat-value">{{ $stats['users'] }}</div>
        </div>
        <div class="sa-stat">
            <div class="sa-stat-label">Almacenes</div>
            <div class="sa-stat-value">{{ $stats['warehouses'] }}</div>
        </div>
        <div class="sa-stat">
            <div class="sa-stat-label">Productos</div>
            <div class="sa-stat-value">{{ number_format($stats['products']) }}</div>
        </div>
        <div class="sa-stat">
            <div class="sa-stat-label">Unidades en stock</div>
            <div class="sa-stat-value accent">{{ number_format($stats['total_units']) }}</div>
        </div>
        <div class="sa-stat">
            <div class="sa-stat-label">Movimientos totales</div>
            <div class="sa-stat-value">{{ number_format($stats['total_movements']) }}</div>
        </div>
        <div class="sa-stat">
            <div class="sa-stat-label">Movimientos este mes</div>
            <div class="sa-stat-value">{{ number_format($stats['movements_this_month']) }}</div>
        </div>
    </div>

    <div class="sa-grid-2">
        {{-- Suscripción --}}
        <div class="sa-card">
            <div class="sa-card-header"><span class="sa-card-title">Suscripción</span></div>
            <div class="sa-card-body">
                @php $sub = $tenant->subscriptions->first(); @endphp
                @if($sub)
                    <div style="display:flex; flex-direction:column; gap:8px; font-size:0.82rem;">
                        <div style="display:flex; justify-content:space-between;"><span style="color:var(--sa-text-light);">Plan</span><span style="font-weight:600;">{{ $sub->plan?->name }}</span></div>
                        <div style="display:flex; justify-content:space-between;"><span style="color:var(--sa-text-light);">Estado</span>
                            @if($sub->status === 'trialing')
                                <span class="sa-badge sa-badge-amber">Trial</span>
                            @elseif($sub->status === 'active')
                                <span class="sa-badge sa-badge-green">Activo</span>
                            @else
                                <span class="sa-badge sa-badge-gray">{{ $sub->status }}</span>
                            @endif
                        </div>
                        @if($sub->trial_ends_at)
                            <div style="display:flex; justify-content:space-between;"><span style="color:var(--sa-text-light);">Trial termina</span><span>{{ $sub->trial_ends_at->format('d/m/Y') }}</span></div>
                        @endif
                        <div style="display:flex; justify-content:space-between;"><span style="color:var(--sa-text-light);">Precio</span><span>${{ number_format($sub->plan?->price_monthly, 0) }} MXN/mes</span></div>
                    </div>
                @else
                    <div class="sa-empty">Sin suscripción</div>
                @endif
            </div>
        </div>

        {{-- Usuarios --}}
        <div class="sa-card">
            <div class="sa-card-header"><span class="sa-card-title">Usuarios</span></div>
            <div class="sa-card-body" style="padding:0;">
                <table class="sa-table">
                    <thead><tr><th>Nombre</th><th>Email</th><th>Activo</th></tr></thead>
                    <tbody>
                    @forelse($tenant->users as $user)
                        <tr>
                            <td style="font-weight:600;">{{ $user->name }}</td>
                            <td style="font-size:0.75rem;">{{ $user->email }}</td>
                            <td>
                                @if($user->is_active) <span class="sa-badge sa-badge-green">Sí</span>
                                @else <span class="sa-badge sa-badge-red">No</span> @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="sa-empty">Sin usuarios</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Movimientos recientes --}}
    <div class="sa-card">
        <div class="sa-card-header"><span class="sa-card-title">Últimos movimientos</span></div>
        <div class="sa-card-body" style="padding:0;">
            <table class="sa-table">
                <thead><tr><th>Tipo</th><th>Referencia</th><th>Almacén</th><th>Usuario</th><th>Estado</th><th>Fecha</th></tr></thead>
                <tbody>
                @forelse($recentMovements as $m)
                    @php
                        $typeMap = ['receiving'=>['Recepción','sa-badge-green'],'dispatch'=>['Despacho','sa-badge-red'],'adjustment'=>['Ajuste','sa-badge-amber'],'transfer_out'=>['Transfer.','sa-badge-blue'],'transfer_in'=>['Transfer.','sa-badge-blue'],'return'=>['Devolución','sa-badge-amber']];
                        $t = $typeMap[$m->type] ?? ['Movimiento','sa-badge-gray'];
                    @endphp
                    <tr>
                        <td><span class="sa-badge {{ $t[1] }}">{{ $t[0] }}</span></td>
                        <td style="font-size:0.78rem;">{{ $m->reference ?? '—' }}</td>
                        <td style="font-size:0.78rem;">{{ $m->warehouse?->name }}</td>
                        <td style="font-size:0.78rem;">{{ $m->user?->name }}</td>
                        <td><span class="sa-badge {{ $m->status === 'completed' ? 'sa-badge-green' : 'sa-badge-gray' }}">{{ $m->status }}</span></td>
                        <td style="font-size:0.72rem; color:var(--sa-text-light);">{{ $m->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="sa-empty">Sin movimientos</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-superadmin-layout>
