<?php

namespace App\Http\Requests\Link;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractLinkRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    public function attributes()
    {
        return [
            'title' => 'Titulo',
            'is_free' => 'É gratuito',
            'submenu_id' => 'Submenu'
        ];
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'is_free' => 'required|boolean',
            'submenu_id' => 'required|numeric|exists:combination_submenus,id',
        ];
    }

}
