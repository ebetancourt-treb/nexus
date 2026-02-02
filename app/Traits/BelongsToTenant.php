<?php
namespace App\Traits;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant()
    {
        // 1. AL CONSULTAR (READ):
        static::addGlobalScope('tenant', function (Builder $builder) {
            // Si hay usuario logueado
            if (Auth::check()) {
                // Si el usuario pertenece a una empresa, filtramos por su ID
                if (Auth::user()->tenant_id) {
                    $builder->where('tenant_id', Auth::user()->tenant_id);
                } 
                // Si es Super Admin (tenant_id null), NO le mostramos datos de los inquilinos
                // Esto evita que el Super Admin vea "basura" o datos mezclados por error.
                else {
                    $builder->whereNull('tenant_id'); 
                }
            }
        });

        // 2. AL CREAR (CREATE):
        static::creating(function ($model) {
            if (Auth::check() && Auth::user()->tenant_id) {
                $model->tenant_id = Auth::user()->tenant_id;
            }
        });
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}