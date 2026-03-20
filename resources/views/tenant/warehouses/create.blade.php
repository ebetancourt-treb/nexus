<x-tenant-layout>
    <x-slot:title>Nuevo almacén</x-slot:title>
    <x-slot:header>Nuevo almacén</x-slot:header>

    @push('styles')
    <style>
        .form-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; max-width: 720px; }
        .form-header { padding: 20px 24px; border-bottom: 1px solid var(--border); }
        .form-title { font-size: 0.95rem; font-weight: 600; color: var(--text); }
        .form-subtitle { font-size: 0.75rem; color: var(--text-secondary); margin-top: 2px; }
        .form-body { padding: 24px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full { grid-column: 1 / -1; }
        .form-label { font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; color: var(--text-secondary); }
        .form-input {
            padding: 9px 12px; border: 1px solid var(--border); border-radius: 8px;
            font-size: 0.85rem; font-family: inherit; color: var(--text);
            background: #fff; transition: border-color 0.15s;
        }
        .form-input:focus { outline: none; border-color: var(--jade); box-shadow: 0 0 0 3px rgba(5,150,105,0.08); }
        .form-input::placeholder { color: #d1d5db; }
        .form-select {
            padding: 9px 12px; border: 1px solid var(--border); border-radius: 8px;
            font-size: 0.85rem; font-family: inherit; color: var(--text);
            background: #fff; cursor: pointer;
        }
        .form-select:focus { outline: none; border-color: var(--jade); box-shadow: 0 0 0 3px rgba(5,150,105,0.08); }
        .form-error { font-size: 0.72rem; color: #dc2626; }
        .form-hint { font-size: 0.68rem; color: var(--text-light); }
        .form-footer { padding: 16px 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 12px; }
        .btn-primary {
            padding: 9px 24px; background: var(--jade); color: #fff; border: none;
            border-radius: 8px; font-size: 0.82rem; font-weight: 600; font-family: inherit;
            cursor: pointer; transition: background 0.2s;
        }
        .btn-primary:hover { background: var(--jade-dark); }
        .btn-secondary {
            padding: 9px 24px; background: #fff; color: var(--text-secondary); border: 1px solid var(--border);
            border-radius: 8px; font-size: 0.82rem; font-weight: 500; font-family: inherit;
            cursor: pointer; text-decoration: none; transition: all 0.15s;
        }
        .btn-secondary:hover { border-color: var(--jade); color: var(--jade); }
        .form-divider { grid-column: 1 / -1; height: 1px; background: var(--border); margin: 4px 0; }
        .form-section-label { grid-column: 1 / -1; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-light); padding-top: 4px; }
        @media (max-width: 640px) { .form-grid { grid-template-columns: 1fr; } }
    </style>
    @endpush

    <div class="form-card">
        <div class="form-header">
            <div class="form-title">Registrar nuevo almacén</div>
            <div class="form-subtitle">Configura los datos básicos de tu almacén o sucursal.</div>
        </div>

        <form action="{{ route('tenant.warehouses.store') }}" method="POST">
            @csrf
            <div class="form-body">
                <div class="form-grid">

                    <div class="form-section-label">Información general</div>

                    <div class="form-group">
                        <label class="form-label" for="name">Nombre del almacén *</label>
                        <input type="text" name="name" id="name" class="form-input" value="{{ old('name') }}" required placeholder="Ej. Almacén Central">
                        @error('name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="code">Código *</label>
                        <input type="text" name="code" id="code" class="form-input" value="{{ old('code') }}" required placeholder="Ej. ALM-02" maxlength="20" style="text-transform: uppercase;">
                        <span class="form-hint">Identificador único, máximo 20 caracteres</span>
                        @error('code') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="rotation_strategy">Estrategia de rotación *</label>
                        <select name="rotation_strategy" id="rotation_strategy" class="form-select" required>
                            <option value="fifo" {{ old('rotation_strategy', 'fifo') === 'fifo' ? 'selected' : '' }}>FIFO — Primero en entrar, primero en salir</option>
                            <option value="fefo" {{ old('rotation_strategy') === 'fefo' ? 'selected' : '' }}>FEFO — Primero en expirar, primero en salir</option>
                            <option value="manual" {{ old('rotation_strategy') === 'manual' ? 'selected' : '' }}>Manual — Sin regla automática</option>
                        </select>
                        @error('rotation_strategy') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="is_active">Estado</label>
                        <select name="is_active" id="is_active" class="form-select">
                            <option value="1" {{ old('is_active', '1') === '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="form-divider"></div>
                    <div class="form-section-label">Ubicación (opcional)</div>

                    <div class="form-group full">
                        <label class="form-label" for="address">Dirección</label>
                        <input type="text" name="address" id="address" class="form-input" value="{{ old('address') }}" placeholder="Calle, número, colonia">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="city">Ciudad</label>
                        <input type="text" name="city" id="city" class="form-input" value="{{ old('city') }}" placeholder="Ej. Torreón">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="state">Estado</label>
                        <input type="text" name="state" id="state" class="form-input" value="{{ old('state') }}" placeholder="Ej. Coahuila">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="zip_code">Código postal</label>
                        <input type="text" name="zip_code" id="zip_code" class="form-input" value="{{ old('zip_code') }}" placeholder="Ej. 27000" maxlength="10">
                    </div>

                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('tenant.warehouses.index') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">Guardar almacén</button>
            </div>
        </form>
    </div>
</x-tenant-layout>
