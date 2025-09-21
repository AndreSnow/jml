<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Cnpj;

class StoreSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => 'required|string|min:3',
            'cnpj'  => ['required', 'string', 'size:14', 'unique:suppliers,cnpj', new Cnpj()],
            'email' => 'nullable|email',
        ];
    }
}
