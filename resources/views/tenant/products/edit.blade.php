<x-tenant-layout>
    <x-slot:title>Editar producto</x-slot:title>
    <x-slot:header>Editar producto</x-slot:header>

    @push('styles')
    <style>
        .form-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; max-width: 780px; }
        .form-header { padding: 20px 24px; border-bottom: 1px solid var(--border); }
        .form-title { font-size: 0.95rem; font-weight: 600; color: var(--text); }
        .form-subtitle { font-size: 0.75rem; color: var(--text-secondary); margin-top: 2px; }
        .form-body { padding: 24px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full { grid-column: 1 / -1; }
        .form-group.span2 { grid-column: span 2; }
        .form-label { font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; color: var(--text-secondary); }
        .form-input, .form-select, .form-textarea { padding: 9px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.85rem; font-family: inherit; color: var(--text); background: #fff; }
        .form-input:focus, .form-select:focus, .form-textarea:focus { outline: none; border-color: var(--jade); box-shadow: 0 0 0 3px rgba(5,150,105,0.08); }
        .form-textarea { resize: vertical; min-height: 80px; }
        .form-error { font-size: 0.72rem; color: #dc2626; }
        .form-hint { font-size: 0.68rem; color: var(--text-light); }
        .form-footer { padding: 16px 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 12px; }
        .btn-primary { padding: 9px 24px; background: var(--jade); color: #fff; border: none; border-radius: 8px; font-size: 0.82rem; font-weight: 600; font-family: inherit; cursor: pointer; }
        .btn-primary:hover { background: var(--jade-dark); }
        .btn-secondary { padding: 9px 24px; background: #fff; color: var(--text-secondary); border: 1px solid var(--border); border-radius: 8px; font-size: 0.82rem; font-weight: 500; font-family: inherit; cursor: pointer; text-decoration: none; }
        .btn-secondary:hover { border-color: var(--jade); color: var(--jade); }
        .form-divider { grid-column: 1 / -1; height: 1px; background: var(--border); margin: 4px 0; }
        .form-section-label { grid-column: 1 / -1; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-light); padding-top: 4px; }
        .toggle-row { display: flex; align-items: center; gap: 10px; padding: 8px 0; }
        .toggle-label { font-size: 0.82rem; color: var(--text); }
        .toggle-hint { font-size: 0.68rem; color: var(--text-light); }
        .form-checkbox { width: 18px; height: 18px; accent-color: var(--jade); cursor: pointer; }
        @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr 1fr; } .form-group.span2 { grid-column: 1 / -1; } }
        @media (max-width: 480px) { .form-grid { grid-template-columns: 1fr; } }
    </style>
    @endpush

    <div class="form-card">
        <div class="form-header">
            <div class="form-title">Editar: {{ $product->name }}</div>
            <div class="form-subtitle">SKU: {{ $product->sku }}</div>
        </div>

        <form action="{{ route('tenant.products.update', $product) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-body">
                <div class="form-grid">

                    <div class="form-section-label">Información básica</div>

                    <div class="form-group span2">
                        <label class="form-label" for="name">Nombre *</label>
                        <input type="text" name="name" id="name" class="form-input" value="{{ old('name', $product->name) }}" required>
                        @error('name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="category_id">Categoría</label>
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">Sin categoría</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="sku">SKU *</label>
                        <input type="text" name="sku" id="sku" class="form-input" value="{{ old('sku', $product->sku) }}" required style="text-transform: uppercase;">
                        @error('sku') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="barcode">Código de barras</label>
                        <input type="text" name="barcode" id="barcode" class="form-input" value="{{ old('barcode', $product->barcode) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="unit_of_measure">Unidad *</label>
                        <select name="unit_of_measure" id="unit_of_measure" class="form-select" required>
                            @foreach(['pieza','caja','kg','litro','metro','paquete','rollo','par'] as $uom)
                                <option value="{{ $uom }}" {{ old('unit_of_measure', $product->unit_of_measure) === $uom ? 'selected' : '' }}>{{ ucfirst($uom) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group full">
                        <label class="form-label" for="description">Descripción</label>
                        <textarea name="description" id="description" class="form-textarea">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="form-divider"></div>
                    <div class="form-section-label">Precios</div>

                    <div class="form-group">
                        <label class="form-label" for="cost_price">Costo (MXN) *</label>
                        <input type="number" name="cost_price" id="cost_price" class="form-input" value="{{ old('cost_price', $product->cost_price) }}" required step="0.01" min="0">
                        @error('cost_price') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="sale_price">Precio venta (MXN)</label>
                        <input type="number" name="sale_price" id="sale_price" class="form-input" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" min="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="weight">Peso (kg)</label>
                        <input type="number" name="weight" id="weight" class="form-input" value="{{ old('weight', $product->weight) }}" step="0.001" min="0">
                    </div>

                    <div class="form-divider"></div>
                    <div class="form-section-label">Reabastecimiento</div>

                    <div class="form-group">
                        <label class="form-label" for="reorder_point">Punto de reorden</label>
                        <input type="number" name="reorder_point" id="reorder_point" class="form-input" value="{{ old('reorder_point', $product->reorder_point) }}" min="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reorder_qty">Cantidad sugerida</label>
                        <input type="number" name="reorder_qty" id="reorder_qty" class="form-input" value="{{ old('reorder_qty', $product->reorder_qty) }}" min="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="is_active">Estado</label>
                        <select name="is_active" id="is_active" class="form-select">
                            <option value="1" {{ old('is_active', $product->is_active ? '1' : '0') === '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('is_active', $product->is_active ? '1' : '0') === '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="form-divider"></div>
                    <div class="form-section-label">Tracking avanzado</div>

                    <div class="form-group full">
                        @php $lotsDisabled = !$canTrackLots && !$product->track_lots; @endphp
                        <div class="toggle-row" style="{{ $lotsDisabled ? 'opacity: 0.5;' : '' }}">
                            <input type="checkbox" name="track_lots" id="track_lots" class="form-checkbox" value="1" {{ old('track_lots', $product->track_lots) ? 'checked' : '' }} {{ $lotsDisabled ? 'disabled' : '' }}>
                            <div>
                                <div class="toggle-label">Control por lotes @if($lotsDisabled)<span style="font-size:0.68rem; color:#d97706; font-weight:400;">(Plan Profesional)</span>@endif</div>
                                <div class="toggle-hint">{{ $lotsDisabled ? 'Actualiza tu plan para habilitar control por lotes' : 'Número de lote y fecha de caducidad por entrada' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group full">
                        @php $serialsDisabled = !$canTrackSerials && !$product->track_serials; @endphp
                        <div class="toggle-row" style="{{ $serialsDisabled ? 'opacity: 0.5;' : '' }}">
                            <input type="checkbox" name="track_serials" id="track_serials" class="form-checkbox" value="1" {{ old('track_serials', $product->track_serials) ? 'checked' : '' }} {{ $serialsDisabled ? 'disabled' : '' }}>
                            <div>
                                <div class="toggle-label">Control por número de serie @if($serialsDisabled)<span style="font-size:0.68rem; color:#d97706; font-weight:400;">(Plan Profesional)</span>@endif</div>
                                <div class="toggle-hint">{{ $serialsDisabled ? 'Actualiza tu plan para habilitar control por series' : 'Cada unidad con número de serie único' }}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('tenant.products.index') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
</x-tenant-layout>
