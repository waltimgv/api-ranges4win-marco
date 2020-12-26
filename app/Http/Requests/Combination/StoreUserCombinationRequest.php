<?php

namespace App\Http\Requests\Combination;

class StoreUserCombinationRequest extends AbstractPlanRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cells' => 'required|array',
            'cells.*.cell' => 'required|string',
            'cells.*.percent' => 'required|numeric|positive',
            'link_id' => 'required|exists:combination_links,id',
            'color' => ['required', 'max:7', 'string', "combination_same_color:link_id,$this->link_id," . $this->user->id, 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'name' => 'required|string|max:120',
        ];
    }
}
