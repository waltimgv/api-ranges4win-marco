<?php

namespace App\Http\Requests\Combination;

class CellsToCombinationRequest extends AbstractPlanRequest
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
            'cells.*.percent' => 'required|numeric|positive'
        ];
    }
}
