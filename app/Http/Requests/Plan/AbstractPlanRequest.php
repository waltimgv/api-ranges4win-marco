<?php

namespace App\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

abstract class AbstractPlanRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->is_admin;
    }

    public function rules()
    {
        return [
            'number_days' => 'required|positive|integer',
            'description' => 'nullable|string|max:255',
            'price' => 'required|integer|positive',
            'discount' => 'required|integer|min:0|max:100',
        ];
    }

    public function attributes()
    {
        return [
            'number_days' => 'Número de Dias',
            'description' => 'Descrição',
            'price' => 'Preço',
            'discount' => 'Desconto',
        ];
    }

}
