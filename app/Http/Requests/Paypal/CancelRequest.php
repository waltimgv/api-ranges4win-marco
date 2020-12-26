<?php

namespace App\Http\Requests\Paypal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CancelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($lastPlan = auth()->user()->last_plan) {
            return $lastPlan->is_activated;
        }

        return auth()->user()->is_plan_expired === false;
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
