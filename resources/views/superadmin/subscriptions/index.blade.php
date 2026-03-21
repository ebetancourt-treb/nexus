<x-superadmin-layout>
    <x-slot:title>Suscripciones</x-slot:title>

    <div class="sa-page-header">
        <div class="sa-page-title">Suscripciones</div>
        <div class="sa-page-subtitle">Gestiona planes y trials de los tenants</div>
    </div>

    <form method="GET" action="{{ route('superadmin.subscriptions.index') }}" class="sa-filters">
        <select name="status" class="sa-filter-select" onchange="this.form.submit()">
            <option value="">Todos los estados</option>
            <option value="trialing" {{ request('status') === 'trialing' ? 'selected' : '' }}>En trial</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activo</option>
            <option value="canceled" {{ request('status') === 'canceled' ? 'selected' : '' }}>Cancelado</option>
        </select>
        <label style="display:flex; align-items:center; gap:6px; font-size:0.78rem; color:var(--sa-text-secondary); cursor:pointer;">
            <input type="checkbox" name="expiring" value="1" {{ request('expiring') ? 'checked' : '' }} onchange="this.form.submit()">
            Solo trials por vencer (7 días)
        </label>
        @if(request()->hasAny(['status','expiring']))
            <a href="{{ route('superadmin.subscriptions.index') }}" class="sa-btn">Limpiar</a>
        @endif
    </form>

    <div class="sa-card">
        @if($subscriptions->count() > 0)
            <table class="sa-table">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Plan actual</th>
                        <th>Estado</th>
                        <th>Trial termina</th>
                        <th>Cambiar plan</th>
                        <th style="text-align:right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($subscriptions as $sub)
                    @php
                        $isTrialing = $sub->status === 'trialing';
                        $trialExpired = $isTrialing && $sub->trial_ends_at?->isPast();
                        $daysLeft = $isTrialing && !$trialExpired ? (int) now()->diffInDays($sub->trial_ends_at, false) : null;
                    @endphp
                    <tr>
                        <td>
                            <a href="{{ route('superadmin.tenants.show', $sub->tenant) }}" style="font-weight:600; color:var(--sa-text);">{{ $sub->tenant?->company_name }}</a>
                        </td>
                        <td><span class="sa-badge sa-badge-blue">{{ $sub->plan?->name }}</span></td>
                        <td>
                            @if($trialExpired)
                                <span class="sa-badge sa-badge-red">Expirado</span>
                            @elseif($isTrialing)
                                <span class="sa-badge sa-badge-amber">Trial · {{ $daysLeft }}d</span>
                            @elseif($sub->status === 'active')
                                <span class="sa-badge sa-badge-green">Activo</span>
                            @else
                                <span class="sa-badge sa-badge-gray">{{ $sub->status }}</span>
                            @endif
                        </td>
                        <td style="font-size:0.75rem; color:var(--sa-text-light);">
                            @if($sub->trial_ends_at)
                                {{ $sub->trial_ends_at->format('d/m/Y') }}
                                @if($isTrialing && !$trialExpired)
                                    <div style="font-size:0.68rem; color:{{ $daysLeft <= 3 ? '#f87171' : '#fbbf24' }}; font-weight:600;">{{ $daysLeft }} días restantes</div>
                                @elseif($trialExpired)
                                    <div style="font-size:0.68rem; color:#f87171; font-weight:600;">Expirado</div>
                                @endif
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('superadmin.subscriptions.change-plan', $sub) }}" method="POST" style="display:flex; gap:6px;"
                                  onsubmit="return confirm('¿Cambiar el plan de {{ $sub->tenant?->company_name }} a ' + this.plan_id.options[this.plan_id.selectedIndex].text + '?')">
                                @csrf @method('PATCH')
                                <select name="plan_id" class="sa-filter-select" style="font-size:0.72rem; padding:4px 8px;">
                                    @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}" {{ $sub->plan_id === $plan->id ? 'selected' : '' }}>{{ $plan->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="sa-btn" style="font-size:0.68rem; padding:4px 10px;">Cambiar</button>
                            </form>
                        </td>
                        <td style="text-align:right;">
                            @if($isTrialing)
                                <form action="{{ route('superadmin.subscriptions.extend-trial', $sub) }}" method="POST" style="display:inline;"
                                      onsubmit="return confirm('¿Extender el trial de {{ $sub->tenant?->company_name }} por 7 días más?')">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="sa-btn" title="Extender trial 7 días">+7 días</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if($subscriptions->hasPages())
                <div style="padding:12px 16px; border-top:1px solid var(--sa-border);">{{ $subscriptions->links() }}</div>
            @endif
        @else
            <div class="sa-empty">No se encontraron suscripciones.</div>
        @endif
    </div>
</x-superadmin-layout>
