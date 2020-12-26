<?php

namespace App\Providers;

use App\CombinationUser;
use App\Services\PayPalService;
use App\User;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::defaultStringLength(191);

        $this->initValidationExtended();
    }

    public function initValidationExtended()
    {
        Validator::extend('positive', function ($attribute, $value, $parameters, $validator) {
            return $value >= 0;
        }, 'Número informado deve ser positivo');

        Validator::extend('combination_same_color', function ($attribute, $value, $parameters, $validator) {
            $query = CombinationUser::query()
                ->where($parameters[0], $parameters[1])
                ->where('user_id', $parameters[2])
                ->where('color', $value);

            if (isset($parameters[3])) {
                $query->where('id', '<>', $parameters[3]);
            }

            return !$query->exists();
        }, 'Selecione outra cor para o grupo');

        Validator::extend('is_plan_expired', function ($attribute, $value, $parameters, $validator) {
            if ($user = User::query()->find($value['id'])) {
                return $user->is_plan_expired || $user->last_plan->is_canceled;
            }

            return false;
        }, 'O plano do usuário ainda é válido, tente novamente quando ele expirar.');
    }

}
