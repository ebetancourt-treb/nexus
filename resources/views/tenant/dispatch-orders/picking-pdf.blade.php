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
        .info-grid { display: flex; gap: 40px; margin-bottom: 16px; }
        .info-block { flex: 1; }
        .info-label { font-size: 9px; font-weight: bold; text-transform: uppercase; color: #999; letter-spacing: 0.5px; }
        .info-value { font-size: 12px; margin-top: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th { background: #f3f4f6; padding: 8px 10px; text-align: left; font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; color: #666; border-bottom: 1px solid #ddd; }
        td { padding: 10px; border-bottom: 1px solid #eee; font-size: 11px; }
        .qty { font-size: 16px; font-weight: bold; text-align: center; }
        .check-col { width: 60px; text-align: center; }
        .check-box { width: 18px; height: 18px; border: 1.5px solid #999; display: inline-block; }
        .footer { margin-top: 30px; padding-top: 12px; border-top: 1px solid #ddd; font-size: 9px; color: #999; display: flex; justify-content: space-between; }
        .signature { margin-top: 40px; display: flex; gap: 60px; }
        .sig-line { flex: 1; border-top: 1px solid #333; padding-top: 4px; font-size: 10px; text-align: center; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="logo">BlumOps</div>
            <div style="font-size:10px; color:#666;">{{ $order->warehouse?->name }}</div>
        </div>
        <div>
            <div class="doc-title">Lista de picking</div>
            <div class="doc-meta">{{ $order->order_number }} · {{ now()->format('d/m/Y H:i') }}</div>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-block">
            <div class="info-label">Cliente</div>
            <div class="info-value"><strong>{{ $order->customer_name }}</strong></div>
        </div>
        <div class="info-block">
            <div class="info-label">Referencia</div>
            <div class="info-value">{{ $order->customer_reference ?? '—' }}</div>
        </div>
        <div class="info-block">
            <div class="info-label">Total líneas</div>
            <div class="info-value">{{ $order->lines->count() }}</div>
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
                <th class="check-col">Recogido</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->lines as $i => $line)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $line->product?->name }}</strong></td>
                    <td>{{ $line->product?->sku }}</td>
                    <td>{{ $line->lot?->lot_number ?? '—' }}</td>
                    <td>{{ $line->lot?->expires_at?->format('d/m/Y') ?? '—' }}</td>
                    <td class="qty">{{ number_format($line->quantity_requested) }}</td>
                    <td class="check-col"><div class="check-box"></div></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($order->notes)
        <div style="margin-top:16px; padding:8px 12px; background:#fef3c7; border-radius:4px; font-size:10px;">
            <strong>Notas:</strong> {{ $order->notes }}
        </div>
    @endif

    <div class="signature">
        <div class="sig-line">Preparado por</div>
        <div class="sig-line">Verificado por</div>
    </div>

    <div class="footer">
        <span>BlumOps — {{ auth()->user()->tenant?->company_name }}</span>
        <span>Impreso: {{ now()->format('d/m/Y H:i') }}</span>
    </div>
</body>
</html>
