<x-tenant-layout>
    <x-slot:title>Nuevo producto</x-slot:title>
    <x-slot:header>Nuevo producto</x-slot:header>

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
        .form-input, .form-select, .form-textarea {
            padding: 9px 12px; border: 1px solid var(--border); border-radius: 8px;
            font-size: 0.85rem; font-family: inherit; color: var(--text); background: #fff; transition: border-color 0.15s;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus { outline: none; border-color: var(--jade); box-shadow: 0 0 0 3px rgba(5,150,105,0.08); }
        .form-input::placeholder { color: #d1d5db; }
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

        .category-inline { display: flex; gap: 8px; align-items: flex-end; }
        .category-inline .form-select { flex: 1; }
        .btn-small { padding: 9px 14px; background: #fff; color: var(--text-secondary); border: 1px solid var(--border); border-radius: 8px; font-size: 0.78rem; font-family: inherit; cursor: pointer; white-space: nowrap; }
        .btn-small:hover { border-color: var(--jade); color: var(--jade); }

        .new-category-row { display: none; grid-column: 1 / -1; gap: 8px; align-items: flex-end; }
        .new-category-row.visible { display: flex; }

        @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr 1fr; } .form-group.span2 { grid-column: 1 / -1; } }
        @media (max-width: 480px) { .form-grid { grid-template-columns: 1fr; } }
    </style>
    @endpush

    <div class="form-card">
        <div class="form-header">
            <div class="form-title">Registrar nuevo producto</div>
            <div class="form-subtitle">Completa la información de tu producto para agregarlo al catálogo.</div>
        </div>

        <form action="{{ route('tenant.products.store') }}" method="POST">
            @csrf
            <div class="form-body">
                <div class="form-grid">

                    <div class="form-section-label">Información básica</div>

                    <div class="form-group span2">
                        <label class="form-label" for="name">Nombre del producto *</label>
                        <input type="text" name="name" id="name" class="form-input" value="{{ old('name') }}" required placeholder="Ej. Paracetamol 500mg Caja 20 tabletas">
                        @error('name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="category_id">Categoría</label>
                        <div class="category-inline">
                            <select name="category_id" id="category_id" class="form-select">
                                <option value="">Sin categoría</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn-small" onclick="document.getElementById('newCatRow').classList.toggle('visible')">+ Nueva</button>
                        </div>
                    </div>

                    <div class="new-category-row" id="newCatRow">
                        <div class="form-group" style="flex:1;">
                            <label class="form-label">Nueva categoría</label>
                            <input type="text" id="newCatName" class="form-input" placeholder="Nombre de la categoría">
                        </div>
                        <button type="button" class="btn-small" style="margin-bottom: 6px;" onclick="createCategory()">Crear</button>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="sku">SKU *</label>
                        <input type="text" name="sku" id="sku" class="form-input" value="{{ old('sku') }}" required placeholder="Ej. PARA-500-20" style="text-transform: uppercase;">
                        @error('sku') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="barcode">Código de barras</label>
                        <input type="text" name="barcode" id="barcode" class="form-input" value="{{ old('barcode') }}" placeholder="Ej. 7501234567890">
                        @error('barcode') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="unit_of_measure">Unidad de medida *</label>
                        <select name="unit_of_measure" id="unit_of_measure" class="form-select" required>
                            <option value="pieza" {{ old('unit_of_measure', 'pieza') === 'pieza' ? 'selected' : '' }}>Pieza</option>
                            <option value="caja" {{ old('unit_of_measure') === 'caja' ? 'selected' : '' }}>Caja</option>
                            <option value="kg" {{ old('unit_of_measure') === 'kg' ? 'selected' : '' }}>Kilogramo</option>
                            <option value="litro" {{ old('unit_of_measure') === 'litro' ? 'selected' : '' }}>Litro</option>
                            <option value="metro" {{ old('unit_of_measure') === 'metro' ? 'selected' : '' }}>Metro</option>
                            <option value="paquete" {{ old('unit_of_measure') === 'paquete' ? 'selected' : '' }}>Paquete</option>
                            <option value="rollo" {{ old('unit_of_measure') === 'rollo' ? 'selected' : '' }}>Rollo</option>
                            <option value="par" {{ old('unit_of_measure') === 'par' ? 'selected' : '' }}>Par</option>
                        </select>
                    </div>

                    <div class="form-group full">
                        <label class="form-label" for="description">Descripción</label>
                        <textarea name="description" id="description" class="form-textarea" placeholder="Descripción opcional del producto...">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-divider"></div>
                    <div class="form-section-label">Precios</div>

                    <div class="form-group">
                        <label class="form-label" for="cost_price">Costo unitario (MXN) *</label>
                        <input type="number" name="cost_price" id="cost_price" class="form-input" value="{{ old('cost_price', '0.00') }}" required step="0.01" min="0" placeholder="0.00">
                        @error('cost_price') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="sale_price">Precio de venta (MXN)</label>
                        <input type="number" name="sale_price" id="sale_price" class="form-input" value="{{ old('sale_price', '0.00') }}" step="0.01" min="0" placeholder="0.00">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="weight">Peso (kg)</label>
                        <input type="number" name="weight" id="weight" class="form-input" value="{{ old('weight') }}" step="0.001" min="0" placeholder="0.000">
                    </div>

                    <div class="form-divider"></div>
                    <div class="form-section-label">Reabastecimiento</div>

                    <div class="form-group">
                        <label class="form-label" for="reorder_point">Punto de reorden</label>
                        <input type="number" name="reorder_point" id="reorder_point" class="form-input" value="{{ old('reorder_point', 0) }}" min="0">
                        <span class="form-hint">Alerta cuando el stock baje de esta cantidad</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reorder_qty">Cantidad sugerida</label>
                        <input type="number" name="reorder_qty" id="reorder_qty" class="form-input" value="{{ old('reorder_qty', 0) }}" min="0">
                        <span class="form-hint">Cantidad a pedir al reabastecer</span>
                    </div>

                    <div class="form-divider"></div>
                    <div class="form-section-label">Tracking avanzado</div>

                    <div class="form-group full">
                        <div class="toggle-row">
                            <input type="checkbox" name="track_lots" id="track_lots" class="form-checkbox" value="1" {{ old('track_lots') ? 'checked' : '' }}>
                            <div>
                                <div class="toggle-label">Control por lotes</div>
                                <div class="toggle-hint">Cada entrada requiere número de lote y fecha de caducidad</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group full">
                        <div class="toggle-row">
                            <input type="checkbox" name="track_serials" id="track_serials" class="form-checkbox" value="1" {{ old('track_serials') ? 'checked' : '' }}>
                            <div>
                                <div class="toggle-label">Control por número de serie</div>
                                <div class="toggle-hint">Cada unidad se identifica con un número de serie único</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('tenant.products.index') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">Guardar producto</button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function createCategory() {
            const name = document.getElementById('newCatName').value.trim();
            if (!name) return;

            fetch('{{ route("tenant.categories.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ name }),
            })
            .then(r => r.json())
            .then(() => window.location.reload())
            .catch(() => alert('Error al crear la categoría'));
        }
    </script>
    @endpush
</x-tenant-layout>
