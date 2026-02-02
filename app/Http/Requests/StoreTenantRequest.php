<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
class StoreTenantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'company_name'   => ['required', 'string', 'max:255', 'unique:tenants,name'],
            'admin_name'     => ['required', 'string', 'max:255'],
            'admin_email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }

    public function attributes(): array
    {
        return[
            'company_name' => 'nombre de la empresa',
            'company_domain' => 'dominio',
            'admin_name' => 'nombre del administrador',
            'admin_email' => 'correo electrónico',
            'password' => 'contraseña',
        ];
    }
}
