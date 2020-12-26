<?php

namespace App\Http\Requests\Paypal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->is_admin || ($this->user['id'] === auth()->user()->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'transaction' => 'required',
            'transaction.id' => 'required',
            'user' => 'required|is_plan_expired',
            'user.id' => 'required|exists:users,id',
            'plan' => 'required',
            'plan.id' => 'required|exists:plans,id',
        ];
    }
}
