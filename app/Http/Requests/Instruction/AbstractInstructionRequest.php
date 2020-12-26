<?php

namespace App\Http\Requests\Instruction;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractInstructionRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    public function attributes()
    {
        return [
            'description' => 'Descrição',
            'link_id' => 'Link'
        ];
    }

    public function rules()
    {
        return [
            'description' => 'required|string|max:4000',
            'link_id' => 'required|numeric|exists:combination_links,id',
        ];
    }

}
