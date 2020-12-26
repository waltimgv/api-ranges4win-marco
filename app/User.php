<?php

namespace App;

use App\Enums\PayPalPaymentStatus;
use App\Enums\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use SoftDeletes, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'picture',
        'provider_user_id',
        'provider',
        'email_verified_at',
        'role',
        'is_terms_use_accepted',
        'is_blocked',
    ];

    protected $hidden = [
        'provider',
        'provider_user_id',
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_terms_use_accepted' => 'boolean',
        'is_blocked' => 'boolean',
    ];

    protected $appends = [
        'is_admin',
        'is_plan_expired',
        'plan_days',
        'role_formatted',
        'last_plan',
    ];

    public function plans()
    {
        return $this->hasMany(PlanUser::class, 'user_id', 'id');
    }

    public function combinations()
    {
        return $this->hasMany(CombinationUser::class, 'user_id', 'id');
    }

    public function getIsPlanExpiredAttribute()
    {
        if ($this->is_admin === false) {
            return $this->plan_days < 0;
        }

        return false;
    }

    public function getRoleFormattedAttribute()
    {
        if ($this->role) {
            return Role::FORMATTED[$this->role];
        }

        return '';
    }

    public function getIsAdminAttribute()
    {
        return $this->role === Role::ADMIN;
    }

    public function getLastPlanAttribute()
    {
        return $this->plans()
            ->whereIn('transaction_status', [PayPalPaymentStatus::CANCELED, PayPalPaymentStatus::ACTIVE, PayPalPaymentStatus::GIFT])
            ->latest()
            ->first();
    }

    public function getPlanDaysAttribute()
    {
        if ($lastPlan = $this->last_plan) {
            return $this->last_plan->plan_days;
        }

        return -1;
    }

    public function setTermsUseAccepted($isAccepted)
    {
        if ($this->is_terms_use_accepted === $isAccepted) {
            return;
        }

        return $this->update(['is_terms_use_accepted' => $isAccepted]);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
