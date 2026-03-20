<x-tenant-layout>
    <x-slot:title>Movimientos</x-slot:title>
    <x-slot:header>Movimientos</x-slot:header>

    @push('styles')
    <style>
        .page-actions { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
        .action-buttons { display: flex; gap: 8px; }
        .btn-primary { display: inline-flex; align-items: center; gap: 8px; padding: 9px 20px; background: var(--jade); color: #fff; border: none; border-radius: 8px; font-size: 0.8rem; font-weight: 600; font-family: inherit; cursor: pointer; text-decoration: none; }
        .btn-primary:hover { background: var(--jade-dark); }
        .btn-primary svg { width: 16px; height: 16px; }
        .btn-outline { display: inline-flex; align-items: center; gap: 8px; padding: 9px 20px; background: #fff; color: var(--text-secondary); border: 1px solid var(--border); border-radius: 8px; font-size: 0.8rem; font-weight: 600; font-family: inherit; cursor: pointer; text-decoration: none; }
        .btn-outline:hover { border-color: var(--jade); color: var(--jade); }

        .filters-bar { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; align-items: center; }
        .filter-input { padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.8rem; font-family: inherit; color: var(--text); background: #fff; min-width: 200px; }
        .filter-input:focus { outline: none; border-color: var(--jade); }
        .filter-select { padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.8rem; font-family: inherit; color: var(--text); background: #fff; cursor: pointer; }
        .btn-table { padding: 5px 10px; border-radius: 6px; font-size: 0.72rem; font-weight: 500; font-family: inherit; cursor: pointer; border: 1px solid var(--border); background: #fff; color: var(--text-secondary); text-decoration: none; }
        .btn-table:hover { border-color: var(--jade); color: var(--jade); }

        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { padding: 10px 16px; text-align: left; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-light); border-bottom: 1px solid var(--border); background: #fafafa; }
        .data-table td { padding: 12px 16px; font-size: 0.82rem; color: var(--text); border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
        .data-table tr:hover td { background: #fafffe; }

        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 2px 10px; border-radius: 50px; font-size: 0.65rem; font-weight: 600; }
        .badge-green { background: #dcfce7; color: #16a34a; }
        .badge-blue { background: #dbeafe; color: #2563eb; }
        .badge-gray { background: #f3f4f6; color: #6b7280; }
        .badge-red { background: #fee2e2; color: #dc2626; }
        .badge-amber { background: #fef3c7; color: #d97706; }

        .table-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
        .table-empty { padding: 48px 24px; text-align: center; }
        .table-empty p { font-size: 0.85rem; color: var(--text-light); margin-bottom: 16px; }

        .flash-success { padding: 12px 16px; background: var(--jade-50); border: 1px solid var(--jade-100); border-radius: 8px; margin-bottom: 20px; font-size: 0.8rem; font-weight: 500; color: var(--jade-dark); }
        .flash-error { padding: 12px 16px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; margin-bottom: 20px; font-size: 0.8rem; font-weight: 500; color: #991b1b; }
    </style>
    @endpush

    @if(session('success')) <div class="flash-success">{{ session('success') }}</div> @endif
    @if($errors->any()) <div class="flash-error">{{ $errors->first() }}</div> @endif

    <div class="page-actions">
        <div>
            <h2 style="font-family: 'Special Gothic Expanded One', sans-serif; font-size: 1.1rem; color: #585858;">Movimientos</h2>
            <p style="font-size: 0.78rem; color: var(--text-secondary); margin-top: 2px;">Entradas, salidas y ajustes de inventario</p>
        </div>
        <div class="action-buttons">
            <a href="{{ route('tenant.movements.create-dispatch') }}" class="btn-outline">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25"/></svg>
                Despacho
            </a>
            <a href="{{ route('tenant.movements.create-receiving') }}" class="btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 4.5l-15 15m0 0h11.25m-11.25 0V8.25"/></svg>
                Recepción
            </a>
        </div>
    </div>

    <form method="GET" action="{{ route('tenant.movements.index') }}" class="filters-bar">
        <input type="text" name="search" class="filter-input" placeholder="Buscar por referencia..." value="{{ request('search') }}">
        <select name="type" class="filter-select" onchange="this.form.submit()">
            <option value="">Todos los tipos</option>
            <option value="receiving" {{ request('type') === 'receiving' ? 'selected' : '' }}>Recepción</option>
            <option value="dispatch" {{ request('type') === 'dispatch' ? 'selected' : '' }}>Despacho</option>
            <option value="adjustment" {{ request('type') === 'adjustment' ? 'selected' : '' }}>Ajuste</option>
            <option value="transfer_out" {{ request('type') === 'transfer_out' ? 'selected' : '' }}>Transferencia salida</option>
            <option value="transfer_in" {{ request('type') === 'transfer_in' ? 'selected' : '' }}>Transferencia entrada</option>
            <option value="return" {{ request('type') === 'return' ? 'selected' : '' }}>Devolución</option>
        </select>
        <select name="warehouse" class="filter-select" onchange="this.form.submit()">
            <option value="">Todos los almacenes</option>
            @foreach($warehouses as $wh)
                <option value="{{ $wh->id }}" {{ request('warehouse') == $wh->id ? 'selected' : '' }}>{{ $wh->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-table" style="padding:8px 16px;">Filtrar</button>
        @if(request()->hasAny(['search','type','status','warehouse']))
            <a href="{{ route('tenant.movements.index') }}" class="btn-table" style="padding:8px 16px;">Limpiar</a>
        @endif
    </form>

    <div class="table-card">
        @if($movements->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Referencia</th>
                        <th>Almacén</th>
                        <th>Líneas</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th style="text-align:right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movements as $movement)
                        @php
                            $typeMap = [
                                'receiving' => ['Recepción', 'badge-green'],
                                'dispatch' => ['Despacho', 'badge-red'],
                                'adjustment' => ['Ajuste', 'badge-amber'],
                                'transfer_out' => ['Transfer. salida', 'badge-blue'],
                                'transfer_in' => ['Transfer. entrada', 'badge-blue'],
                                'return' => ['Devolución', 'badge-amber'],
                                'cycle_count' => ['Conteo', 'badge-gray'],
                            ];
                            $t = $typeMap[$movement->type] ?? ['Movimiento', 'badge-gray'];
                            $statusMap = [
                                'draft' => ['Borrador', 'badge-gray'],
                                'confirmed' => ['Confirmado', 'badge-blue'],
                                'completed' => ['Completado', 'badge-green'],
                                'canceled' => ['Cancelado', 'badge-red'],
                            ];
                            $s = $statusMap[$movement->status] ?? ['—', 'badge-gray'];
                        @endphp
                        <tr>
                            <td><span class="badge {{ $t[1] }}">{{ $t[0] }}</span></td>
                            <td>{{ $movement->reference ?? '—' }}</td>
                            <td style="font-size:0.78rem;">{{ $movement->warehouse?->name }}</td>
                            <td style="font-size:0.78rem; color:var(--text-light);">{{ $movement->lines_count }} productos</td>
                            <td style="font-size:0.78rem;">{{ $movement->user?->name }}</td>
                            <td><span class="badge {{ $s[1] }}">{{ $s[0] }}</span></td>
                            <td style="font-size:0.75rem; color:var(--text-light);">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                            <td style="text-align:right;">
                                <a href="{{ route('tenant.movements.show', $movement) }}" class="btn-table">Ver detalle</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($movements->hasPages())
                <div style="padding: 12px 16px; border-top: 1px solid var(--border);">{{ $movements->links() }}</div>
            @endif
        @else
            <div class="table-empty">
                <p>{{ request()->hasAny(['search','type','warehouse']) ? 'No se encontraron movimientos con esos filtros.' : 'Aún no hay movimientos registrados.' }}</p>
                @unless(request()->hasAny(['search','type','warehouse']))
                    <a href="{{ route('tenant.movements.create-receiving') }}" class="btn-primary">Registrar primera recepción</a>
                @endunless
            </div>
        @endif
    </div>
</x-tenant-layout>
