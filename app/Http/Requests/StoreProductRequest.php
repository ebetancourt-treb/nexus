<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tenantId = auth()->user()->tenant_id;

        return [
            'category_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'sku' => [
                'required', 'string', 'max:50',
                Rule::unique('products')->where('tenant_id', $tenantId),
            ],
            'barcode' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:1000'],
            'unit_of_measure' => ['required', 'string', 'max:20'],
            'cost_price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'reorder_point' => ['nullable', 'integer', 'min:0'],
            'reorder_qty' => ['nullable', 'integer', 'min:0'],
            'track_lots' => ['boolean'],
            'track_serials' => ['boolean'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del producto es obligatorio.',
            'sku.required' => 'El SKU es obligatorio.',
            'sku.unique' => 'Ya existe un producto con ese SKU.',
            'cost_price.required' => 'El costo es obligatorio.',
            'cost_price.min' => 'El costo no puede ser negativo.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'track_lots' => $this->boolean('track_lots'),
            'track_serials' => $this->boolean('track_serials'),
            'is_active' => $this->boolean('is_active', true),
            'sale_price' => $this->sale_price ?: 0,
            'reorder_point' => $this->reorder_point ?: 0,
            'reorder_qty' => $this->reorder_qty ?: 0,
        ]);
    }
}
