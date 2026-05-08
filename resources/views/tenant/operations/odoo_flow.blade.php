<x-tenant-layout>
    <x-slot:title>Sincronización Odoo</x-slot:title>
    <x-slot:header>Operaciones Remotas</x-slot:header>

    @push('styles')
    <style>
        .page-actions { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
        .btn-primary { display: inline-flex; align-items: center; gap: 8px; padding: 9px 20px; background: var(--jade); color: #fff; border: none; border-radius: 8px; font-size: 0.8rem; font-weight: 600; font-family: inherit; cursor: pointer; text-decoration: none; transition: background 0.2s; }
        .btn-primary:hover { background: var(--jade-dark); }
        .btn-primary svg { width: 16px; height: 16px; }

        .flash-success { padding: 12px 16px; background: var(--jade-50); border: 1px solid var(--jade-100); border-radius: 8px; margin-bottom: 20px; font-size: 0.8rem; font-weight: 500; color: var(--jade-dark); }
        .flash-error { padding: 12px 16px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; margin-bottom: 20px; font-size: 0.8rem; font-weight: 500; color: #991b1b; }

        .table-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; padding: 24px; }
        
        /* Estilos específicos para el formulario de Odoo integrados con tu UI */
        .layout-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
        .form-group.full-width { grid-column: span 2; }
        
        .form-label { display: block; font-size: 0.78rem; font-weight: 600; color: var(--text); margin-bottom: 6px; }
        .form-control { width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.85rem; font-family: inherit; color: var(--text); background: #fff; transition: border-color 0.2s; }
        .form-control:focus { outline: none; border-color: var(--jade); box-shadow: 0 0 0 3px rgba(5,150,105,0.08); }
        .form-hint { font-size: 0.7rem; color: var(--text-light); margin-top: 6px; }

        .info-panel { background: #f8fafc; border: 1px solid var(--border); border-radius: 10px; padding: 20px; }
        .info-title { font-size: 0.9rem; font-weight: 700; color: var(--text); margin-bottom: 14px; display: flex; align-items: center; gap: 8px;}
        .info-list { list-style: none; padding: 0; margin: 0; font-size: 0.8rem; color: var(--text-secondary); }
        .info-list li { margin-bottom: 12px; display: flex; gap: 10px; line-height: 1.4; }
        .info-number { color: var(--jade); font-weight: 800; }

        @media (max-width: 768px) {
            .layout-grid { grid-template-columns: 1fr; }
            .form-grid { grid-template-columns: 1fr; }
            .form-group.full-width { grid-column: span 1; }
        }
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
            <h2 style="font-family: 'Special Gothic Expanded One', sans-serif; font-size: 1.1rem; color: #585858;">Integración ERP</h2>
            <p style="font-size: 0.78rem; color: var(--text-secondary); margin-top: 2px;">Demostración de flujo operativo en tiempo real hacia Odoo</p>
        </div>
    </div>

    <div class="layout-grid">
        <div class="table-card">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text); margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 12px;">Registrar Movimiento en Rampa</h3>
            
            <form action="{{ route('tenant.operations.odoo.process') }}" method="POST">
                @csrf
                
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label class="form-label">Producto (Catálogo de Odoo)</label>
                        <select name="odoo_product_id" required class="form-control">
                            <option value="">-- Selecciona un producto a mover --</option>
                            @forelse($productos as $prod)
                                <option value="{{ $prod['id'] }}">
                                    [{{ $prod['default_code'] ?? 'S/C' }}] {{ $prod['name'] }} (Stock: {{ number_format($prod['qty_available'], 2) }})
                                </option>
                            @empty
                                <option value="" disabled>No se pudo cargar el catálogo o no hay productos.</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tipo de Operación</label>
                        <select name="operation_type" required class="form-control">
                            <option value="in">Recepción (Entrada al Almacén)</option>
                            <option value="out">Entrega (Salida a Cliente)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Cantidad Física</label>
                        <input type="number" name="quantity" min="1" step="1" required class="form-control" placeholder="Ej. 10">
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">Ubicación de Piso / Rack (Referencia Local)</label>
                        <input type="text" name="ubicacion_piso" required class="form-control" placeholder="Ej. Pasillo A - Estante 3">
                        <p class="form-hint">Este dato se enviará y quedará registrado en el ERP como documento origen.</p>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 10px;">
                    <button type="submit" class="btn-primary">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                        Ejecutar Sincronización
                    </button>
                </div>
            </form>
        </div>

        <div class="info-panel">
            <h3 class="info-title">
                <svg style="width: 20px; height: 20px; color: var(--jade);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                Flujo de la Demostración
            </h3>
            <ul class="info-list">
                <li>
                    <span class="info-number">1.</span>
                    <span>El selector de productos ya está conectado en vivo al ERP.</span>
                </li>
                <li>
                    <span class="info-number">2.</span>
                    <span>Al ejecutar, el WMS creará un documento <strong>stock.picking</strong> directamente en la base de datos externa.</span>
                </li>
                <li>
                    <span class="info-number">3.</span>
                    <span>Revisa el módulo de <strong>Inventario</strong> en Odoo; la operación aparecerá lista para ser validada por el administrador.</span>
                </li>
            </ul>
        </div>
    </div>
</x-tenant-layout>