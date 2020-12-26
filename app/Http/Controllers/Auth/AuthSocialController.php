<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SocialAccountService;
use App\Traits\RespondWithTokenTrait;
use Laravel\Socialite\Facades\Socialite;

class AuthSocialController extends Controller
{
    use RespondWithTokenTrait;

    private $service;

    /**
     * Create a new AuthController instance.
     *
     * @param SocialAccountService $service
     * @return void
     */
    public function __construct(SocialAccountService $service)
    {
        $this->service = $service;
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param string $driver
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(string $driver)
    {
        $userResponse = Socialite::driver($driver)->stateless()->user();

        $user = $this->service->findOrCreateUser($userResponse, $driver);

        if (!$user->is_blocked) {
            $token = auth()->login($user);
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

}
