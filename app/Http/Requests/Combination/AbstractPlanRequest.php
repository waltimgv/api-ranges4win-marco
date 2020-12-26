<?php

namespace App\Http\Requests\Combination;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

abstract class AbstractPlanRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->is_admin || ($this->user->id === auth()->user()->id);
    }

    public function attributes()
    {
        return [
            'cells' => 'Célula',
            'cells.*.row' => 'Linha',
            'cells.*.column' => 'Coluna',
            'color' => 'Cor',
            'link' => 'Link',
            'name' => 'Nome',
            'percent' => 'Porcentagem',
        ];
    }

}
