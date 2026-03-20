<x-tenant-layout>
    <x-slot:title>Productos</x-slot:title>
    <x-slot:header>Productos</x-slot:header>

    @push('styles')
    <style>
        .page-actions { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
        .btn-primary { display: inline-flex; align-items: center; gap: 8px; padding: 9px 20px; background: var(--jade); color: #fff; border: none; border-radius: 8px; font-size: 0.8rem; font-weight: 600; font-family: inherit; cursor: pointer; text-decoration: none; transition: background 0.2s; }
        .btn-primary:hover { background: var(--jade-dark); }
        .btn-primary svg { width: 16px; height: 16px; }

        .filters-bar { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; align-items: center; }
        .filter-input { padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.8rem; font-family: inherit; color: var(--text); background: #fff; min-width: 240px; }
        .filter-input:focus { outline: none; border-color: var(--jade); box-shadow: 0 0 0 3px rgba(5,150,105,0.08); }
        .filter-select { padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.8rem; font-family: inherit; color: var(--text); background: #fff; cursor: pointer; }
        .filter-select:focus { outline: none; border-color: var(--jade); }
        .filter-count { font-size: 0.75rem; color: var(--text-light); margin-left: auto; }

        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { padding: 10px 16px; text-align: left; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-light); border-bottom: 1px solid var(--border); background: #fafafa; }
        .data-table td { padding: 12px 16px; font-size: 0.82rem; color: var(--text); border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
        .data-table tr:hover td { background: #fafffe; }

        .product-name { font-weight: 600; color: var(--text); text-decoration: none; }
        .product-name:hover { color: var(--jade); }
        .product-sku { font-size: 0.7rem; color: var(--text-light); margin-top: 2px; }

        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 2px 10px; border-radius: 50px; font-size: 0.65rem; font-weight: 600; }
        .badge-green { background: #dcfce7; color: #16a34a; }
        .badge-gray { background: #f3f4f6; color: #6b7280; }
        .badge-red { background: #fee2e2; color: #dc2626; }
        .badge-amber { background: #fef3c7; color: #d97706; }
        .badge-blue { background: #dbeafe; color: #2563eb; }

        .stock-value { font-weight: 600; }
        .stock-low { color: #dc2626; }
        .stock-ok { color: var(--text); }

        .table-actions { display: flex; gap: 6px; justify-content: flex-end; }
        .btn-table { padding: 5px 10px; border-radius: 6px; font-size: 0.72rem; font-weight: 500; font-family: inherit; cursor: pointer; border: 1px solid var(--border); background: #fff; color: var(--text-secondary); text-decoration: none; transition: all 0.15s; }
        .btn-table:hover { border-color: var(--jade); color: var(--jade); }
        .btn-table.danger:hover { border-color: #ef4444; color: #ef4444; }

        .table-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
        .table-empty { padding: 48px 24px; text-align: center; }
        .table-empty p { font-size: 0.85rem; color: var(--text-light); margin-bottom: 16px; }

        .flash-success { padding: 12px 16px; background: var(--jade-50); border: 1px solid var(--jade-100); border-radius: 8px; margin-bottom: 20px; font-size: 0.8rem; font-weight: 500; color: var(--jade-dark); }
        .flash-error { padding: 12px 16px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; margin-bottom: 20px; font-size: 0.8rem; font-weight: 500; color: #991b1b; }

        .price-col { font-size: 0.78rem; color: var(--text-secondary); }

        @media (max-width: 768px) { .filters-bar { flex-direction: column; } .filter-input { min-width: 100%; } }
    </style>
    @endpush

    @if(session('success'))
        <div class="flash-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="flash-error">{{ $errors->first() }}</div>
    @endif

    <div class="page-actions">
        <div>
            <h2 style="font-family: 'Special Gothic Expanded One', sans-serif; font-size: 1.1rem; color: #585858;">Productos</h2>
            <p style="font-size: 0.78rem; color: var(--text-secondary); margin-top: 2px;">{{ $totalProducts }} productos registrados, {{ $activeProducts }} activos</p>
        </div>
        <a href="{{ route('tenant.products.create') }}" class="btn-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Nuevo producto
        </a>
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('tenant.products.index') }}" class="filters-bar">
        <input type="text" name="search" class="filter-input" placeholder="Buscar por nombre, SKU o código de barras..." value="{{ request('search') }}">
        <select name="category" class="filter-select" onchange="this.form.submit()">
            <option value="">Todas las categorías</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">Todos los estados</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activos</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivos</option>
        </select>
        <button type="submit" class="btn-table" style="padding: 8px 16px;">Buscar</button>
        @if(request()->hasAny(['search', 'category', 'status']))
            <a href="{{ route('tenant.products.index') }}" class="btn-table" style="padding: 8px 16px;">Limpiar</a>
        @endif
    </form>

    <div class="table-card">
        @if($products->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Costo</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Tracking</th>
                        <th>Estado</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        @php
                            $stock = $product->total_stock ?? 0;
                            $isLow = $product->reorder_point > 0 && $stock <= $product->reorder_point;
                        @endphp
                        <tr>
                            <td>
                                <a href="{{ route('tenant.products.show', $product) }}" class="product-name">{{ $product->name }}</a>
                                <div class="product-sku">{{ $product->sku }} @if($product->barcode) · {{ $product->barcode }} @endif</div>
                            </td>
                            <td>
                                @if($product->category)
                                    <span class="badge badge-gray">{{ $product->category->name }}</span>
                                @else
                                    <span style="font-size: 0.75rem; color: var(--text-light);">—</span>
                                @endif
                            </td>
                            <td class="price-col">${{ number_format($product->cost_price, 2) }}</td>
                            <td class="price-col">${{ number_format($product->sale_price, 2) }}</td>
                            <td>
                                <span class="stock-value {{ $isLow ? 'stock-low' : 'stock-ok' }}">
                                    {{ number_format($stock) }}
                                </span>
                                <span style="font-size: 0.68rem; color: var(--text-light);">{{ $product->unit_of_measure }}</span>
                                @if($isLow)
                                    <span class="badge badge-red" style="margin-left: 4px;">Bajo</span>
                                @endif
                            </td>
                            <td>
                                @if($product->track_lots)
                                    <span class="badge badge-blue">Lotes</span>
                                @endif
                                @if($product->track_serials)
                                    <span class="badge badge-amber">Series</span>
                                @endif
                                @if(!$product->track_lots && !$product->track_serials)
                                    <span style="font-size: 0.75rem; color: var(--text-light);">—</span>
                                @endif
                            </td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge badge-green">Activo</span>
                                @else
                                    <span class="badge badge-red">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('tenant.products.show', $product) }}" class="btn-table">Ver</a>
                                    <a href="{{ route('tenant.products.edit', $product) }}" class="btn-table">Editar</a>
                                    <form action="{{ route('tenant.products.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-table danger">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($products->hasPages())
                <div style="padding: 12px 16px; border-top: 1px solid var(--border);">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <div class="table-empty">
                <p>{{ request()->hasAny(['search','category','status']) ? 'No se encontraron productos con esos filtros.' : 'Aún no tienes productos registrados.' }}</p>
                @unless(request()->hasAny(['search','category','status']))
                    <a href="{{ route('tenant.products.create') }}" class="btn-primary">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Agregar tu primer producto
                    </a>
                @endunless
            </div>
        @endif
    </div>
</x-tenant-layout>
