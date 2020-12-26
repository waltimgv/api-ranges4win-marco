<?php

namespace App\Http\Requests\Combination;

class UpdateUserCombinationRequest extends AbstractPlanRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'color' => [
                'required',
                'max:7',
                'string',
                'combination_same_color:link_id,' . $this->combinationUser->link_id . "," . $this->user->id . "," . $this->combinationUser->id,
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'
            ],
            'name' => 'required|string|max:120',
        ];
    }
}
