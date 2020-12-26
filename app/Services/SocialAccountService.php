<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Date;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{

    private $userService;

    /**
     * Social Account Service.
     *
     * @param SocialUserService $userService
     */
    public function __construct(SocialUserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Return a callback method from google api.
     *
     * @param ProviderUser $providerUser
     * @param string $provider
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function findOrCreateUser(ProviderUser $providerUser, string $provider)
    {
        $user = $this->userService->findWhereProviderUserId($providerUser->id);
        if ($user !== null) {
            return $user;
        }

        return $this->userService->findOrCreateWhereEmail($providerUser->email, $providerUser, $provider);
    }

}
