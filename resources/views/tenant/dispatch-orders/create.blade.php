<x-tenant-layout>
    <x-slot:title>Nueva orden de despacho</x-slot:title>
    <x-slot:header>Nueva orden de despacho</x-slot:header>

    @push('styles')
    <style>
        .form-card { background:var(--bg-card); border:1px solid var(--border); border-radius:10px; max-width:600px; }
        .form-header { padding:20px 24px; border-bottom:1px solid var(--border); }
        .form-title { font-size:0.95rem; font-weight:600; }
        .form-subtitle { font-size:0.75rem; color:var(--text-secondary); margin-top:2px; }
        .form-body { padding:24px; display:flex; flex-direction:column; gap:16px; }
        .form-group { display:flex; flex-direction:column; gap:6px; }
        .form-label { font-size:0.72rem; font-weight:600; text-transform:uppercase; letter-spacing:0.04em; color:var(--text-secondary); }
        .form-input,.form-select,.form-textarea { padding:9px 12px; border:1px solid var(--border); border-radius:8px; font-size:0.85rem; font-family:inherit; color:var(--text); background:#fff; }
        .form-input:focus,.form-select:focus { outline:none; border-color:var(--jade); box-shadow:0 0 0 3px rgba(5,150,105,0.08); }
        .form-textarea { resize:vertical; min-height:60px; }
        .form-error { font-size:0.72rem; color:#dc2626; }
        .form-footer { padding:16px 24px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:12px; }
        .btn-primary { padding:9px 24px; background:var(--jade); color:#fff; border:none; border-radius:8px; font-size:0.82rem; font-weight:600; font-family:inherit; cursor:pointer; }
        .btn-secondary { padding:9px 24px; background:#fff; color:var(--text-secondary); border:1px solid var(--border); border-radius:8px; font-size:0.82rem; font-weight:500; font-family:inherit; cursor:pointer; text-decoration:none; }
        .step-indicator { display:flex; gap:8px; margin-bottom:20px; }
        .step { padding:6px 14px; border-radius:50px; font-size:0.72rem; font-weight:600; }
        .step-active { background:var(--jade); color:#fff; }
        .step-inactive { background:#f3f4f6; color:var(--text-light); }
    </style>
    @endpush

    <div class="step-indicator">
        <span class="step step-active">1. Datos del pedido</span>
        <span class="step step-inactive">2. Seleccionar lotes</span>
        <span class="step step-inactive">3. Picking</span>
        <span class="step step-inactive">4. Despachar</span>
    </div>

    <div class="form-card">
        <div class="form-header">
            <div class="form-title">Datos del pedido</div>
            <div class="form-subtitle">Ingresa los datos del cliente y el almacén de origen.</div>
        </div>
        <form action="{{ route('tenant.dispatch-orders.store') }}" method="POST">
            @csrf
            <div class="form-body">
                <div class="form-group">
                    <label class="form-label">Cliente *</label>
                    <input type="text" name="customer_name" class="form-input" required placeholder="Nombre del cliente final" value="{{ old('customer_name') }}">
                    @error('customer_name') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Referencia del pedido</label>
                    <input type="text" name="customer_reference" class="form-input" placeholder="Ej. PED-001, OC del cliente" value="{{ old('customer_reference') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Almacén de origen *</label>
                    <select name="warehouse_id" class="form-select" required>
                        @foreach($warehouses as $wh)
                            <option value="{{ $wh->id }}" {{ $wh->is_default ? 'selected' : '' }}>{{ $wh->name }} ({{ $wh->code }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Notas</label>
                    <textarea name="notes" class="form-textarea" placeholder="Instrucciones especiales...">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="form-footer">
                <a href="{{ route('tenant.dispatch-orders.index') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">Continuar → Seleccionar lotes</button>
            </div>
        </form>
    </div>
</x-tenant-layout>
