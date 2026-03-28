<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; margin: 20px; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; border-bottom: 2px solid #059669; padding-bottom: 12px; }
        .logo { font-size: 18px; font-weight: bold; color: #059669; }
        .doc-title { font-size: 16px; font-weight: bold; text-align: right; }
        .doc-meta { font-size: 10px; color: #666; text-align: right; margin-top: 4px; }
        .info-grid { display: flex; gap: 20px; margin-bottom: 20px; }
        .info-block { flex: 1; border: 1px solid #eee; border-radius: 6px; padding: 10px 14px; }
        .info-label { font-size: 9px; font-weight: bold; text-transform: uppercase; color: #999; letter-spacing: 0.5px; }
        .info-value { font-size: 12px; margin-top: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th { background: #f3f4f6; padding: 8px 10px; text-align: left; font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; color: #666; border-bottom: 1px solid #ddd; }
        td { padding: 10px; border-bottom: 1px solid #eee; font-size: 11px; }
        .qty { font-weight: bold; text-align: center; }
        .totals { margin-top: 12px; text-align: right; font-size: 12px; padding: 8px 10px; background: #f9fafb; border-radius: 4px; }
        .footer { margin-top: 30px; padding-top: 12px; border-top: 1px solid #ddd; font-size: 9px; color: #999; display: flex; justify-content: space-between; }
        .signature { margin-top: 40px; display: flex; gap: 40px; }
        .sig-line { flex: 1; border-top: 1px solid #333; padding-top: 4px; font-size: 10px; text-align: center; color: #666; }
        .stamp { margin-top: 20px; padding: 8px 16px; background: #dcfce7; border: 1px solid #16a34a; border-radius: 4px; display: inline-block; font-size: 12px; font-weight: bold; color: #16a34a; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="logo">BlumOps</div>
            <div style="font-size:10px; color:#666;">{{ auth()->user()->tenant?->company_name }}</div>
            @if(auth()->user()->tenant?->rfc)
                <div style="font-size:9px; color:#999;">RFC: {{ auth()->user()->tenant->rfc }}</div>
            @endif
        </div>
        <div>
            <div class="doc-title">Documento de salida</div>
            <div class="doc-meta">{{ $order->order_number }}</div>
            <div class="doc-meta">{{ $order->dispatched_at?->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i') }}</div>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-block">
            <div class="info-label">Cliente</div>
            <div class="info-value"><strong>{{ $order->customer_name }}</strong></div>
        </div>
        <div class="info-block">
            <div class="info-label">Referencia del pedido</div>
            <div class="info-value">{{ $order->customer_reference ?? '—' }}</div>
        </div>
        <div class="info-block">
            <div class="info-label">Almacén de origen</div>
            <div class="info-value">{{ $order->warehouse?->name }} ({{ $order->warehouse?->code }})</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>SKU</th>
                <th>Lote</th>
                <th>Caducidad</th>
                <th style="text-align:center;">Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @php $totalPcs = 0; @endphp
            @foreach($order->lines as $i => $line)
                @php $totalPcs += $line->quantity_picked; @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $line->product?->name }}</strong></td>
                    <td>{{ $line->product?->sku }}</td>
                    <td>{{ $line->lot?->lot_number ?? '—' }}</td>
                    <td>{{ $line->lot?->expires_at?->format('d/m/Y') ?? '—' }}</td>
                    <td class="qty">{{ number_format($line->quantity_picked) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <strong>{{ $order->lines->count() }}</strong> líneas · <strong>{{ number_format($totalPcs) }}</strong> piezas totales
    </div>

    @if($order->notes)
        <div style="margin-top:12px; padding:8px 12px; background:#f9fafb; border:1px solid #eee; border-radius:4px; font-size:10px;">
            <strong>Observaciones:</strong> {{ $order->notes }}
        </div>
    @endif

    <div class="stamp">DESPACHADO</div>

    <div class="signature">
        <div class="sig-line">Entregó</div>
        <div class="sig-line">Recibió</div>
        <div class="sig-line">Autorizó</div>
    </div>

    <div class="footer">
        <span>{{ auth()->user()->tenant?->company_name }} — BlumOps</span>
        <span>Despachado por: {{ $order->confirmedBy?->name ?? '—' }} · {{ $order->dispatched_at?->format('d/m/Y H:i') }}</span>
    </div>
</body>
</html>
