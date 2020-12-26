<?php

namespace App\Http\Requests\Instruction;

use Illuminate\Foundation\Http\FormRequest;

class DestroyInstructionRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check() && (auth()->user()->is_admin || ($this->instruction->user_id === auth()->user()->id));
    }

    public function rules()
    {
        return [];
    }

}
