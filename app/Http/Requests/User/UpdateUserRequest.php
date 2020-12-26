<?php

namespace App\Http\Requests\User;

use App\Enums\Role;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends AbstractUserRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'role' => 'required|string|in:' . Role::toCollect()->join(','),
        ];
    }
}
