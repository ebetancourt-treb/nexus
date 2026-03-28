<x-tenant-layout>
    <x-slot:title>Órdenes de despacho</x-slot:title>
    <x-slot:header>Órdenes de despacho</x-slot:header>

    @push('styles')
    <style>
        .page-actions { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:12px; }
        .btn-primary { display:inline-flex; align-items:center; gap:8px; padding:9px 20px; background:var(--jade); color:#fff; border:none; border-radius:8px; font-size:0.8rem; font-weight:600; font-family:inherit; cursor:pointer; text-decoration:none; }
        .btn-primary:hover { background:var(--jade-dark); }
        .filters-bar { display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap; }
        .filter-input { padding:8px 12px; border:1px solid var(--border); border-radius:8px; font-size:0.8rem; font-family:inherit; color:var(--text); background:#fff; min-width:220px; }
        .filter-input:focus { outline:none; border-color:var(--jade); }
        .filter-select { padding:8px 12px; border:1px solid var(--border); border-radius:8px; font-size:0.8rem; font-family:inherit; color:var(--text); background:#fff; }
        .data-table { width:100%; border-collapse:collapse; }
        .data-table th { padding:10px 16px; text-align:left; font-size:0.68rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:var(--text-light); border-bottom:1px solid var(--border); background:#fafafa; }
        .data-table td { padding:12px 16px; font-size:0.82rem; color:var(--text); border-bottom:1px solid #f3f4f6; }
        .data-table tr:hover td { background:#fafffe; }
        .badge { display:inline-flex; padding:2px 10px; border-radius:50px; font-size:0.65rem; font-weight:600; }
        .badge-gray { background:#f3f4f6; color:#6b7280; }
        .badge-amber { background:#fef3c7; color:#d97706; }
        .badge-blue { background:#dbeafe; color:#2563eb; }
        .badge-green { background:#dcfce7; color:#16a34a; }
        .badge-red { background:#fee2e2; color:#dc2626; }
        .table-card { background:var(--bg-card); border:1px solid var(--border); border-radius:10px; overflow:hidden; }
        .btn-table { padding:5px 10px; border-radius:6px; font-size:0.72rem; font-weight:500; font-family:inherit; cursor:pointer; border:1px solid var(--border); background:#fff; color:var(--text-secondary); text-decoration:none; }
        .btn-table:hover { border-color:var(--jade); color:var(--jade); }
        .flash-success { padding:12px 16px; background:var(--jade-50); border:1px solid var(--jade-100); border-radius:8px; margin-bottom:20px; font-size:0.8rem; font-weight:500; color:var(--jade-dark); }
        .table-empty { padding:48px 24px; text-align:center; font-size:0.85rem; color:var(--text-light); }
    </style>
    @endpush

    @if(session('success')) <div class="flash-success">{{ session('success') }}</div> @endif
    @if($errors->any()) <div style="padding:12px 16px; background:#fef2f2; border:1px solid #fecaca; border-radius:8px; margin-bottom:20px; font-size:0.8rem; color:#991b1b;">{{ $errors->first() }}</div> @endif

    <div class="page-actions">
        <div>
            <h2 style="font-family:'Special Gothic Expanded One',sans-serif; font-size:1.1rem; color:#585858;">Órdenes de despacho</h2>
            <p style="font-size:0.78rem; color:var(--text-secondary); margin-top:2px;">Pedidos con reserva de lote, picking y validación</p>
        </div>
        <a href="{{ route('tenant.dispatch-orders.create') }}" class="btn-primary">+ Nueva orden</a>
    </div>

    <form method="GET" class="filters-bar">
        <input type="text" name="search" class="filter-input" placeholder="Buscar por cliente, # orden, referencia..." value="{{ request('search') }}">
        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">Todos los estados</option>
            @foreach(['draft'=>'Borrador','reserved'=>'Reservado','picking'=>'En picking','picked'=>'Picking completo','dispatched'=>'Despachado','canceled'=>'Cancelado'] as $k=>$v)
                <option value="{{ $k }}" {{ request('status')===$k ? 'selected' : '' }}>{{ $v }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-table" style="padding:8px 16px;">Filtrar</button>
    </form>

    <div class="table-card">
        @if($orders->count() > 0)
        <table class="data-table">
            <thead><tr><th># Orden</th><th>Cliente</th><th>Almacén</th><th>Líneas</th><th>Estado</th><th>Creado por</th><th>Fecha</th><th style="text-align:right;">Acciones</th></tr></thead>
            <tbody>
            @foreach($orders as $order)
                @php
                    $statusMap = ['draft'=>['Borrador','badge-gray'],'reserved'=>['Reservado','badge-amber'],'picking'=>['En picking','badge-blue'],'picked'=>['Listo','badge-green'],'dispatched'=>['Despachado','badge-green'],'canceled'=>['Cancelado','badge-red']];
                    $s = $statusMap[$order->status] ?? ['—','badge-gray'];
                @endphp
                <tr>
                    <td style="font-weight:600;">{{ $order->order_number }}</td>
                    <td>{{ $order->customer_name }}<br><span style="font-size:0.7rem; color:var(--text-light);">{{ $order->customer_reference }}</span></td>
                    <td style="font-size:0.78rem;">{{ $order->warehouse?->name }}</td>
                    <td style="font-size:0.78rem;">{{ $order->lines_count }}</td>
                    <td><span class="badge {{ $s[1] }}">{{ $s[0] }}</span></td>
                    <td style="font-size:0.78rem;">{{ $order->createdBy?->name }}</td>
                    <td style="font-size:0.72rem; color:var(--text-light);">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td style="text-align:right;"><a href="{{ route('tenant.dispatch-orders.show', $order) }}" class="btn-table">Ver</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if($orders->hasPages()) <div style="padding:12px 16px; border-top:1px solid var(--border);">{{ $orders->links() }}</div> @endif
        @else
        <div class="table-empty">No hay órdenes de despacho. <a href="{{ route('tenant.dispatch-orders.create') }}" style="color:var(--jade);">Crea la primera</a></div>
        @endif
    </div>
</x-tenant-layout>
