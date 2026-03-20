<x-tenant-layout>
    <x-slot:title>Límite alcanzado</x-slot:title>
    <x-slot:header>Almacenes</x-slot:header>

    @push('styles')
    <style>
        .limit-card {
            background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px;
            max-width: 520px; margin: 48px auto; text-align: center; padding: 48px 32px;
        }
        .limit-icon {
            width: 56px; height: 56px; border-radius: 12px; background: #fef3c7;
            display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;
            font-size: 1.5rem;
        }
        .limit-title { font-size: 1rem; font-weight: 600; color: var(--text); margin-bottom: 8px; }
        .limit-text { font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 24px; line-height: 1.6; }
        .limit-actions { display: flex; gap: 12px; justify-content: center; }
        .btn-primary {
            padding: 10px 24px; background: var(--jade); color: #fff; border: none;
            border-radius: 8px; font-size: 0.82rem; font-weight: 600; font-family: inherit;
            cursor: pointer; text-decoration: none;
        }
        .btn-secondary {
            padding: 10px 24px; background: #fff; color: var(--text-secondary); border: 1px solid var(--border);
            border-radius: 8px; font-size: 0.82rem; font-weight: 500; font-family: inherit;
            cursor: pointer; text-decoration: none;
        }
    </style>
    @endpush

    <div class="limit-card">
        <div class="limit-icon">
            <svg width="28" height="28" fill="none" stroke="#d97706" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
        </div>
        <div class="limit-title">Has alcanzado el límite de almacenes</div>
        <div class="limit-text">
            Tu plan <strong>{{ $planName }}</strong> permite un máximo de <strong>{{ $limit }}</strong> {{ $limit === 1 ? 'almacén' : 'almacenes' }}.
            Actualiza tu plan para agregar más almacenes.
        </div>
        <div class="limit-actions">
            <a href="{{ route('tenant.warehouses.index') }}" class="btn-secondary">Volver</a>
            <a href="#" class="btn-primary">Actualizar plan</a>
        </div>
    </div>
</x-tenant-layout>
