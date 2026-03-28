<x-tenant-layout>
    <x-slot:title>Picking — {{ $order->order_number }}</x-slot:title>
    <x-slot:header>Picking</x-slot:header>

    @push('styles')
    <style>
        .step-indicator { display:flex; gap:8px; margin-bottom:20px; }
        .step { padding:6px 14px; border-radius:50px; font-size:0.72rem; font-weight:600; }
        .step-active { background:var(--jade); color:#fff; }
        .step-done { background:#dcfce7; color:#16a34a; }
        .step-inactive { background:#f3f4f6; color:var(--text-light); }

        .order-header { margin-bottom:20px; }
        .order-title { font-family:'Special Gothic Expanded One',sans-serif; font-size:1rem; color:#585858; }
        .order-meta { font-size:0.78rem; color:var(--text-secondary); margin-top:4px; }

        .card { background:var(--bg-card); border:1px solid var(--border); border-radius:10px; overflow:hidden; margin-bottom:16px; }
        .card-header { padding:14px 20px; border-bottom:1px solid var(--border); }
        .card-title { font-size:0.82rem; font-weight:600; }

        .pick-item { padding:16px 20px; border-bottom:1px solid #f3f4f6; display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap; }
        .pick-item:last-child { border:none; }
        .pick-item.done { background:#f0fdf4; }
        .pick-info { flex:1; }
        .pick-product { font-weight:600; font-size:0.88rem; }
        .pick-detail { font-size:0.75rem; color:var(--text-secondary); margin-top:4px; }
        .pick-qty { font-size:1.2rem; font-weight:700; color:var(--jade); min-width:80px; text-align:center; }
        .pick-action { display:flex; align-items:center; gap:8px; }
        .pick-input { padding:7px 10px; border:1px solid var(--border); border-radius:6px; font-size:0.85rem; font-family:inherit; width:80px; text-align:center; }
        .pick-input:focus { outline:none; border-color:var(--jade); }
        .btn-pick { padding:7px 14px; background:var(--jade); color:#fff; border:none; border-radius:6px; font-size:0.78rem; font-weight:600; font-family:inherit; cursor:pointer; }
        .btn-pick:hover { background:var(--jade-dark); }
        .badge { display:inline-flex; padding:2px 10px; border-radius:50px; font-size:0.65rem; font-weight:600; }
        .badge-green { background:#dcfce7; color:#16a34a; }
        .badge-amber { background:#fef3c7; color:#d97706; }

        .btn-print { padding:8px 16px; background:#fff; color:var(--text-secondary); border:1px solid var(--border); border-radius:8px; font-size:0.78rem; font-weight:500; font-family:inherit; cursor:pointer; text-decoration:none; }

        .flash-success { padding:12px 16px; background:var(--jade-50); border:1px solid var(--jade-100); border-radius:8px; margin-bottom:20px; font-size:0.8rem; font-weight:500; color:var(--jade-dark); }
    </style>
    @endpush

    @if(session('success')) <div class="flash-success">{{ session('success') }}</div> @endif

    <div class="step-indicator">
        <span class="step step-done">1. Datos</span>
        <span class="step step-done">2. Lotes</span>
        <span class="step step-active">3. Picking</span>
        <span class="step step-inactive">4. Despachar</span>
    </div>

    <div class="order-header" style="display:flex; justify-content:space-between; align-items:flex-start;">
        <div>
            <div class="order-title">Picking — {{ $order->order_number }}</div>
            <div class="order-meta">Cliente: {{ $order->customer_name }} · {{ $order->warehouse?->name }}</div>
        </div>
        <a href="{{ route('tenant.dispatch-orders.picking-pdf', $order) }}" target="_blank" class="btn-print">Imprimir lista de picking</a>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Recoge los siguientes productos del anaquel</span>
        </div>
        @foreach($order->lines as $line)
            <div class="pick-item {{ $line->is_picked ? 'done' : '' }}">
                <div class="pick-info">
                    <div class="pick-product">{{ $line->product?->name }}</div>
                    <div class="pick-detail">
                        SKU: {{ $line->product?->sku }}
                        @if($line->lot) · Lote: {{ $line->lot->lot_number }} @endif
                        @if($line->lot?->expires_at) · Vence: {{ $line->lot->expires_at->format('d/m/Y') }} @endif
                        @if($line->location_note) · Ubicación: {{ $line->location_note }} @endif
                    </div>
                </div>
                <div class="pick-qty">{{ number_format($line->quantity_requested) }}</div>
                <div class="pick-action">
                    @if($line->is_picked)
                        <span class="badge badge-green">Recogido: {{ number_format($line->quantity_picked) }}</span>
                    @else
                        <form action="{{ route('tenant.dispatch-orders.mark-picked', [$order, $line]) }}" method="POST" style="display:flex; gap:6px; align-items:center;">
                            @csrf @method('PATCH')
                            <input type="number" name="quantity_picked" class="pick-input" value="{{ $line->quantity_requested }}" min="0" max="{{ $line->quantity_requested }}" step="1">
                            <button type="submit" class="btn-pick">Confirmar</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</x-tenant-layout>
