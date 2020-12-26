<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractUserRequest extends FormRequest
{

    public function attributes()
    {
        return [
            'role' => 'Tipo de Usuário',
            'plan' => 'Plano',
        ];
    }

}
