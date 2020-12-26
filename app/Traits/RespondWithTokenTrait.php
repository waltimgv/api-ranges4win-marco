<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait RespondWithTokenTrait
{

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 99999999,
            'user' => auth()->user(),
        ]);
    }

}
