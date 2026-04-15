<x-tenant-layout>
    <x-slot:title>Plan y facturación</x-slot:title>
    <x-slot:header>Plan y facturación</x-slot:header>

    @push('styles')
    <style>
        .billing-header { margin-bottom:24px; }
        .billing-title { font-family:'Special Gothic Expanded One',sans-serif; font-size:1.1rem; color:#585858; }
        .billing-subtitle { font-size:0.78rem; color:var(--text-secondary); margin-top:4px; }
        .card { background:var(--bg-card); border:1px solid var(--border); border-radius:12px; overflow:hidden; margin-bottom:20px; }
        .card-header { padding:18px 24px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; }
        .card-title { font-size:0.92rem; font-weight:600; }
        .card-body { padding:20px 24px; }
        .badge { display:inline-flex; padding:3px 12px; border-radius:50px; font-size:0.68rem; font-weight:600; }
        .badge-green { background:#dcfce7; color:#16a34a; }
        .badge-amber { background:#fef3c7; color:#d97706; }
        .badge-red { background:#fee2e2; color:#dc2626; }
        .plan-name { font-size:1.1rem; font-weight:700; display:flex; align-items:center; gap:10px; }
        .plan-price { font-size:0.85rem; color:var(--text-secondary); margin-top:4px; }
        .info-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(140px, 1fr)); gap:16px; margin-top:16px; padding-top:16px; border-top:1px solid #f3f4f6; }
        .info-item-label { font-size:0.65rem; font-weight:600; text-transform:uppercase; letter-spacing:0.04em; color:var(--text-light); }
        .info-item-value { font-size:0.88rem; font-weight:600; color:var(--text); margin-top:2px; }
        .actions-row { display:flex; gap:10px; margin-top:16px; padding-top:16px; border-top:1px solid #f3f4f6; flex-wrap:wrap; align-items:center; }
        .btn-portal { display:inline-flex; align-items:center; gap:6px; padding:9px 20px; background:#fff; color:var(--text-secondary); border:1px solid var(--border); border-radius:8px; font-size:0.78rem; font-weight:500; font-family:inherit; cursor:pointer; text-decoration:none; }
        .btn-portal:hover { border-color:var(--jade); color:var(--jade); }
        .btn-primary { padding:9px 20px; background:var(--jade); color:#fff; border:none; border-radius:8px; font-size:0.78rem; font-weight:600; font-family:inherit; cursor:pointer; }
        .btn-cancel-link { background:none; border:none; font-family:inherit; font-size:0.75rem; color:var(--text-light); cursor:pointer; text-decoration:underline; padding:0; }
        .trial-alert { padding:14px 20px; background:#fef3c7; border:1px solid #fcd34d; border-radius:10px; margin-bottom:20px; }
        .trial-alert-text { font-size:0.82rem; color:#92400e; }
        .trial-alert-text strong { color:#78350f; }
        .upgrade-cards { display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:16px; }
        .upgrade-card { border:1px solid var(--border); border-radius:12px; padding:24px; background:var(--bg-card); position:relative; transition:border-color 0.2s; }
        .upgrade-card:hover { border-color:var(--jade); }
        .upgrade-card.recommended { border-color:var(--jade); border-width:2px; }
        .rec-badge { position:absolute; top:-10px; left:50%; transform:translateX(-50%); background:var(--jade); color:#fff; padding:2px 14px; border-radius:50px; font-size:0.65rem; font-weight:700; }
        .upgrade-name { font-size:0.92rem; font-weight:700; }
        .upgrade-price { font-size:1.4rem; font-weight:800; margin:4px 0; }
        .upgrade-price span { font-size:0.75rem; font-weight:400; color:var(--text-secondary); }
        .upgrade-desc { font-size:0.75rem; color:var(--text-secondary); margin-bottom:14px; }
        .upgrade-features { list-style:none; padding:0; margin:0 0 18px; }
        .upgrade-features li { padding:4px 0; font-size:0.78rem; color:var(--text-secondary); padding-left:18px; position:relative; }
        .upgrade-features li::before { content:'✓'; position:absolute; left:0; color:var(--jade); font-weight:700; font-size:0.72rem; }
        .btn-upgrade { display:block; width:100%; padding:10px; text-align:center; border-radius:8px; font-size:0.82rem; font-weight:600; font-family:inherit; cursor:pointer; text-decoration:none; }
        .btn-upgrade-primary { background:var(--jade); color:#fff; border:none; }
        .btn-upgrade-primary:hover { background:var(--jade-dark); }
        .btn-upgrade-outline { background:#fff; color:var(--text-secondary); border:1px solid var(--border); }
        .btn-upgrade-outline:hover { border-color:var(--jade); color:var(--jade); }
        .btn-upgrade-current { background:#f3f4f6; color:var(--text-light); border:none; cursor:default; }
        .flash-success { padding:12px 16px; background:var(--jade-50); border:1px solid var(--jade-100); border-radius:8px; margin-bottom:20px; font-size:0.8rem; font-weight:500; color:var(--jade-dark); }
        .flash-error { padding:12px 16px; background:#fef2f2; border:1px solid #fecaca; border-radius:8px; margin-bottom:20px; font-size:0.8rem; color:#991b1b; }
    </style>
    @endpush

    @if(session('success')) <div class="flash-success">{{ session('success') }}</div> @endif
    @if($errors->any()) <div class="flash-error">{{ $errors->first() }}</div> @endif

    <div class="billing-header">
        <div class="billing-title">Plan y facturación</div>
        <div class="billing-subtitle">Administra tu plan, método de pago y facturación.</div>
    </div>

    @php
        $isTrialing = $subscription?->status === 'trialing';
        $isActive = $subscription?->status === 'active' && $hasStripeSubscription;
        $isPaid = $hasStripeSubscription;
        $currentPlanSlug = $currentPlan?->slug;
        $planOrder = ['starter' => 1, 'profesional' => 2, 'enterprise' => 3];
        $currentOrder = $planOrder[$currentPlanSlug] ?? 0;
    @endphp

    {{-- Alerta de trial --}}
    @if($isTrialing && !$isPaid && $subscription?->trial_ends_at)
        <div class="trial-alert">
            <div class="trial-alert-text">
                <strong>Prueba gratuita</strong> — Tu trial termina el {{ $subscription->trial_ends_at->format('d/m/Y') }}.
                Suscríbete antes para no perder acceso.
            </div>
        </div>
    @endif

    {{-- Plan actual --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Tu plan actual</span>
            @if($isTrialing && !$isPaid)
                <span class="badge badge-amber">Prueba gratuita</span>
            @elseif($isPaid && !$stripeOnGracePeriod)
                <span class="badge badge-green">Activo</span>
            @elseif($stripeOnGracePeriod)
                <span class="badge badge-amber">Se cancela pronto</span>
            @elseif($subscription?->status === 'past_due')
                <span class="badge badge-red">Pago pendiente</span>
            @elseif($subscription?->status === 'canceled')
                <span class="badge badge-red">Cancelado</span>
            @endif
        </div>
        <div class="card-body">
            <div class="plan-name">{{ $currentPlan?->name ?? 'Sin plan' }}</div>
            <div class="plan-price">${{ number_format($currentPlan?->price_monthly ?? 0, 0) }} MXN/mes</div>

            <div class="info-grid">
                <div>
                    <div class="info-item-label">Almacenes</div>
                    <div class="info-item-value">{{ $currentPlan?->max_warehouses == -1 ? 'Ilimitados' : $currentPlan?->max_warehouses ?? '—' }}</div>
                </div>
                <div>
                    <div class="info-item-label">Productos</div>
                    <div class="info-item-value">{{ $currentPlan?->max_skus == -1 ? 'Ilimitados' : number_format($currentPlan?->max_skus ?? 0) }}</div>
                </div>
                <div>
                    <div class="info-item-label">Usuarios</div>
                    <div class="info-item-value">{{ $currentPlan?->max_users == -1 ? 'Ilimitados' : $currentPlan?->max_users ?? '—' }}</div>
                </div>
                @if($isPaid && $subscription?->current_period_end)
                    <div>
                        <div class="info-item-label">Próxima renovación</div>
                        <div class="info-item-value">{{ $subscription->current_period_end->format('d/m/Y') }}</div>
                    </div>
                @endif
            </div>

            @if($isPaid)
                <div class="actions-row">
                    <a href="{{ route('tenant.billing.portal') }}" class="btn-portal">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="width:16px; height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                        Administrar pago y facturas
                    </a>
                    @if($stripeOnGracePeriod)
                        <form action="{{ route('tenant.billing.resume') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-primary">Reactivar plan</button>
                        </form>
                    @else
                        <form action="{{ route('tenant.billing.cancel') }}" method="POST" onsubmit="return confirm('¿Cancelar suscripción? Tu plan seguirá activo hasta el final del período.')">
                            @csrf
                            <button type="submit" class="btn-cancel-link">Cancelar suscripción</button>
                        </form>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Sección de planes / upgrade --}}
    @php
        $featureMap = [
            'starter' => ['Recepción y despacho estándar', 'Scanner / código de barras', 'Dashboard con alertas', 'Soporte por correo'],
            'profesional' => ['Todo lo del Starter', 'Control por lotes y series', 'Recepción multi-lote', 'FIFO / FEFO por almacén', 'Proveedores y OC', 'Soporte prioritario'],
            'enterprise' => ['Todo lo del Profesional', 'Conteos cíclicos y pick lists', 'API para integraciones', 'Consultoría de implementación', 'Soporte dedicado + SLA'],
        ];

        if ($isTrialing && !$isPaid) {
            $showPlans = $plans; // Trial: mostrar todos
            $sectionTitle = 'Elige tu plan';
        } else {
            $showPlans = $plans->filter(fn ($p) => ($planOrder[$p->slug] ?? 0) >= $currentOrder); // Actual + upgrades
            $sectionTitle = $currentOrder < 3 ? 'Mejorar tu plan' : '';
        }
    @endphp

    @if($showPlans->count() > 0 && $sectionTitle)
        <div class="card">
            <div class="card-header"><span class="card-title">{{ $sectionTitle }}</span></div>
            <div class="card-body">
                <div class="upgrade-cards">
                    @foreach($showPlans as $plan)
                        @php
                            $isCurrent = $currentPlan?->id === $plan->id;
                            $isUpgrade = ($planOrder[$plan->slug] ?? 0) > $currentOrder;
                            $isRecommended = $plan->slug === 'profesional' && !$isCurrent;
                        @endphp
                        <div class="upgrade-card {{ $isRecommended ? 'recommended' : '' }}">
                            @if($isRecommended) <span class="rec-badge">Recomendado</span> @endif
                            <div class="upgrade-name">{{ $plan->name }}</div>
                            <div class="upgrade-price">${{ number_format($plan->price_monthly, 0) }} <span>MXN/mes</span></div>
                            <div class="upgrade-desc">
                                {{ $plan->max_warehouses == -1 ? 'Ilimitados' : $plan->max_warehouses }} almacén{{ $plan->max_warehouses != 1 ? 'es' : '' }}
                                · {{ $plan->max_skus == -1 ? 'Ilimitados' : number_format($plan->max_skus) }} productos
                                · {{ $plan->max_users == -1 ? 'Ilimitados' : $plan->max_users }} usuarios
                            </div>
                            <ul class="upgrade-features">
                                @foreach($featureMap[$plan->slug] ?? [] as $f)
                                    <li>{{ $f }}</li>
                                @endforeach
                            </ul>

                            @if($isCurrent && $isPaid)
                                <span class="btn-upgrade btn-upgrade-current">Plan actual</span>
                            @elseif($isCurrent && $isTrialing && !$isPaid)
                                <form action="{{ route('tenant.billing.checkout', $plan) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-upgrade btn-upgrade-primary">Suscribirse — ${{ number_format($plan->price_monthly, 0) }}/mes</button>
                                </form>
                            @elseif($isUpgrade && $isPaid)
                                <form action="{{ route('tenant.billing.change-plan', $plan) }}" method="POST" onsubmit="return confirm('¿Cambiar a {{ $plan->name }} por ${{ number_format($plan->price_monthly, 0) }}/mes?')">
                                    @csrf
                                    <button type="submit" class="btn-upgrade {{ $isRecommended ? 'btn-upgrade-primary' : 'btn-upgrade-outline' }}">Cambiar a {{ $plan->name }}</button>
                                </form>
                            @else
                                <form action="{{ route('tenant.billing.checkout', $plan) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-upgrade {{ $isRecommended ? 'btn-upgrade-primary' : 'btn-upgrade-outline' }}">
                                        Suscribirse — ${{ number_format($plan->price_monthly, 0) }}/mes
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</x-tenant-layout>
