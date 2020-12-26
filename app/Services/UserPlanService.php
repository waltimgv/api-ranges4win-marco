<?php

namespace App\Services;

use App\Enums\PayPalPaymentStatus;
use App\Plan;
use App\PlanUser;
use App\User;
use Illuminate\Support\Facades\Date;

class UserPlanService
{

    /**
     * Add plan as a gift.
     *
     * @param Plan $plan
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function addPlanAsGift(Plan $plan, User $user)
    {
        return PlanUser::query()->create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'transaction_status' => PayPalPaymentStatus::GIFT,
            'transaction_id' => uniqid(PayPalPaymentStatus::GIFT),
            'price_paid' => 0,
            'paid_at' => Date::now(),
            'expire_at' => PlanUser::calculeExpireTime($plan->number_days),
        ]);
    }

}