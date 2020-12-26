<?php

namespace App\Http\Requests\Combination;

use App\Enums\CombinationType;

class FindUserCombinationRequest extends AbstractPlanRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->check()) {
            if (auth()->user()->is_admin || ($this->get('type') === CombinationType::PRO)) {
                return true;
            }

            return $this->user->id === auth()->user()->id;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
