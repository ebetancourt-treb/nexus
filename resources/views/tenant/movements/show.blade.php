<x-tenant-layout>
    <x-slot:title>Movimiento #{{ $movement->id }}</x-slot:title>
    <x-slot:header>Detalle de movimiento</x-slot:header>

    @push('styles')
    <style>
        .mv-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 24px; gap: 16px; flex-wrap: wrap; }
        .mv-title { font-family: 'Special Gothic Expanded One', sans-serif; font-size: 1.1rem; color: #585858; }
        .mv-meta { display: flex; gap: 10px; margin-top: 8px; flex-wrap: wrap; align-items: center; }
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 2px 10px; border-radius: 50px; font-size: 0.65rem; font-weight: 600; }
        .badge-green { background: #dcfce7; color: #16a34a; }
        .badge-red { background: #fee2e2; color: #dc2626; }
        .badge-blue { background: #dbeafe; color: #2563eb; }
        .badge-amber { background: #fef3c7; color: #d97706; }
        .badge-gray { background: #f3f4f6; color: #6b7280; }

        .btn-back { padding: 8px 16px; background: #fff; color: var(--text-secondary); border: 1px solid var(--border); border-radius: 8px; font-size: 0.78rem; font-weight: 500; font-family: inherit; text-decoration: none; }
        .btn-back:hover { border-color: var(--jade); color: var(--jade); }

        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }

        .dash-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
        .dash-card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); }
        .dash-card-title { font-size: 0.82rem; font-weight: 600; color: var(--text); }
        .dash-card-body { padding: 16px 20px; }

        .info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f3f4f6; font-size: 0.8rem; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: var(--text-secondary); }
        .info-value { font-weight: 500; color: var(--text); }

        .lines-table { width: 100%; border-collapse: collapse; }
        .lines-table th { padding: 10px 16px; text-align: left; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-light); border-bottom: 1px solid var(--border); background: #fafafa; }
        .lines-table td { padding: 12px 16px; font-size: 0.82rem; border-bottom: 1px solid #f3f4f6; }
        .lines-table tr:last-child td { border-bottom: none; }

        @media (max-width: 768px) { .detail-grid { grid-template-columns: 1fr; } }
    </style>
    @endpush

    @php
        $typeMap = [
            'receiving' => ['Recepción', 'badge-green'],
            'dispatch' => ['Despacho', 'badge-red'],
            'adjustment' => ['Ajuste', 'badge-amber'],
            'transfer_out' => ['Transfer. salida', 'badge-blue'],
            'transfer_in' => ['Transfer. entrada', 'badge-blue'],
            'return' => ['Devolución', 'badge-amber'],
            'cycle_count' => ['Conteo cíclico', 'badge-gray'],
        ];
        $t = $typeMap[$movement->type] ?? ['Movimiento', 'badge-gray'];
        $statusMap = [
            'draft' => ['Borrador', 'badge-gray'],
            'confirmed' => ['Confirmado', 'badge-blue'],
            'completed' => ['Completado', 'badge-green'],
            'canceled' => ['Cancelado', 'badge-red'],
        ];
        $s = $statusMap[$movement->status] ?? ['—', 'badge-gray'];
        $isEntry = in_array($movement->type, ['receiving', 'transfer_in', 'return']);
    @endphp

    <div class="mv-header">
        <div>
            <div class="mv-title">Movimiento #{{ $movement->id }}</div>
            <div class="mv-meta">
                <span class="badge {{ $t[1] }}">{{ $t[0] }}</span>
                <span class="badge {{ $s[1] }}">{{ $s[0] }}</span>
                @if($movement->reference)
                    <span style="font-size: 0.78rem; color: var(--text-secondary);">Ref: {{ $movement->reference }}</span>
                @endif
            </div>
        </div>
        <a href="{{ route('tenant.movements.index') }}" class="btn-back">Volver a movimientos</a>
    </div>

    <div class="detail-grid">
        <div class="dash-card">
            <div class="dash-card-header"><span class="dash-card-title">Información</span></div>
            <div class="dash-card-body">
                <div class="info-row"><span class="info-label">Almacén</span><span class="info-value">{{ $movement->warehouse?->name }}</span></div>
                <div class="info-row"><span class="info-label">Realizado por</span><span class="info-value">{{ $movement->user?->name }}</span></div>
                <div class="info-row"><span class="info-label">Fecha de creación</span><span class="info-value">{{ $movement->created_at->format('d/m/Y H:i') }}</span></div>
                @if($movement->completed_at)
                    <div class="info-row"><span class="info-label">Fecha de confirmación</span><span class="info-value">{{ $movement->completed_at->format('d/m/Y H:i') }}</span></div>
                @endif
                @if($movement->notes)
                    <div class="info-row" style="flex-direction:column; gap:4px;">
                        <span class="info-label">Notas</span>
                        <span style="font-size:0.8rem; color:var(--text);">{{ $movement->notes }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="dash-card">
            <div class="dash-card-header"><span class="dash-card-title">Resumen</span></div>
            <div class="dash-card-body">
                <div class="info-row"><span class="info-label">Total de líneas</span><span class="info-value">{{ $movement->lines->count() }}</span></div>
                <div class="info-row"><span class="info-label">Productos distintos</span><span class="info-value">{{ $movement->lines->unique('product_id')->count() }}</span></div>
                <div class="info-row"><span class="info-label">Cantidad total</span><span class="info-value" style="color: {{ $isEntry ? '#16a34a' : '#dc2626' }};">{{ $isEntry ? '+' : '-' }}{{ number_format($movement->lines->sum('quantity')) }} uds.</span></div>
                @if($movement->lines->sum('unit_cost') > 0)
                    <div class="info-row"><span class="info-label">Valor total</span><span class="info-value">${{ number_format($movement->lines->sum(fn($l) => $l->quantity * $l->unit_cost), 2) }} MXN</span></div>
                @endif
            </div>
        </div>
    </div>

    <div class="dash-card">
        <div class="dash-card-header"><span class="dash-card-title">Líneas del movimiento</span></div>
        <table class="lines-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Lote</th>
                    <th>Caducidad</th>
                    <th>Cantidad</th>
                    <th>Costo unit.</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movement->lines as $line)
                    <tr>
                        <td>
                            <div style="font-weight: 600;">{{ $line->product?->name }}</div>
                            <div style="font-size: 0.7rem; color: var(--text-light);">{{ $line->product?->sku }}</div>
                        </td>
                        <td style="font-size: 0.78rem;">{{ $line->lot?->lot_number ?? '—' }}</td>
                        <td style="font-size: 0.78rem;">{{ $line->lot?->expires_at?->format('d/m/Y') ?? '—' }}</td>
                        <td style="font-weight: 600; color: {{ $isEntry ? '#16a34a' : '#dc2626' }};">
                            {{ $isEntry ? '+' : '-' }}{{ number_format($line->quantity) }}
                        </td>
                        <td style="font-size: 0.78rem;">${{ number_format($line->unit_cost ?? 0, 2) }}</td>
                        <td style="font-size: 0.78rem;">${{ number_format(($line->quantity ?? 0) * ($line->unit_cost ?? 0), 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-tenant-layout>
