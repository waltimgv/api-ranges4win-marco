<?php

namespace App\Services;

use App\Enums\Role;
use App\User;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialUserService
{

    /**
     * Find user by provider_user_id.
     *
     * @param string $providerUserId
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public function findWhereProviderUserId(string $providerUserId)
    {
        return User::query()->where('provider_user_id', $providerUserId)->first();
    }

    /**
     * Find user by email and update.
     *
     * @param string $email
     * @param ProviderUser $values
     * @param string $provider
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public function findOrCreateWhereEmail(string $email, ProviderUser $values, string $provider)
    {
        $user = User::query()
            ->where('email', $email)
            ->withTrashed()
            ->first();

        if ($user !== null) {
            if ($user->deleted_at)  {
                $user->restore();
            }

            $user->update([
                'picture' => ($user->picture === null) ? $values->picture ?? $values->avatar : $user->picture,
                'provider_user_id' => $values->id,
                'provider' => $provider,
                'email_verified_at' => Date::now(),
            ]);

            return $user;
        }

        return $this->register($values, $provider);
    }

    /**
     * Register a user.
     *
     * @param ProviderUser $values
     * @param string $provider
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function register(ProviderUser $values, string $provider)
    {
        return User::query()->create([
            'name' => $values->name,
            'email' => $values->email,
            'password' => Hash::make($values->id),
            'role' => Role::USER,
            'picture' => $values->picture ?? $values->avatar,
            'provider_user_id' => $values->id,
            'provider' => $provider,
            'email_verified_at' => Date::now(),
        ]);
    }
}
