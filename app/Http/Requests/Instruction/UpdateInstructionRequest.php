<?php

namespace App\Http\Requests\Instruction;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateInstructionRequest extends AbstractInstructionRequest
{

    public function authorize()
    {
        return auth()->check() && (auth()->user()->is_admin || ($this->instruction->user_id === auth()->user()->id));
    }

}
