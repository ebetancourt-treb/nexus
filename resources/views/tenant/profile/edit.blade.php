<x-tenant-layout>
    <x-slot:title>Mi perfil</x-slot:title>
    <x-slot:header>Mi perfil</x-slot:header>

    @push('styles')
    <style>
        .profile-grid { display: flex; flex-direction: column; gap: 20px; max-width: 720px; }

        .profile-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
        .profile-card-header { padding: 18px 24px; border-bottom: 1px solid var(--border); }
        .profile-card-title { font-size: 0.92rem; font-weight: 600; color: var(--text); }
        .profile-card-desc { font-size: 0.75rem; color: var(--text-secondary); margin-top: 2px; }
        .profile-card-body { padding: 20px 24px; }
        .profile-card-footer { padding: 14px 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 12px; background: #fafafa; }

        .p-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .p-form-group { display: flex; flex-direction: column; gap: 6px; }
        .p-form-group.full { grid-column: 1 / -1; }
        .p-label { font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; color: var(--text-secondary); }
        .p-input {
            padding: 9px 12px; border: 1px solid var(--border); border-radius: 8px;
            font-size: 0.85rem; font-family: inherit; color: var(--text); background: #fff;
        }
        .p-input:focus { outline: none; border-color: var(--jade); box-shadow: 0 0 0 3px rgba(5,150,105,0.08); }
        .p-input:disabled { background: #f9fafb; color: var(--text-light); }
        .p-error { font-size: 0.72rem; color: #dc2626; }

        .btn-save { padding: 8px 20px; background: var(--jade); color: #fff; border: none; border-radius: 8px; font-size: 0.78rem; font-weight: 600; font-family: inherit; cursor: pointer; }
        .btn-save:hover { background: var(--jade-dark); }
        .btn-danger-outline { padding: 8px 20px; background: #fff; color: #dc2626; border: 1px solid #fecaca; border-radius: 8px; font-size: 0.78rem; font-weight: 600; font-family: inherit; cursor: pointer; }
        .btn-danger-outline:hover { background: #fef2f2; border-color: #dc2626; }

        .plan-info { display: flex; align-items: center; gap: 16px; padding: 16px 0; }
        .plan-badge { padding: 6px 16px; background: var(--jade-50); color: var(--jade); border-radius: 8px; font-size: 0.82rem; font-weight: 700; }
        .plan-details { font-size: 0.82rem; color: var(--text-secondary); }
        .plan-price { font-size: 1.1rem; font-weight: 700; color: var(--text); }

        .info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f3f4f6; font-size: 0.82rem; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: var(--text-secondary); }
        .info-value { font-weight: 500; color: var(--text); }

        .badge { display: inline-flex; padding: 2px 10px; border-radius: 50px; font-size: 0.65rem; font-weight: 600; }
        .badge-green { background: #dcfce7; color: #16a34a; }
        .badge-amber { background: #fef3c7; color: #d97706; }

        .flash-success { padding: 12px 16px; background: var(--jade-50); border: 1px solid var(--jade-100); border-radius: 8px; margin-bottom: 20px; font-size: 0.8rem; font-weight: 500; color: var(--jade-dark); }

        .delete-section { background: #fff; border: 1px solid #fecaca; border-radius: 10px; padding: 20px 24px; }
        .delete-title { font-size: 0.92rem; font-weight: 600; color: #991b1b; margin-bottom: 4px; }
        .delete-desc { font-size: 0.78rem; color: var(--text-secondary); margin-bottom: 16px; line-height: 1.5; }

        @media (max-width: 640px) { .p-form-grid { grid-template-columns: 1fr; } }
    </style>
    @endpush

    @if(session('success'))
        <div class="flash-success">{{ session('success') }}</div>
    @endif

    <div style="margin-bottom: 24px;">
        <h2 style="font-family: 'Special Gothic Expanded One', sans-serif; font-size: 1.1rem; color: #585858;">Mi perfil</h2>
        <p style="font-size: 0.78rem; color: var(--text-secondary); margin-top: 2px;">Administra tu información personal y la de tu empresa.</p>
    </div>

    <div class="profile-grid">

        {{-- Información personal --}}
        <div class="profile-card">
            <div class="profile-card-header">
                <div class="profile-card-title">Información personal</div>
                <div class="profile-card-desc">Tu nombre y correo electrónico de acceso.</div>
            </div>
            <form action="{{ route('tenant.profile.update') }}" method="POST">
                @csrf @method('PATCH')
                <div class="profile-card-body">
                    <div class="p-form-grid">
                        <div class="p-form-group">
                            <label class="p-label" for="name">Nombre</label>
                            <input type="text" name="name" id="name" class="p-input" value="{{ old('name', $user->name) }}" required>
                            @error('name') <span class="p-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="p-form-group">
                            <label class="p-label" for="email">Correo electrónico</label>
                            <input type="email" name="email" id="email" class="p-input" value="{{ old('email', $user->email) }}" required>
                            @error('email') <span class="p-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="profile-card-footer">
                    <button type="submit" class="btn-save">Guardar cambios</button>
                </div>
            </form>
        </div>

        {{-- Cambiar contraseña --}}
        <div class="profile-card">
            <div class="profile-card-header">
                <div class="profile-card-title">Contraseña</div>
                <div class="profile-card-desc">Usa una contraseña segura de al menos 8 caracteres.</div>
            </div>
            <form action="{{ route('tenant.profile.password') }}" method="POST">
                @csrf @method('PUT')
                <div class="profile-card-body">
                    <div class="p-form-grid">
                        <div class="p-form-group full">
                            <label class="p-label" for="current_password">Contraseña actual</label>
                            <input type="password" name="current_password" id="current_password" class="p-input" required>
                            @error('current_password') <span class="p-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="p-form-group">
                            <label class="p-label" for="password">Nueva contraseña</label>
                            <input type="password" name="password" id="password" class="p-input" required>
                            @error('password') <span class="p-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="p-form-group">
                            <label class="p-label" for="password_confirmation">Confirmar contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="p-input" required>
                        </div>
                    </div>
                </div>
                <div class="profile-card-footer">
                    <button type="submit" class="btn-save">Actualizar contraseña</button>
                </div>
            </form>
        </div>

        {{-- Información de la empresa --}}
        <div class="profile-card">
            <div class="profile-card-header">
                <div class="profile-card-title">Empresa</div>
                <div class="profile-card-desc">Datos de tu empresa u organización.</div>
            </div>
            <form action="{{ route('tenant.profile.company') }}" method="POST">
                @csrf @method('PUT')
                <div class="profile-card-body">
                    <div class="p-form-grid">
                        <div class="p-form-group">
                            <label class="p-label" for="company_name">Nombre de la empresa</label>
                            <input type="text" name="company_name" id="company_name" class="p-input" value="{{ old('company_name', $tenant?->name) }}" required>
                            @error('company_name') <span class="p-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="p-form-group">
                            <label class="p-label" for="rfc">RFC</label>
                            <input type="text" name="rfc" id="rfc" class="p-input" value="{{ old('rfc', $tenant?->rfc) }}" placeholder="Opcional" maxlength="13" style="text-transform: uppercase;">
                        </div>
                        <div class="p-form-group">
                            <label class="p-label" for="phone">Teléfono</label>
                            <input type="text" name="phone" id="phone" class="p-input" value="{{ old('phone', $tenant?->phone) }}" placeholder="Opcional">
                        </div>
                    </div>
                </div>
                <div class="profile-card-footer">
                    <button type="submit" class="btn-save">Guardar empresa</button>
                </div>
            </form>
        </div>

        {{-- Plan actual --}}
        <div class="profile-card">
            <div class="profile-card-header">
                <div class="profile-card-title">Plan y suscripción</div>
            </div>
            <div class="profile-card-body">
                <div class="plan-info">
                    <span class="plan-badge">{{ $plan?->name ?? 'Sin plan' }}</span>
                    <div>
                        <div class="plan-price">${{ number_format($plan?->price_monthly ?? 0, 0) }} <span style="font-size:0.78rem; font-weight:400; color:var(--text-secondary);">MXN/mes</span></div>
                    </div>
                </div>

                <div class="info-row"><span class="info-label">Estado</span>
                    <span>
                        @if($subscription?->status === 'trialing')
                            <span class="badge badge-amber">Prueba gratuita</span>
                        @elseif($subscription?->status === 'active')
                            <span class="badge badge-green">Activo</span>
                        @else
                            <span>{{ $subscription?->status ?? '—' }}</span>
                        @endif
                    </span>
                </div>
                @if($subscription?->trial_ends_at)
                    <div class="info-row"><span class="info-label">Trial termina</span><span class="info-value">{{ $subscription->trial_ends_at->format('d/m/Y') }}</span></div>
                @endif
                <div class="info-row"><span class="info-label">Almacenes</span><span class="info-value">{{ $plan?->max_warehouses === -1 ? 'Ilimitados' : $plan?->max_warehouses }}</span></div>
                <div class="info-row"><span class="info-label">Productos</span><span class="info-value">{{ $plan?->max_skus === -1 ? 'Ilimitados' : number_format($plan?->max_skus ?? 0) }}</span></div>
                <div class="info-row"><span class="info-label">Usuarios</span><span class="info-value">{{ $plan?->max_users === -1 ? 'Ilimitados' : $plan?->max_users }}</span></div>

                <div style="margin-top: 16px;">
                    <a href="https://wa.me/528711234567?text=Hola%2C%20quiero%20información%20sobre%20los%20planes%20de%20BlumOps" target="_blank" class="btn-save" style="text-decoration:none; display:inline-block;">Cambiar plan</a>
                </div>
            </div>
        </div>

        {{-- Eliminar cuenta --}}
        <div class="delete-section">
            <div class="delete-title">Eliminar cuenta</div>
            <div class="delete-desc">Al eliminar tu cuenta, todos tus datos serán eliminados permanentemente. Esta acción no se puede deshacer.</div>
            <form action="{{ route('tenant.profile.destroy') }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar tu cuenta? Esta acción es permanente y no se puede deshacer.')">
                @csrf @method('DELETE')
                <div class="p-form-grid" style="max-width: 300px; margin-bottom: 12px;">
                    <div class="p-form-group full">
                        <label class="p-label" for="delete_password">Escribe tu contraseña para confirmar</label>
                        <input type="password" name="password" id="delete_password" class="p-input" required placeholder="Tu contraseña actual">
                        @error('password', 'userDeletion') <span class="p-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <button type="submit" class="btn-danger-outline">Eliminar mi cuenta</button>
            </form>
        </div>

    </div>
</x-tenant-layout>
