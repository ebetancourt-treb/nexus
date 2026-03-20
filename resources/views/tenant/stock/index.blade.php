<x-tenant-layout>
    <x-slot:title>Existencias</x-slot:title>
    <x-slot:header>Existencias</x-slot:header>

    @push('styles')
    <style>
        .page-actions { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
        .filters-bar { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; align-items: center; }
        .filter-input { padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.8rem; font-family: inherit; color: var(--text); background: #fff; min-width: 240px; }
        .filter-input:focus { outline: none; border-color: var(--jade); box-shadow: 0 0 0 3px rgba(5,150,105,0.08); }
        .filter-select { padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.8rem; font-family: inherit; color: var(--text); background: #fff; cursor: pointer; }
        .btn-table { padding: 5px 10px; border-radius: 6px; font-size: 0.72rem; font-weight: 500; font-family: inherit; cursor: pointer; border: 1px solid var(--border); background: #fff; color: var(--text-secondary); text-decoration: none; }
        .btn-table:hover { border-color: var(--jade); color: var(--jade); }

        .summary-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 24px; }
        .summary-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; padding: 16px 20px; }
        .summary-label { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-light); }
        .summary-value { font-size: 1.5rem; font-weight: 700; color: var(--text); margin-top: 4px; }

        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { padding: 10px 16px; text-align: left; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-light); border-bottom: 1px solid var(--border); background: #fafafa; }
        .data-table td { padding: 12px 16px; font-size: 0.82rem; color: var(--text); border-bottom: 1px solid #f3f4f6; }
        .data-table tr:hover td { background: #fafffe; }

        .badge { display: inline-flex; padding: 2px 10px; border-radius: 50px; font-size: 0.65rem; font-weight: 600; }
        .badge-green { background: #dcfce7; color: #16a34a; }
        .badge-red { background: #fee2e2; color: #dc2626; }
        .badge-gray { background: #f3f4f6; color: #6b7280; }

        .stock-bar { display: flex; align-items: center; gap: 8px; }
        .stock-bar-bg { flex: 1; height: 6px; background: #f3f4f6; border-radius: 3px; overflow: hidden; max-width: 80px; }
        .stock-bar-fill { height: 100%; border-radius: 3px; }
        .stock-bar-fill.ok { background: var(--jade); }
        .stock-bar-fill.low { background: #ef4444; }
        .stock-bar-fill.warn { background: #f59e0b; }

        .table-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
        .table-empty { padding: 48px 24px; text-align: center; font-size: 0.85rem; color: var(--text-light); }

        @media (max-width: 768px) { .summary-grid { grid-template-columns: 1fr; } .filters-bar { flex-direction: column; } .filter-input { min-width: 100%; } }
    </style>
    @endpush

    <div class="page-actions">
        <div>
            <h2 style="font-family: 'Special Gothic Expanded One', sans-serif; font-size: 1.1rem; color: #585858;">Existencias</h2>
            <p style="font-size: 0.78rem; color: var(--text-secondary); margin-top: 2px;">Inventario actual por almacén y producto</p>
        </div>
    </div>

    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-label">Productos con stock</div>
            <div class="summary-value">{{ number_format($summary->total_products ?? 0) }}</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Unidades totales</div>
            <div class="summary-value">{{ number_format($summary->total_units ?? 0) }}</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Disponibles</div>
            <div class="summary-value" style="color: var(--jade);">{{ number_format($summary->total_available ?? 0) }}</div>
        </div>
    </div>

    <form method="GET" action="{{ route('tenant.stock.index') }}" class="filters-bar">
        <input type="text" name="search" class="filter-input" placeholder="Buscar por nombre, SKU o código de barras..." value="{{ request('search') }}">
        <select name="warehouse" class="filter-select" onchange="this.form.submit()">
            <option value="all">Todos los almacenes</option>
            @foreach($warehouses as $wh)
                <option value="{{ $wh->id }}" {{ $warehouseId == $wh->id ? 'selected' : '' }}>{{ $wh->name }}</option>
            @endforeach
        </select>
        <select name="category" class="filter-select" onchange="this.form.submit()">
            <option value="">Todas las categorías</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-table" style="padding:8px 16px;">Buscar</button>
        @if(request()->hasAny(['search','warehouse','category','low_stock']))
            <a href="{{ route('tenant.stock.index') }}" class="btn-table" style="padding:8px 16px;">Limpiar</a>
        @endif
    </form>

    <div class="table-card">
        @if($stockItems->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Almacén</th>
                        <th>Categoría</th>
                        <th>En existencia</th>
                        <th>Reservado</th>
                        <th>Disponible</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stockItems as $item)
                        @php
                            $product = $item->product;
                            $reorderPoint = $product?->reorder_point ?? 0;
                            $available = $item->total_available;
                            $isLow = $reorderPoint > 0 && $available <= $reorderPoint;
                            $isZero = $available <= 0;
                            $pct = $reorderPoint > 0 ? min(100, ($available / max($reorderPoint * 2, 1)) * 100) : 100;
                        @endphp
                        <tr>
                            <td>
                                <a href="{{ route('tenant.products.show', $product) }}" style="font-weight:600; color:var(--text); text-decoration:none;">
                                    {{ $product?->name }}
                                </a>
                                <div style="font-size:0.7rem; color:var(--text-light);">{{ $product?->sku }} @if($product?->barcode)· {{ $product->barcode }}@endif</div>
                            </td>
                            <td style="font-size:0.78rem;">{{ $item->warehouse?->name }}</td>
                            <td>
                                @if($product?->category)
                                    <span class="badge badge-gray">{{ $product->category->name }}</span>
                                @else
                                    <span style="color:var(--text-light); font-size:0.75rem;">—</span>
                                @endif
                            </td>
                            <td style="font-weight:600;">{{ number_format($item->total_on_hand) }}</td>
                            <td style="font-size:0.78rem; color:var(--text-secondary);">{{ number_format($item->total_reserved) }}</td>
                            <td>
                                <div class="stock-bar">
                                    <span style="font-weight:600; color: {{ $isZero ? '#dc2626' : ($isLow ? '#f59e0b' : 'var(--jade)') }};">
                                        {{ number_format($available) }}
                                    </span>
                                    @if($reorderPoint > 0)
                                        <div class="stock-bar-bg">
                                            <div class="stock-bar-fill {{ $isZero ? 'low' : ($isLow ? 'warn' : 'ok') }}" style="width: {{ $pct }}%;"></div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($isZero)
                                    <span class="badge badge-red">Sin stock</span>
                                @elseif($isLow)
                                    <span class="badge badge-red">Stock bajo</span>
                                @else
                                    <span class="badge badge-green">OK</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($stockItems->hasPages())
                <div style="padding:12px 16px; border-top:1px solid var(--border);">{{ $stockItems->links() }}</div>
            @endif
        @else
            <div class="table-empty">No hay existencias registradas. Haz tu primera recepción de mercancía para ver el inventario aquí.</div>
        @endif
    </div>
</x-tenant-layout>
