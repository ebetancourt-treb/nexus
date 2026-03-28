<x-tenant-layout>
    <x-slot:title>{{ $dispatchOrder->order_number }}</x-slot:title>
    <x-slot:header>Orden de despacho</x-slot:header>

    @push('styles')
    <style>
        .order-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
        .order-title { font-family:'Special Gothic Expanded One',sans-serif; font-size:1.2rem; color:#585858; }
        .order-meta { display:flex; gap:10px; margin-top:8px; flex-wrap:wrap; align-items:center; }
        .badge { display:inline-flex; padding:2px 10px; border-radius:50px; font-size:0.65rem; font-weight:600; }
        .badge-gray { background:#f3f4f6; color:#6b7280; } .badge-amber { background:#fef3c7; color:#d97706; }
        .badge-blue { background:#dbeafe; color:#2563eb; } .badge-green { background:#dcfce7; color:#16a34a; }
        .badge-red { background:#fee2e2; color:#dc2626; }

        .actions { display:flex; gap:8px; }
        .btn-action { padding:8px 20px; border-radius:8px; font-size:0.82rem; font-weight:600; font-family:inherit; cursor:pointer; text-decoration:none; border:none; }
        .btn-jade { background:var(--jade); color:#fff; } .btn-jade:hover { background:var(--jade-dark); }
        .btn-outline { background:#fff; color:var(--text-secondary); border:1px solid var(--border); }
        .btn-red { background:#fff; color:#dc2626; border:1px solid #fecaca; }

        .detail-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px; }
        .card { background:var(--bg-card); border:1px solid var(--border); border-radius:10px; overflow:hidden; }
        .card-header { padding:14px 20px; border-bottom:1px solid var(--border); }
        .card-title { font-size:0.82rem; font-weight:600; }
        .card-body { padding:16px 20px; }
        .info-row { display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #f3f4f6; font-size:0.82rem; }
        .info-row:last-child { border:none; }
        .info-label { color:var(--text-secondary); }
        .info-value { font-weight:500; }

        .lines-table { width:100%; border-collapse:collapse; }
        .lines-table th { padding:10px 16px; text-align:left; font-size:0.68rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:var(--text-light); border-bottom:1px solid var(--border); }
        .lines-table td { padding:12px 16px; font-size:0.82rem; border-bottom:1px solid #f3f4f6; }

        .flash-success { padding:12px 16px; background:var(--jade-50); border:1px solid var(--jade-100); border-radius:8px; margin-bottom:20px; font-size:0.8rem; font-weight:500; color:var(--jade-dark); }
        .flash-error { padding:12px 16px; background:#fef2f2; border:1px solid #fecaca; border-radius:8px; margin-bottom:20px; font-size:0.8rem; color:#991b1b; }

        .timeline { margin-top:12px; }
        .timeline-item { display:flex; gap:10px; padding:6px 0; font-size:0.78rem; }
        .timeline-dot { width:8px; height:8px; border-radius:50%; margin-top:4px; flex-shrink:0; }
        .timeline-label { color:var(--text-secondary); }
        .timeline-date { color:var(--text-light); font-size:0.72rem; }

        @media (max-width:768px) { .detail-grid { grid-template-columns:1fr; } }
    </style>
    @endpush

    @if(session('success')) <div class="flash-success">{{ session('success') }}</div> @endif
    @if($errors->any()) <div class="flash-error">{{ $errors->first() }}</div> @endif

    @php
        $statusMap = ['draft'=>['Borrador','badge-gray'],'reserved'=>['Reservado','badge-amber'],'picking'=>['En picking','badge-blue'],'picked'=>['Picking completo','badge-green'],'dispatched'=>['Despachado','badge-green'],'canceled'=>['Cancelado','badge-red']];
        $s = $statusMap[$dispatchOrder->status] ?? ['—','badge-gray'];
    @endphp

    <div class="order-header">
        <div>
            <div class="order-title">{{ $dispatchOrder->order_number }}</div>
            <div class="order-meta">
                <span class="badge {{ $s[1] }}">{{ $s[0] }}</span>
                <span style="font-size:0.78rem; color:var(--text-secondary);">{{ $dispatchOrder->customer_name }}</span>
                @if($dispatchOrder->customer_reference) <span style="font-size:0.78rem; color:var(--text-light);">Ref: {{ $dispatchOrder->customer_reference }}</span> @endif
            </div>
        </div>
        <div class="actions">
            <a href="{{ route('tenant.dispatch-orders.index') }}" class="btn-action btn-outline">Volver</a>
            @if(in_array($dispatchOrder->status, ['draft', 'reserved']))
                <a href="{{ route('tenant.dispatch-orders.select-lots', $dispatchOrder) }}" class="btn-action btn-outline">Editar lotes</a>
            @endif
            @if($dispatchOrder->status === 'picking')
                <a href="{{ route('tenant.dispatch-orders.picking', $dispatchOrder) }}" class="btn-action btn-jade">Continuar picking</a>
            @endif
            @if($dispatchOrder->status === 'picked')
                <form action="{{ route('tenant.dispatch-orders.dispatch', $dispatchOrder) }}" method="POST" onsubmit="return confirm('¿Confirmar despacho? El stock se restará definitivamente.')">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-action btn-jade">Confirmar despacho</button>
                </form>
            @endif
            @if($dispatchOrder->status === 'dispatched')
                <a href="{{ route('tenant.dispatch-orders.exit-pdf', $dispatchOrder) }}" target="_blank" class="btn-action btn-outline">Documento de salida</a>
            @endif
            @if(!in_array($dispatchOrder->status, ['dispatched', 'canceled']))
                <form action="{{ route('tenant.dispatch-orders.cancel', $dispatchOrder) }}" method="POST" onsubmit="return confirm('¿Cancelar esta orden?')">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-action btn-red">Cancelar</button>
                </form>
            @endif
        </div>
    </div>

    <div class="detail-grid">
        <div class="card">
            <div class="card-header"><span class="card-title">Información</span></div>
            <div class="card-body">
                <div class="info-row"><span class="info-label">Cliente</span><span class="info-value">{{ $dispatchOrder->customer_name }}</span></div>
                <div class="info-row"><span class="info-label">Referencia</span><span class="info-value">{{ $dispatchOrder->customer_reference ?? '—' }}</span></div>
                <div class="info-row"><span class="info-label">Almacén</span><span class="info-value">{{ $dispatchOrder->warehouse?->name }}</span></div>
                <div class="info-row"><span class="info-label">Creado por</span><span class="info-value">{{ $dispatchOrder->createdBy?->name }}</span></div>
                @if($dispatchOrder->confirmedBy)
                    <div class="info-row"><span class="info-label">Despachado por</span><span class="info-value">{{ $dispatchOrder->confirmedBy->name }}</span></div>
                @endif
                @if($dispatchOrder->notes)
                    <div class="info-row" style="flex-direction:column; gap:4px;"><span class="info-label">Notas</span><span style="font-size:0.8rem;">{{ $dispatchOrder->notes }}</span></div>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-header"><span class="card-title">Timeline</span></div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item"><div class="timeline-dot" style="background:#6b7280;"></div><div><div class="timeline-label">Creado</div><div class="timeline-date">{{ $dispatchOrder->created_at->format('d/m/Y H:i') }}</div></div></div>
                    @if($dispatchOrder->reserved_at)<div class="timeline-item"><div class="timeline-dot" style="background:#d97706;"></div><div><div class="timeline-label">Stock reservado</div><div class="timeline-date">{{ $dispatchOrder->reserved_at->format('d/m/Y H:i') }}</div></div></div>@endif
                    @if($dispatchOrder->picking_started_at)<div class="timeline-item"><div class="timeline-dot" style="background:#2563eb;"></div><div><div class="timeline-label">Picking iniciado</div><div class="timeline-date">{{ $dispatchOrder->picking_started_at->format('d/m/Y H:i') }}</div></div></div>@endif
                    @if($dispatchOrder->picked_at)<div class="timeline-item"><div class="timeline-dot" style="background:#16a34a;"></div><div><div class="timeline-label">Picking completo</div><div class="timeline-date">{{ $dispatchOrder->picked_at->format('d/m/Y H:i') }}</div></div></div>@endif
                    @if($dispatchOrder->dispatched_at)<div class="timeline-item"><div class="timeline-dot" style="background:#059669;"></div><div><div class="timeline-label">Despachado</div><div class="timeline-date">{{ $dispatchOrder->dispatched_at->format('d/m/Y H:i') }}</div></div></div>@endif
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><span class="card-title">Productos ({{ $dispatchOrder->lines->count() }} líneas)</span></div>
        <table class="lines-table">
            <thead><tr><th>Producto</th><th>Lote</th><th>Caducidad</th><th>Solicitado</th><th>Recogido</th><th>Estado</th></tr></thead>
            <tbody>
            @foreach($dispatchOrder->lines as $line)
                <tr>
                    <td><div style="font-weight:600;">{{ $line->product?->name }}</div><div style="font-size:0.7rem; color:var(--text-light);">{{ $line->product?->sku }}</div></td>
                    <td style="font-size:0.78rem;">{{ $line->lot?->lot_number ?? '—' }}</td>
                    <td style="font-size:0.78rem;">{{ $line->lot?->expires_at?->format('d/m/Y') ?? '—' }}</td>
                    <td style="font-weight:600;">{{ number_format($line->quantity_requested) }}</td>
                    <td>{{ $line->is_picked ? number_format($line->quantity_picked) : '—' }}</td>
                    <td>
                        @if($line->is_picked)
                            <span class="badge badge-green">Recogido</span>
                        @else
                            <span class="badge badge-gray">Pendiente</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-tenant-layout>
