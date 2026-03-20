<x-tenant-layout>
    <x-slot:title>Nueva recepción</x-slot:title>
    <x-slot:header>Nueva recepción</x-slot:header>

    @push('styles')
    <style>
        .form-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; max-width: 960px; }
        .form-header { padding: 20px 24px; border-bottom: 1px solid var(--border); }
        .form-title { font-size: 0.95rem; font-weight: 600; color: var(--text); }
        .form-subtitle { font-size: 0.75rem; color: var(--text-secondary); margin-top: 2px; }
        .form-body { padding: 24px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full { grid-column: 1 / -1; }
        .form-label { font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; color: var(--text-secondary); }
        .form-input, .form-select, .form-textarea { padding: 9px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.85rem; font-family: inherit; color: var(--text); background: #fff; }
        .form-input:focus, .form-select:focus { outline: none; border-color: var(--jade); box-shadow: 0 0 0 3px rgba(5,150,105,0.08); }
        .form-textarea { resize: vertical; min-height: 60px; }
        .form-footer { padding: 16px 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 12px; }
        .btn-primary { padding: 9px 24px; background: var(--jade); color: #fff; border: none; border-radius: 8px; font-size: 0.82rem; font-weight: 600; font-family: inherit; cursor: pointer; }
        .btn-primary:hover { background: var(--jade-dark); }
        .btn-secondary { padding: 9px 24px; background: #fff; color: var(--text-secondary); border: 1px solid var(--border); border-radius: 8px; font-size: 0.82rem; font-weight: 500; font-family: inherit; cursor: pointer; text-decoration: none; }
        .btn-secondary:hover { border-color: var(--jade); color: var(--jade); }
        .form-divider { grid-column: 1 / -1; height: 1px; background: var(--border); margin: 4px 0; }
        .form-section-label { grid-column: 1 / -1; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-light); padding-top: 4px; }

        /* Scanner input */
        .scanner-bar { display: flex; gap: 10px; align-items: flex-end; margin-bottom: 16px; padding: 16px; background: var(--jade-50); border: 1px solid var(--jade-100); border-radius: 10px; }
        .scanner-input { flex: 1; padding: 11px 14px; border: 2px solid var(--jade); border-radius: 8px; font-size: 0.95rem; font-family: inherit; color: var(--text); background: #fff; }
        .scanner-input:focus { outline: none; box-shadow: 0 0 0 4px rgba(5,150,105,0.15); }
        .scanner-input::placeholder { color: #a7f3d0; }
        .scanner-label { font-size: 0.72rem; font-weight: 600; color: var(--jade-dark); margin-bottom: 6px; }
        .scanner-hint { font-size: 0.68rem; color: var(--jade); margin-top: 6px; }

        /* Search results */
        .search-results { position: absolute; top: 100%; left: 0; right: 0; background: #fff; border: 1px solid var(--border); border-radius: 8px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); z-index: 20; max-height: 240px; overflow-y: auto; display: none; }
        .search-results.visible { display: block; }
        .search-result-item { padding: 10px 14px; cursor: pointer; border-bottom: 1px solid #f3f4f6; font-size: 0.82rem; }
        .search-result-item:hover { background: var(--jade-50); }
        .search-result-item:last-child { border-bottom: none; }
        .search-result-name { font-weight: 600; color: var(--text); }
        .search-result-meta { font-size: 0.7rem; color: var(--text-light); margin-top: 2px; }

        /* Lines */
        .lines-container { margin-top: 8px; }
        .line-card { background: #fafafa; border: 1px solid var(--border); border-radius: 8px; padding: 16px; margin-bottom: 10px; position: relative; }
        .line-card:hover { border-color: #d1d5db; }
        .line-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .line-product-name { font-weight: 600; font-size: 0.85rem; color: var(--text); }
        .line-product-sku { font-size: 0.7rem; color: var(--text-light); }
        .line-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }
        .line-grid-lot { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 10px; padding-top: 10px; border-top: 1px dashed #e5e7eb; }
        .btn-remove { width: 28px; height: 28px; border-radius: 6px; border: 1px solid var(--border); background: #fff; color: #9ca3af; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px; }
        .btn-remove:hover { border-color: #ef4444; color: #ef4444; background: #fef2f2; }
        .line-input { padding: 7px 10px; border: 1px solid var(--border); border-radius: 6px; font-size: 0.8rem; font-family: inherit; color: var(--text); background: #fff; width: 100%; }
        .line-input:focus { outline: none; border-color: var(--jade); }
        .line-label { font-size: 0.65rem; font-weight: 600; color: var(--text-light); text-transform: uppercase; margin-bottom: 4px; }

        .flash-error { padding: 12px 16px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; margin-bottom: 20px; font-size: 0.8rem; font-weight: 500; color: #991b1b; }
        .lines-empty { text-align: center; padding: 24px; color: var(--text-light); font-size: 0.82rem; border: 1px dashed var(--border); border-radius: 8px; }

        @media (max-width: 640px) { .line-grid { grid-template-columns: 1fr; } .line-grid-lot { grid-template-columns: 1fr; } .scanner-bar { flex-direction: column; } }
    </style>
    @endpush

    @if($errors->any()) <div class="flash-error">{{ $errors->first() }}</div> @endif

    <div class="form-card">
        <div class="form-header">
            <div class="form-title">Recepción de mercancía</div>
            <div class="form-subtitle">Escanea el código de barras o busca por SKU para agregar productos. Puedes registrar múltiples lotes en un solo movimiento.</div>
        </div>

        <form action="{{ route('tenant.movements.store-receiving') }}" method="POST" id="receivingForm">
            @csrf
            <div class="form-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Almacén destino *</label>
                        <select name="warehouse_id" class="form-select" required>
                            @foreach($warehouses as $wh)
                                <option value="{{ $wh->id }}" {{ $wh->is_default ? 'selected' : '' }}>{{ $wh->name }} ({{ $wh->code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Referencia</label>
                        <input type="text" name="reference" class="form-input" placeholder="Ej. OC-2024-001, Factura F-123" value="{{ old('reference') }}">
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Notas</label>
                        <textarea name="notes" class="form-textarea" placeholder="Notas opcionales...">{{ old('notes') }}</textarea>
                    </div>

                    <div class="form-divider"></div>
                    <div class="form-section-label">Agregar productos</div>
                </div>

                <!-- Scanner / búsqueda -->
                <div class="scanner-bar">
                    <div style="flex: 1; position: relative;">
                        <div class="scanner-label">Escanea o busca el producto</div>
                        <input type="text" id="scannerInput" class="scanner-input" placeholder="Código de barras, SKU o nombre del producto..." autocomplete="off">
                        <div class="scanner-hint">El cursor del scanner escribe aquí. También puedes escribir manualmente.</div>
                        <div class="search-results" id="searchResults"></div>
                    </div>
                </div>

                <!-- Líneas agregadas -->
                <div class="lines-container" id="linesContainer">
                    <div class="lines-empty" id="linesEmpty">Escanea o busca un producto para agregarlo a esta recepción.</div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('tenant.movements.index') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary" id="submitBtn" disabled>Confirmar recepción</button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        let lineIndex = 0;
        let searchTimeout = null;
        const scannerInput = document.getElementById('scannerInput');
        const searchResults = document.getElementById('searchResults');
        const linesContainer = document.getElementById('linesContainer');
        const linesEmpty = document.getElementById('linesEmpty');
        const submitBtn = document.getElementById('submitBtn');
        const searchUrl = '{{ route("tenant.products.search") }}';

        // Búsqueda con debounce
        scannerInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            const q = this.value.trim();

            if (q.length < 1) {
                searchResults.classList.remove('visible');
                return;
            }

            searchTimeout = setTimeout(() => searchProducts(q), 200);
        });

        // Enter = seleccionar primer resultado (simula scanner)
        scannerInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const first = searchResults.querySelector('.search-result-item');
                if (first) first.click();
            }
        });

        // Cerrar resultados al hacer click fuera
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.scanner-bar')) {
                searchResults.classList.remove('visible');
            }
        });

        async function searchProducts(query) {
            try {
                const res = await fetch(`${searchUrl}?q=${encodeURIComponent(query)}`, {
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                });
                const products = await res.json();

                if (products.length === 0) {
                    searchResults.innerHTML = '<div style="padding:12px 14px; font-size:0.82rem; color:var(--text-light);">No se encontraron productos</div>';
                    searchResults.classList.add('visible');
                    return;
                }

                // Si es match exacto por barcode (scanner), agregar automáticamente
                if (products.length === 1 && (products[0].barcode === query || products[0].sku === query)) {
                    addProductLine(products[0]);
                    scannerInput.value = '';
                    searchResults.classList.remove('visible');
                    return;
                }

                searchResults.innerHTML = products.map(p => `
                    <div class="search-result-item" onclick='selectProduct(${JSON.stringify(p)})'>
                        <div class="search-result-name">${p.name}</div>
                        <div class="search-result-meta">SKU: ${p.sku} ${p.barcode ? '· Barcode: ' + p.barcode : ''} · ${p.unit_of_measure}</div>
                    </div>
                `).join('');
                searchResults.classList.add('visible');
            } catch (err) {
                console.error('Error buscando productos:', err);
            }
        }

        function selectProduct(product) {
            addProductLine(product);
            scannerInput.value = '';
            searchResults.classList.remove('visible');
            scannerInput.focus();
        }

        function addProductLine(product) {
            linesEmpty.style.display = 'none';
            submitBtn.disabled = false;

            const showLots = product.track_lots;
            const lotHtml = showLots ? `
                <div class="line-grid-lot">
                    <div>
                        <div class="line-label">Número de lote</div>
                        <input type="text" name="lines[${lineIndex}][lot_number]" class="line-input" placeholder="Ej. LOT-2024-A1">
                    </div>
                    <div>
                        <div class="line-label">Fecha de caducidad</div>
                        <input type="date" name="lines[${lineIndex}][expires_at]" class="line-input">
                    </div>
                </div>` : '';

            const html = `
                <div class="line-card" data-index="${lineIndex}">
                    <input type="hidden" name="lines[${lineIndex}][product_id]" value="${product.id}">
                    <div class="line-header">
                        <div>
                            <div class="line-product-name">${product.name}</div>
                            <div class="line-product-sku">SKU: ${product.sku} ${product.barcode ? '· ' + product.barcode : ''} · ${product.unit_of_measure}${showLots ? ' · Control por lotes' : ''}</div>
                        </div>
                        <button type="button" class="btn-remove" onclick="removeLine(this)">&times;</button>
                    </div>
                    <div class="line-grid">
                        <div>
                            <div class="line-label">Cantidad *</div>
                            <input type="number" name="lines[${lineIndex}][quantity]" class="line-input" required min="0.01" step="0.01" placeholder="0" autofocus>
                        </div>
                        <div>
                            <div class="line-label">Costo unitario</div>
                            <input type="number" name="lines[${lineIndex}][unit_cost]" class="line-input" min="0" step="0.01" placeholder="0.00" value="${product.cost_price || ''}">
                        </div>
                        <div></div>
                    </div>
                    ${lotHtml}
                </div>`;

            linesContainer.insertAdjacentHTML('beforeend', html);
            lineIndex++;

            // Focus en el campo de cantidad de la línea recién agregada
            const lastQtyInput = linesContainer.querySelector('.line-card:last-child input[type="number"]');
            if (lastQtyInput) lastQtyInput.focus();
        }

        function removeLine(btn) {
            btn.closest('.line-card').remove();
            const remaining = linesContainer.querySelectorAll('.line-card').length;
            if (remaining === 0) {
                linesEmpty.style.display = 'block';
                submitBtn.disabled = true;
            }
        }
    </script>
    @endpush
</x-tenant-layout>
