<x-tenant-layout>
    <x-slot:title>Almacenes</x-slot:title>
    <x-slot:header>Almacenes</x-slot:header>

    @push('styles')
    <style>
        .page-actions { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px; padding: 9px 20px;
            background: var(--jade); color: #fff; border: none; border-radius: 8px;
            font-size: 0.8rem; font-weight: 600; font-family: inherit; cursor: pointer;
            text-decoration: none; transition: background 0.2s;
        }
        .btn-primary:hover { background: var(--jade-dark); }
        .btn-primary svg { width: 16px; height: 16px; }

        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th {
            padding: 10px 16px; text-align: left; font-size: 0.68rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-light);
            border-bottom: 1px solid var(--border); background: #fafafa;
        }
        .data-table td {
            padding: 12px 16px; font-size: 0.82rem; color: var(--text);
            border-bottom: 1px solid #f3f4f6; vertical-align: middle;
        }
        .data-table tr:hover td { background: #fafffe; }

        .badge {
            display: inline-flex; align-items: center; gap: 4px; padding: 2px 10px;
            border-radius: 50px; font-size: 0.65rem; font-weight: 600;
        }
        .badge-green { background: #dcfce7; color: #16a34a; }
        .badge-gray { background: #f3f4f6; color: #6b7280; }
        .badge-jade { background: var(--jade-50); color: var(--jade); }
        .badge-red { background: #fee2e2; color: #dc2626; }

        .table-actions { display: flex; gap: 6px; justify-content: flex-end; }
        .btn-table {
            padding: 5px 10px; border-radius: 6px; font-size: 0.72rem; font-weight: 500;
            font-family: inherit; cursor: pointer; border: 1px solid var(--border);
            background: #fff; color: var(--text-secondary); text-decoration: none;
            transition: all 0.15s;
        }
        .btn-table:hover { border-color: var(--jade); color: var(--jade); }
        .btn-table.danger:hover { border-color: #ef4444; color: #ef4444; }

        .table-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
        .table-empty { padding: 48px 24px; text-align: center; }
        .table-empty p { font-size: 0.85rem; color: var(--text-light); margin-bottom: 16px; }

        .flash-success {
            padding: 12px 16px; background: var(--jade-50); border: 1px solid var(--jade-100);
            border-radius: 8px; margin-bottom: 20px; font-size: 0.8rem; font-weight: 500; color: var(--jade-dark);
        }
        .flash-error {
            padding: 12px 16px; background: #fef2f2; border: 1px solid #fecaca;
            border-radius: 8px; margin-bottom: 20px; font-size: 0.8rem; font-weight: 500; color: #991b1b;
        }

        .stat-mini { font-size: 0.72rem; color: var(--text-light); }
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
            <h2 style="font-family: 'Special Gothic Expanded One', sans-serif; font-size: 1.1rem; color: #585858;">
                Almacenes
            </h2>
            <p style="font-size: 0.78rem; color: var(--text-secondary); margin-top: 2px;">
                Gestiona tus almacenes y sucursales
            </p>
        </div>
        <a href="{{ route('tenant.warehouses.create') }}" class="btn-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Nuevo almacén
        </a>
    </div>

    <div class="table-card">
        @if($warehouses->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Almacén</th>
                        <th>Código</th>
                        <th>Rotación</th>
                        <th>Ubicaciones</th>
                        <th>Productos</th>
                        <th>Estado</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($warehouses as $warehouse)
                        <tr>
                            <td>
                                <div style="font-weight: 600;">
                                    {{ $warehouse->name }}
                                    @if($warehouse->is_default)
                                        <span class="badge badge-jade" style="margin-left: 6px;">Principal</span>
                                    @endif
                                </div>
                                @if($warehouse->city || $warehouse->state)
                                    <div class="stat-mini">{{ collect([$warehouse->city, $warehouse->state])->filter()->join(', ') }}</div>
                                @endif
                            </td>
                            <td><code style="font-size: 0.78rem; background: #f3f4f6; padding: 2px 8px; border-radius: 4px;">{{ $warehouse->code }}</code></td>
                            <td><span class="badge badge-gray">{{ strtoupper($warehouse->rotation_strategy) }}</span></td>
                            <td class="stat-mini">{{ $warehouse->locations_count }}</td>
                            <td class="stat-mini">{{ $warehouse->stock_levels_count }}</td>
                            <td>
                                @if($warehouse->is_active)
                                    <span class="badge badge-green">Activo</span>
                                @else
                                    <span class="badge badge-red">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <div class="table-actions">
                                    @if(!$warehouse->is_default)
                                        <form action="{{ route('tenant.warehouses.set-default', $warehouse) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn-table" title="Hacer principal">★</button>
                                        </form>
                                    @endif
                                    <a href="{{ route('tenant.warehouses.edit', $warehouse) }}" class="btn-table">Editar</a>
                                    <form action="{{ route('tenant.warehouses.destroy', $warehouse) }}" method="POST"
                                          onsubmit="return confirm('¿Seguro que deseas eliminar este almacén?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-table danger">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($warehouses->hasPages())
                <div style="padding: 12px 16px; border-top: 1px solid var(--border);">
                    {{ $warehouses->links() }}
                </div>
            @endif
        @else
            <div class="table-empty">
                <p>No tienes almacenes configurados.</p>
                <a href="{{ route('tenant.warehouses.create') }}" class="btn-primary">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Crear tu primer almacén
                </a>
            </div>
        @endif
    </div>
</x-tenant-layout>
