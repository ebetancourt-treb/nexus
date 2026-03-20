<x-tenant-layout>
    <x-slot:title>{{ $product->name }}</x-slot:title>
    <x-slot:header>Detalle de producto</x-slot:header>

    @push('styles')
    <style>
        .product-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 24px; gap: 16px; flex-wrap: wrap; }
        .product-title { font-family: 'Special Gothic Expanded One', sans-serif; font-size: 1.2rem; color: #585858; }
        .product-meta { display: flex; gap: 12px; margin-top: 6px; flex-wrap: wrap; }
        .meta-item { font-size: 0.75rem; color: var(--text-secondary); }
        .meta-item code { background: #f3f4f6; padding: 1px 6px; border-radius: 4px; font-size: 0.73rem; }

        .product-actions { display: flex; gap: 8px; }
        .btn-edit { padding: 8px 16px; background: var(--jade); color: #fff; border: none; border-radius: 8px; font-size: 0.78rem; font-weight: 600; font-family: inherit; text-decoration: none; }
        .btn-edit:hover { background: var(--jade-dark); }
        .btn-back { padding: 8px 16px; background: #fff; color: var(--text-secondary); border: 1px solid var(--border); border-radius: 8px; font-size: 0.78rem; font-weight: 500; font-family: inherit; text-decoration: none; }
        .btn-back:hover { border-color: var(--jade); color: var(--jade); }

        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }

        .dash-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
        .dash-card-header { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--border); }
        .dash-card-title { font-size: 0.82rem; font-weight: 600; color: var(--text); }
        .dash-card-body { padding: 16px 20px; }

        .info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f3f4f6; font-size: 0.8rem; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: var(--text-secondary); }
        .info-value { font-weight: 500; color: var(--text); }

        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 2px 10px; border-radius: 50px; font-size: 0.65rem; font-weight: 600; }
        .badge-green { background: #dcfce7; color: #16a34a; }
        .badge-red { background: #fee2e2; color: #dc2626; }
        .badge-blue { background: #dbeafe; color: #2563eb; }
        .badge-amber { background: #fef3c7; color: #d97706; }

        .stock-table { width: 100%; border-collapse: collapse; font-size: 0.8rem; }
        .stock-table th { padding: 8px 12px; text-align: left; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-light); border-bottom: 1px solid var(--border); }
        .stock-table td { padding: 10px 12px; border-bottom: 1px solid #f3f4f6; }

        .movement-item { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid #f3f4f6; font-size: 0.78rem; }
        .movement-item:last-child { border-bottom: none; }
        .mv-type { font-weight: 600; }
        .mv-meta { font-size: 0.68rem; color: var(--text-light); }
        .mv-qty { font-weight: 600; margin-left: auto; }
        .mv-qty.positive { color: #16a34a; }
        .mv-qty.negative { color: #dc2626; }

        .empty-state { padding: 24px; text-align: center; font-size: 0.8rem; color: var(--text-light); }

        @media (max-width: 768px) { .detail-grid { grid-template-columns: 1fr; } }
    </style>
    @endpush

    <div class="product-header">
        <div>
            <div class="product-title">{{ $product->name }}</div>
            <div class="product-meta">
                <span class="meta-item">SKU: <code>{{ $product->sku }}</code></span>
                @if($product->barcode) <span class="meta-item">Barcode: <code>{{ $product->barcode }}</code></span> @endif
                <span class="meta-item">Se vende por: {{ $product->unit_of_measure }}</span>
                @if($product->category) <span class="meta-item">Categoria: {{ $product->category->name }}</span> @endif
                @if($product->is_active) <span class="badge badge-green">Activo</span> @else <span class="badge badge-red">Inactivo</span> @endif
                @if($product->track_lots) <span class="badge badge-blue">Lotes</span> @endif
                @if($product->track_serials) <span class="badge badge-amber">Series</span> @endif
            </div>
        </div>
        <div class="product-actions">
            <a href="{{ route('tenant.products.index') }}" class="btn-back">Volver</a>
            <a href="{{ route('tenant.products.edit', $product) }}" class="btn-edit">Editar</a>
        </div>
    </div>

    <div class="detail-grid">
        {{-- Info del producto --}}
        <div class="dash-card">
            <div class="dash-card-header"><span class="dash-card-title">Información</span></div>
            <div class="dash-card-body">
                <div class="info-row"><span class="info-label">Costo</span><span class="info-value">${{ number_format($product->cost_price, 2) }} MXN</span></div>
                <div class="info-row"><span class="info-label">Precio venta</span><span class="info-value">${{ number_format($product->sale_price, 2) }} MXN</span></div>
                <div class="info-row"><span class="info-label">Punto de reorden</span><span class="info-value">{{ $product->reorder_point }} {{ $product->unit_of_measure }}</span></div>
                <div class="info-row"><span class="info-label">Cantidad sugerida</span><span class="info-value">{{ $product->reorder_qty }} {{ $product->unit_of_measure }}</span></div>
                @if($product->weight)<div class="info-row"><span class="info-label">Peso</span><span class="info-value">{{ $product->weight }} kg</span></div>@endif
                @if($product->description)<div class="info-row" style="flex-direction:column; gap:4px;"><span class="info-label">Descripción</span><span style="font-size:0.8rem; color:var(--text);">{{ $product->description }}</span></div>@endif
            </div>
        </div>

        {{-- Stock por almacén --}}
        <div class="dash-card">
            <div class="dash-card-header"><span class="dash-card-title">Stock por almacén</span></div>
            <div class="dash-card-body" style="padding: 0;">
                @if($stockByWarehouse->count() > 0)
                    <table class="stock-table">
                        <thead><tr><th>Almacén</th><th>Disponible</th><th>Reservado</th><th>Total</th></tr></thead>
                        <tbody>
                            @foreach($stockByWarehouse as $stock)
                                <tr>
                                    <td>{{ $stock->warehouse?->name ?? '—' }}</td>
                                    <td style="font-weight:600; color: var(--jade);">{{ number_format($stock->total_available) }}</td>
                                    <td>{{ number_format($stock->total_reserved) }}</td>
                                    <td>{{ number_format($stock->total_on_hand) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">Sin stock registrado aún</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Últimos movimientos --}}
    <div class="dash-card">
        <div class="dash-card-header"><span class="dash-card-title">Últimos movimientos</span></div>
        <div class="dash-card-body">
            @forelse($recentMovements as $line)
                @php
                    $m = $line->movement;
                    $typeLabels = [
                        'receiving' => 'Recepción', 'dispatch' => 'Despacho', 'adjustment' => 'Ajuste',
                        'transfer_out' => 'Transfer. salida', 'transfer_in' => 'Transfer. entrada',
                        'return' => 'Devolución', 'cycle_count' => 'Conteo',
                    ];
                    $isPositive = in_array($m?->type, ['receiving', 'transfer_in', 'return']);
                @endphp
                <div class="movement-item">
                    <div>
                        <div class="mv-type">{{ $typeLabels[$m?->type] ?? 'Movimiento' }}</div>
                        <div class="mv-meta">
                            {{ $m?->warehouse?->name }} — {{ $m?->user?->name }} — {{ $m?->created_at?->diffForHumans() }}
                            @if($line->lot) · Lote: {{ $line->lot->lot_number }} @endif
                        </div>
                    </div>
                    <div class="mv-qty {{ $isPositive ? 'positive' : 'negative' }}">
                        {{ $isPositive ? '+' : '' }}{{ number_format($line->quantity) }} {{ $product->unit_of_measure }}
                    </div>
                </div>
            @empty
                <div class="empty-state">Sin movimientos registrados para este producto</div>
            @endforelse
        </div>
    </div>
</x-tenant-layout>
