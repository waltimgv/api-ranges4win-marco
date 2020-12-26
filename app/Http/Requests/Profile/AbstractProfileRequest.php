<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

abstract class AbstractProfileRequest extends FormRequest
{

    public function attributes()
    {
        return [
            'name' => 'Nome',
        ];
    }

}
