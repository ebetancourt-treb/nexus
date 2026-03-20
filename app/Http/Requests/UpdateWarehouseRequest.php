<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWarehouseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tenantId = auth()->user()->tenant_id;
        $warehouseId = $this->route('warehouse')->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => [
                'required', 'string', 'max:20',
                Rule::unique('warehouses')->where('tenant_id', $tenantId)->ignore($warehouseId),
            ],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'zip_code' => ['nullable', 'string', 'max:10'],
            'rotation_strategy' => ['required', 'in:fifo,fefo,manual'],
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del almacén es obligatorio.',
            'code.required' => 'El código del almacén es obligatorio.',
            'code.unique' => 'Ya existe un almacén con ese código.',
            'rotation_strategy.in' => 'La estrategia de rotación debe ser FIFO, FEFO o Manual.',
        ];
    }
}
