<x-tenant-layout>
    <x-slot:title>Seleccionar lotes — {{ $dispatchOrder->order_number }}</x-slot:title>
    <x-slot:header>Seleccionar lotes</x-slot:header>

    @push('styles')
    <style>
        .step-indicator { display:flex; gap:8px; margin-bottom:20px; }
        .step { padding:6px 14px; border-radius:50px; font-size:0.72rem; font-weight:600; }
        .step-active { background:var(--jade); color:#fff; }
        .step-done { background:#dcfce7; color:#16a34a; }
        .step-inactive { background:#f3f4f6; color:var(--text-light); }

        .order-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px; flex-wrap:wrap; gap:12px; }
        .order-title { font-family:'Special Gothic Expanded One',sans-serif; font-size:1rem; color:#585858; }
        .order-meta { font-size:0.78rem; color:var(--text-secondary); margin-top:4px; }

        .card { background:var(--bg-card); border:1px solid var(--border); border-radius:10px; overflow:hidden; margin-bottom:20px; }
        .card-header { padding:14px 20px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; }
        .card-title { font-size:0.82rem; font-weight:600; }
        .card-body { padding:16px 20px; }

        .add-form { display:grid; grid-template-columns:2fr 1.5fr 1fr auto; gap:10px; align-items:end; }
        .add-label { font-size:0.65rem; font-weight:600; text-transform:uppercase; color:var(--text-light); margin-bottom:4px; }
        .add-input,.add-select { padding:8px 10px; border:1px solid var(--border); border-radius:6px; font-size:0.82rem; font-family:inherit; color:var(--text); width:100%; }
        .add-input:focus,.add-select:focus { outline:none; border-color:var(--jade); }
        .btn-add { padding:8px 16px; background:var(--jade); color:#fff; border:none; border-radius:6px; font-size:0.78rem; font-weight:600; font-family:inherit; cursor:pointer; white-space:nowrap; }

        .lines-table { width:100%; border-collapse:collapse; }
        .lines-table th { padding:8px 12px; text-align:left; font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:var(--text-light); border-bottom:1px solid var(--border); }
        .lines-table td { padding:10px 12px; font-size:0.82rem; border-bottom:1px solid #f3f4f6; }

        .stock-info { background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:12px 16px; margin-bottom:16px; }
        .stock-info-title { font-size:0.72rem; font-weight:600; color:#16a34a; margin-bottom:8px; }
        .stock-row { display:flex; justify-content:space-between; padding:4px 0; font-size:0.78rem; border-bottom:1px solid #dcfce7; }
        .stock-row:last-child { border:none; }

        .badge { display:inline-flex; padding:2px 10px; border-radius:50px; font-size:0.65rem; font-weight:600; }
        .badge-amber { background:#fef3c7; color:#d97706; }
        .badge-green { background:#dcfce7; color:#16a34a; }
        .badge-red { background:#fee2e2; color:#dc2626; }

        .btn-action { padding:8px 20px; border-radius:8px; font-size:0.82rem; font-weight:600; font-family:inherit; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:6px; }
        .btn-primary { background:var(--jade); color:#fff; border:none; }
        .btn-outline { background:#fff; color:var(--text-secondary); border:1px solid var(--border); }
        .btn-danger { background:#fff; color:#dc2626; border:1px solid #fecaca; }
        .btn-sm { padding:4px 10px; font-size:0.7rem; border-radius:6px; font-weight:500; font-family:inherit; cursor:pointer; border:1px solid var(--border); background:#fff; color:var(--text-secondary); }
        .btn-sm.danger:hover { border-color:#ef4444; color:#ef4444; }

        .flash-success { padding:12px 16px; background:var(--jade-50); border:1px solid var(--jade-100); border-radius:8px; margin-bottom:20px; font-size:0.8rem; font-weight:500; color:var(--jade-dark); }
        .flash-error { padding:12px 16px; background:#fef2f2; border:1px solid #fecaca; border-radius:8px; margin-bottom:20px; font-size:0.8rem; color:#991b1b; }

        @media (max-width:768px) { .add-form { grid-template-columns:1fr; } }
    </style>
    @endpush

    @if(session('success')) <div class="flash-success">{{ session('success') }}</div> @endif
    @if($errors->any()) <div class="flash-error">{{ $errors->first() }}</div> @endif

    <div class="step-indicator">
        <span class="step step-done">1. Datos</span>
        <span class="step step-active">2. Seleccionar lotes</span>
        <span class="step step-inactive">3. Picking</span>
        <span class="step step-inactive">4. Despachar</span>
    </div>

    <div class="order-header">
        <div>
            <div class="order-title">{{ $dispatchOrder->order_number }}</div>
            <div class="order-meta">Cliente: {{ $dispatchOrder->customer_name }} · {{ $dispatchOrder->warehouse?->name }} @if($dispatchOrder->customer_reference) · Ref: {{ $dispatchOrder->customer_reference }} @endif</div>
        </div>
        <div style="display:flex; gap:8px;">
            <form action="{{ route('tenant.dispatch-orders.cancel', $dispatchOrder) }}" method="POST" onsubmit="return confirm('¿Cancelar esta orden y liberar todo el stock reservado?')">
                @csrf @method('PATCH')
                <button type="submit" class="btn-action btn-danger">Cancelar orden</button>
            </form>
            @if($dispatchOrder->lines->count() > 0)
                <form action="{{ route('tenant.dispatch-orders.start-picking', $dispatchOrder) }}" method="POST" onsubmit="return confirm('¿Iniciar picking? No podrás agregar más productos después.')">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-action btn-primary">Iniciar picking →</button>
                </form>
            @endif
        </div>
    </div>

    {{-- Agregar producto --}}
    <div class="card">
        <div class="card-header"><span class="card-title">Agregar producto al pedido</span></div>
        <div class="card-body">
            <form action="{{ route('tenant.dispatch-orders.add-line', $dispatchOrder) }}" method="POST" class="add-form" id="addLineForm">
                @csrf
                <div>
                    <div class="add-label">Producto</div>
                    <select name="product_id" class="add-select" required id="productSelect" onchange="updateLotOptions()">
                        <option value="">Seleccionar producto...</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->sku }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <div class="add-label">Lote (si aplica)</div>
                    <select name="lot_id" class="add-select" id="lotSelect">
                        <option value="">Sin lote</option>
                    </select>
                </div>
                <div>
                    <div class="add-label">Cantidad</div>
                    <input type="number" name="quantity" class="add-input" required min="0.01" step="0.01" placeholder="0">
                </div>
                <button type="submit" class="btn-add">+ Agregar y reservar</button>
            </form>
        </div>
    </div>

    {{-- Líneas del pedido --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Productos en este pedido ({{ $dispatchOrder->lines->count() }} líneas)</span>
            <span class="badge {{ $dispatchOrder->status === 'reserved' ? 'badge-amber' : 'badge-green' }}">{{ $dispatchOrder->status === 'reserved' ? 'Stock reservado' : 'Borrador' }}</span>
        </div>
        @if($dispatchOrder->lines->count() > 0)
            <table class="lines-table">
                <thead><tr><th>Producto</th><th>Lote</th><th>Caducidad</th><th>Cantidad</th><th style="text-align:right;">Acción</th></tr></thead>
                <tbody>
                @foreach($dispatchOrder->lines as $line)
                    <tr>
                        <td style="font-weight:600;">{{ $line->product?->name }}<br><span style="font-size:0.7rem; color:var(--text-light);">{{ $line->product?->sku }}</span></td>
                        <td>{{ $line->lot?->lot_number ?? '—' }}</td>
                        <td style="font-size:0.78rem;">{{ $line->lot?->expires_at?->format('d/m/Y') ?? '—' }}</td>
                        <td style="font-weight:600;">{{ number_format($line->quantity_requested) }}</td>
                        <td style="text-align:right;">
                            <form action="{{ route('tenant.dispatch-orders.remove-line', [$dispatchOrder, $line]) }}" method="POST" onsubmit="return confirm('¿Quitar este producto? El stock se liberará.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-sm danger">Quitar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div style="padding:32px; text-align:center; color:var(--text-light); font-size:0.82rem;">Agrega productos para comenzar el pedido.</div>
        @endif
    </div>

    @push('scripts')
    <script>
        const stockByProduct = @json($stockByProduct);

        function updateLotOptions() {
            const productId = document.getElementById('productSelect').value;
            const lotSelect = document.getElementById('lotSelect');
            lotSelect.innerHTML = '<option value="">Sin lote</option>';

            if (productId && stockByProduct[productId]) {
                stockByProduct[productId].forEach(function(stock) {
                    if (stock.lot) {
                        const expires = stock.lot.expires_at ? ' — Vence: ' + new Date(stock.lot.expires_at).toLocaleDateString('es-MX') : '';
                        const opt = document.createElement('option');
                        opt.value = stock.lot.id;
                        opt.textContent = stock.lot.lot_number + expires + ' (Disp: ' + Math.floor(stock.qty_available) + ')';
                        lotSelect.appendChild(opt);
                    }
                });
            }
        }
    </script>
    @endpush
</x-tenant-layout>
