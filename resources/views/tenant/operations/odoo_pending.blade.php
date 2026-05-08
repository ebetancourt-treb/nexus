<x-tenant-layout>
    <x-slot:title>Validación de Movimientos</x-slot:title>
    <x-slot:header>Operaciones Pendientes</x-slot:header>

    @push('styles')
    <style>
        .page-actions { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
        .btn-primary { display: inline-flex; align-items: center; gap: 8px; padding: 7px 16px; background: var(--jade); color: #fff; border: none; border-radius: 6px; font-size: 0.75rem; font-weight: 600; font-family: inherit; cursor: pointer; transition: background 0.2s; }
        .btn-primary:hover { background: var(--jade-dark); }
        
        .flash-success { padding: 12px 16px; background: var(--jade-50); border: 1px solid var(--jade-100); border-radius: 8px; margin-bottom: 20px; font-size: 0.8rem; font-weight: 500; color: var(--jade-dark); }
        .flash-error { padding: 12px 16px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; margin-bottom: 20px; font-size: 0.8rem; font-weight: 500; color: #991b1b; }

        .table-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { padding: 12px 16px; text-align: left; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-light); border-bottom: 1px solid var(--border); background: #fafafa; }
        .data-table td { padding: 14px 16px; font-size: 0.82rem; color: var(--text); border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
        
        .badge { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 50px; font-size: 0.7rem; font-weight: 600; }
        .badge-draft { background: #f3f4f6; color: #4b5563; }
        .badge-confirmed { background: #dbeafe; color: #1d4ed8; }
        .badge-assigned { background: #fef3c7; color: #b45309; }

        .form-control-small { padding: 6px 10px; border: 1px solid var(--border); border-radius: 6px; font-size: 0.8rem; width: 180px; }
        .form-control-small:focus { outline: none; border-color: var(--jade); box-shadow: 0 0 0 3px rgba(5,150,105,0.08); }
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
            <h2 style="font-family: 'Special Gothic Expanded One', sans-serif; font-size: 1.1rem; color: #585858;">Pendientes de Validación</h2>
            <p style="font-size: 0.78rem; color: var(--text-secondary); margin-top: 2px;">Lectura en tiempo real de recepciones y entregas del ERP</p>
        </div>
        <a href="{{ route('tenant.operations.odoo.flow') }}" class="btn-primary" style="background: #64748b;">
            Volver a Nueva Operación
        </a>
    </div>

    <div class="table-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Referencia Odoo</th>
                    <th>Documento Origen</th>
                    <th>Fecha Programada</th>
                    <th>Estado ERP</th>
                    <th style="text-align: right;">Acción (Control Local)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pickings as $picking)
                    <tr>
                        <td style="font-weight: 600;">{{ $picking['name'] }}</td>
                        <td style="color: var(--text-secondary);">{{ $picking['origin'] ?: 'Sin origen' }}</td>
                        <td>{{ date('d M, Y H:i', strtotime($picking['scheduled_date'])) }}</td>
                        <td>
                            @if($picking['state'] === 'draft')
                                <span class="badge badge-draft">Borrador</span>
                            @elseif($picking['state'] === 'confirmed')
                                <span class="badge badge-confirmed">En Espera</span>
                            @elseif($picking['state'] === 'assigned')
                                <span class="badge badge-assigned">Preparado</span>
                            @else
                                <span class="badge badge-draft">{{ ucfirst($picking['state']) }}</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <form action="{{ route('tenant.operations.odoo.validate') }}" method="POST" style="display: flex; gap: 8px; justify-content: flex-end; align-items: center; margin: 0;">
                                @csrf
                                <input type="hidden" name="picking_id" value="{{ $picking['id'] }}">
                                
                                <input type="text" name="ubicacion_piso" required class="form-control-small" placeholder="Ubicación de piso final" title="Confirma la ubicación de piso para validar">
                                
                                <button type="submit" class="btn-primary" onclick="return confirm('¿Confirmar mercancía en piso y validar en Odoo?')">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    Validar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-light);">
                            No hay movimientos pendientes de validar en el ERP en este momento.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-tenant-layout>