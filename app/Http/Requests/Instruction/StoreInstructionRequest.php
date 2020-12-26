<?php

namespace App\Http\Requests\Instruction;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreInstructionRequest extends AbstractInstructionRequest
{
    public function authorize()
    {
        return auth()->check();
    }
}
