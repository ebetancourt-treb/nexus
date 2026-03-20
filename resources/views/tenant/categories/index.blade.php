<x-tenant-layout>
    <x-slot:title>Categorías</x-slot:title>
    <x-slot:header>Categorías</x-slot:header>

    @push('styles')
    <style>
        .page-actions { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
        .table-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { padding: 10px 16px; text-align: left; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-light); border-bottom: 1px solid var(--border); background: #fafafa; }
        .data-table td { padding: 12px 16px; font-size: 0.82rem; color: var(--text); border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
        .data-table tr:hover td { background: #fafffe; }

        .inline-form { display: flex; gap: 8px; align-items: center; }
        .inline-input { padding: 7px 12px; border: 1px solid var(--border); border-radius: 6px; font-size: 0.82rem; font-family: inherit; color: var(--text); flex: 1; }
        .inline-input:focus { outline: none; border-color: var(--jade); }
        .btn-small { padding: 7px 14px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; font-family: inherit; cursor: pointer; border: none; }
        .btn-save { background: var(--jade); color: #fff; }
        .btn-save:hover { background: var(--jade-dark); }
        .btn-table { padding: 5px 10px; border-radius: 6px; font-size: 0.72rem; font-weight: 500; font-family: inherit; cursor: pointer; border: 1px solid var(--border); background: #fff; color: var(--text-secondary); }
        .btn-table:hover { border-color: var(--jade); color: var(--jade); }
        .btn-table.danger:hover { border-color: #ef4444; color: #ef4444; }

        .new-cat-form { padding: 16px 20px; border-bottom: 1px solid var(--border); background: #fafafa; }
        .badge-count { font-size: 0.7rem; color: var(--text-light); background: #f3f4f6; padding: 2px 8px; border-radius: 50px; }

        .flash-success { padding: 12px 16px; background: var(--jade-50); border: 1px solid var(--jade-100); border-radius: 8px; margin-bottom: 20px; font-size: 0.8rem; font-weight: 500; color: var(--jade-dark); }
        .flash-error { padding: 12px 16px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; margin-bottom: 20px; font-size: 0.8rem; font-weight: 500; color: #991b1b; }
        .table-empty { padding: 48px 24px; text-align: center; font-size: 0.85rem; color: var(--text-light); }
    </style>
    @endpush

    @if(session('success')) <div class="flash-success">{{ session('success') }}</div> @endif
    @if($errors->any()) <div class="flash-error">{{ $errors->first() }}</div> @endif

    <div class="page-actions">
        <div>
            <h2 style="font-family: 'Special Gothic Expanded One', sans-serif; font-size: 1.1rem; color: #585858;">Categorías</h2>
            <p style="font-size: 0.78rem; color: var(--text-secondary); margin-top: 2px;">Organiza tus productos en categorías</p>
        </div>
    </div>

    <div class="table-card">
        <div class="new-cat-form">
            <form action="{{ route('tenant.categories.store') }}" method="POST" class="inline-form">
                @csrf
                <input type="text" name="name" class="inline-input" placeholder="Nombre de la nueva categoría..." required style="max-width: 400px;">
                <button type="submit" class="btn-small btn-save">Crear categoría</button>
            </form>
        </div>

        @if($categories->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Productos</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>
                                <form action="{{ route('tenant.categories.update', $category) }}" method="POST" class="inline-form">
                                    @csrf @method('PUT')
                                    <input type="text" name="name" class="inline-input" value="{{ $category->name }}" style="max-width: 300px; border-color: transparent; padding: 5px 8px;">
                                    <button type="submit" class="btn-table" style="opacity: 0.5;">Guardar</button>
                                </form>
                            </td>
                            <td><span class="badge-count">{{ $category->products_count }}</span></td>
                            <td style="text-align: right;">
                                <form action="{{ route('tenant.categories.destroy', $category) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar esta categoría?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-table danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($categories->hasPages())
                <div style="padding:12px 16px; border-top:1px solid var(--border);">{{ $categories->links() }}</div>
            @endif
        @else
            <div class="table-empty">Aún no tienes categorías. Crea la primera arriba.</div>
        @endif
    </div>
</x-tenant-layout>
