<x-superadmin-layout>
    <x-slot:title>Tenants</x-slot:title>

    <div class="sa-page-header">
        <div class="sa-page-title">Gestión de tenants</div>
        <div class="sa-page-subtitle">Empresas registradas en la plataforma</div>
    </div>

    <form method="GET" action="{{ route('superadmin.tenants.index') }}" class="sa-filters">
        <input type="text" name="search" class="sa-filter-input" placeholder="Buscar por empresa o RFC..." value="{{ request('search') }}">
        <select name="status" class="sa-filter-select" onchange="this.form.submit()">
            <option value="">Todos los estados</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activos</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivos</option>
        </select>
        <select name="plan" class="sa-filter-select" onchange="this.form.submit()">
            <option value="">Todos los planes</option>
            <option value="starter" {{ request('plan') === 'starter' ? 'selected' : '' }}>Starter</option>
            <option value="profesional" {{ request('plan') === 'profesional' ? 'selected' : '' }}>Profesional</option>
            <option value="enterprise" {{ request('plan') === 'enterprise' ? 'selected' : '' }}>Enterprise</option>
        </select>
        <button type="submit" class="sa-btn">Buscar</button>
        @if(request()->hasAny(['search','status','plan']))
            <a href="{{ route('superadmin.tenants.index') }}" class="sa-btn">Limpiar</a>
        @endif
    </form>

    <div class="sa-card">
        @if($tenants->count() > 0)
            <table class="sa-table">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Plan</th>
                        <th>Estado</th>
                        <th>Días restantes</th>
                        <th>Usuarios</th>
                        <th>Almacenes</th>
                        <th>Activo</th>
                        <th>Registro</th>
                        <th style="text-align:right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tenants as $tenant)
                    @php
                        $sub = $tenant->subscriptions->first();
                        $isTrialing = $sub?->status === 'trialing';
                        $trialExpired = $isTrialing && $sub?->trial_ends_at?->isPast();
                        $daysLeft = $isTrialing && !$trialExpired ? (int) now()->diffInDays($sub->trial_ends_at, false) : null;
                    @endphp
                    <tr>
                        <td>
                            <a href="{{ route('superadmin.tenants.show', $tenant) }}" style="font-weight:600; color:var(--sa-text);">{{ $tenant->company_name }}</a>
                            @if($tenant->rfc)<div style="font-size:0.68rem; color:var(--sa-text-light);">{{ $tenant->rfc }}</div>@endif
                        </td>
                        <td><span class="sa-badge sa-badge-blue">{{ $sub?->plan?->name ?? '—' }}</span></td>
                        <td>
                            @if($trialExpired)
                                <span class="sa-badge sa-badge-red">Trial expirado</span>
                            @elseif($isTrialing)
                                <span class="sa-badge sa-badge-amber">Trial</span>
                            @elseif($sub?->status === 'active')
                                <span class="sa-badge sa-badge-green">Activo</span>
                            @else
                                <span class="sa-badge sa-badge-gray">{{ $sub?->status ?? '—' }}</span>
                            @endif
                        </td>
                        <td style="font-size:0.78rem; text-align:center;">
                            @if($trialExpired)
                                <span style="color:#f87171; font-weight:600;">Expirado</span>
                            @elseif($daysLeft !== null)
                                <span style="color:{{ $daysLeft <= 3 ? '#f87171' : ($daysLeft <= 5 ? '#fbbf24' : '#34d399') }}; font-weight:600;">{{ $daysLeft }}d</span>
                            @elseif($sub?->status === 'active')
                                <span style="color:var(--sa-text-light);">—</span>
                            @else
                                <span style="color:var(--sa-text-light);">—</span>
                            @endif
                        </td>
                        <td style="font-size:0.78rem;">{{ $tenant->users_count }}</td>
                        <td style="font-size:0.78rem;">{{ $tenant->warehouses_count }}</td>
                        <td>
                            @if($tenant->is_active)
                                <span class="sa-badge sa-badge-green">Sí</span>
                            @else
                                <span class="sa-badge sa-badge-red">No</span>
                            @endif
                        </td>
                        <td style="font-size:0.72rem; color:var(--sa-text-light);">{{ $tenant->created_at->format('d/m/Y') }}</td>
                        <td style="text-align:right;">
                            <div style="display:flex; gap:6px; justify-content:flex-end;">
                                <a href="{{ route('superadmin.tenants.show', $tenant) }}" class="sa-btn">Ver</a>
                                <form action="{{ route('superadmin.tenants.toggle', $tenant) }}" method="POST"
                                      onsubmit="return confirm('¿Estás seguro de {{ $tenant->is_active ? 'DESACTIVAR' : 'activar' }} a {{ $tenant->company_name }}?{{ $tenant->is_active ? ' Sus usuarios no podrán acceder al sistema.' : '' }}')">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="sa-btn {{ $tenant->is_active ? 'sa-btn-danger' : '' }}">
                                        {{ $tenant->is_active ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if($tenants->hasPages())
                <div style="padding:12px 16px; border-top:1px solid var(--sa-border);">{{ $tenants->links() }}</div>
            @endif
        @else
            <div class="sa-empty">No se encontraron tenants.</div>
        @endif
    </div>
</x-superadmin-layout>
