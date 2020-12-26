<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractMenuRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check() && auth()->user()->is_admin;
    }


    public function attributes()
    {
        return [
            'title' => 'Titulo',
            'is_free' => 'É gratuito'
        ];
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'is_free' => 'required|boolean',
        ];
    }

}
