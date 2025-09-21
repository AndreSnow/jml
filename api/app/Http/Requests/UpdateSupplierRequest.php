<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Cnpj;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'  => 'sometimes|required|string|min:3',
            'cnpj'  => ['sometimes','required','string','size:14','unique:suppliers,cnpj,' . $this->route('supplier'), new Cnpj()],
            'email' => 'nullable|email',
        ];
    }
}
