<?php

namespace App\Http\Requests\Submenu;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractSubmenuRequest extends FormRequest
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
            'menu_id' => 'Menu'
        ];
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'is_free' => 'required|boolean',
            'menu_id' => 'required|numeric|exists:combination_menus,id',
        ];
    }

}
