<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; margin: 20px; }
        
        /* Clases para tablas de maquetación (Sin bordes) */
        .layout-table { width: 100%; border-collapse: collapse; margin: 0; border: none; }
        .layout-table td { border: none; padding: 0; vertical-align: top; }

        /* Clases para la tabla de productos (Con bordes) */
        .data-table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .data-table th { background: #f3f4f6; padding: 8px 10px; text-align: left; font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; color: #666; border-bottom: 1px solid #ddd; }
        .data-table td { padding: 10px; border-bottom: 1px solid #eee; font-size: 11px; }
        
        /* Elementos individuales */
        .logo { font-size: 18px; font-weight: bold; color: #059669; }
        .doc-title { font-size: 16px; font-weight: bold; text-align: right; }
        .doc-meta { font-size: 10px; color: #666; text-align: right; margin-top: 4px; }
        .info-label { font-size: 9px; font-weight: bold; text-transform: uppercase; color: #999; letter-spacing: 0.5px; }
        .info-value { font-size: 12px; margin-top: 2px; }
        .qty { font-size: 14px; font-weight: bold; text-align: center; }
    </style>
</head>
<body>
    
    <table class="layout-table" style="margin-bottom: 20px; border-bottom: 2px solid #059669; padding-bottom: 12px;">
        <tr>
            <td style="width: 50%;">
                <div class="logo">BlumOps</div>
                <div style="font-size:10px; color:#666; margin-top: 2px;">{{ $dispatchOrder->warehouse?->name }}</div>
            </td>
            <td style="width: 50%; text-align: right;">
                <div class="doc-title">Documento de salida</div>
                <div class="doc-meta">{{ $dispatchOrder->order_number }} · {{ now()->format('d/m/Y H:i') }}</div>
            </td>
        </tr>
    </table>

    <table class="layout-table" style="margin-bottom: 20px;">
        <tr>
            <td style="width: 33%;">
                <div class="info-label">Cliente</div>
                <div class="info-value"><strong>{{ $dispatchOrder->customer_name }}</strong></div>
            </td>
            <td style="width: 33%;">
                <div class="info-label">Referencia</div>
                <div class="info-value">{{ $dispatchOrder->customer_reference ?? '—' }}</div>
            </td>
            <td style="width: 34%;">
                <div class="info-label">Total líneas</div>
                <div class="info-value">{{ $dispatchOrder->lines->count() }}</div>
            </td>
        </tr>
    </table>

    <table class="data-table">
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
            @foreach($dispatchOrder->lines as $i => $line)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $line->product?->name }}</strong></td>
                    <td>{{ $line->product?->sku }}</td>
                    <td>{{ $line->lot?->lot_number ?? '—' }}</td>
                    <td>{{ $line->lot?->expires_at?->format('d/m/Y') ?? '—' }}</td>
                    <td class="qty">{{ number_format($line->quantity_requested) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($dispatchOrder->notes)
        <div style="margin-top:16px; padding:8px 12px; background:#fef3c7; border-radius:4px; font-size:10px;">
            <strong>Notas:</strong> {{ $dispatchOrder->notes }}
        </div>
    @endif

    <table class="layout-table" style="margin-top: 80px;">
        <tr>
            <td style="width: 33%; padding: 0 20px; text-align: center;">
                <div style="border-top: 1px solid #333; padding-top: 5px; font-size: 10px; color: #666;">
                    Entregó
                </div>
            </td>
            <td style="width: 33%; padding: 0 20px; text-align: center;">
                <div style="border-top: 1px solid #333; padding-top: 5px; font-size: 10px; color: #666;">
                    Recibió
                </div>
            </td>
            <td style="width: 33%; padding: 0 20px; text-align: center;">
                <div style="border-top: 1px solid #333; padding-top: 5px; font-size: 10px; color: #666;">
                    Autorizó
                </div>
            </td>
        </tr>
    </table>

    <table class="layout-table" style="margin-top: 40px; border-top: 1px solid #ddd; padding-top: 12px;">
        <tr>
            <td style="font-size: 9px; color: #999;">
                BlumOps — {{ auth()->user()->tenant?->company_name }}
            </td>
            <td style="font-size: 9px; color: #999; text-align: right;">
                Impreso: {{ now()->format('d/m/Y H:i') }}
            </td>
        </tr>
    </table>

</body>
</html>