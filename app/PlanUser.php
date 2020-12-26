<?php

namespace App;

use App\Enums\PayPalPaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Carbon\Carbon;

class PlanUser extends Model
{

    protected $table = 'plan_user';

    protected $fillable = [
        'user_id',
        'plan_id',
        'transaction_id',
        'transaction_status',
        'transaction_payer',
        'paid_at',
        'price_paid',
        'expire_at',
    ];

    protected $hidden = [
        'transaction_id',
        'transaction_status',
        'transaction_payer',
        'user_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'expire_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    protected $appends = [
        'plan_days',
        'is_canceled',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'transaction_id';
    }

    public function getPlanDaysAttribute()
    {
        if (Carbon::parse($this->expire_at)->isPast()) {
            return -1;
        }

        return Date::now()->diffInDays($this->expire_at) + 1;
    }

    public function getIsCanceledAttribute()
    {
        return $this->transaction_status === PayPalPaymentStatus::CANCELED;
    }

    public function getIsActivatedAttribute()
    {
        return $this->transaction_status === PayPalPaymentStatus::ACTIVE;
    }

    public static function whereTransactionId($transactionId)
    {
        return self::query()->where('transaction_id', $transactionId);
    }

    public function setTransactionCanceled()
    {
        $this->setTransactionStatus(PayPalPaymentStatus::CANCELED);
    }

    public function setTransactionActivated()
    {
        $this->setTransactionStatus(PayPalPaymentStatus::ACTIVE);
    }

    public function setTransactionExpired()
    {
        $this->setTransactionStatus(PayPalPaymentStatus::EXPIRED);
    }

    public function setTransactionSuspended()
    {
        $this->setTransactionStatus(PayPalPaymentStatus::SUSPENDED);
    }

    public function setTransactionPaymentFailed()
    {
        $this->setTransactionStatus(PayPalPaymentStatus::FAILED);
    }

    public function setTransactionRenewed()
    {
        return $this->update([
            'expire_at' => PlanUser::calculeExpireTime($this->plan->number_days),
            'paid_at' => Date::now(),
            'transaction_status' => PayPalPaymentStatus::ACTIVE
        ]);
    }

    private function setTransactionStatus(string $status)
    {
        return $this->update(['transaction_status' => $status]);
    }

    public static function calculeExpireTime($days)
    {
        return Date::now()->addDays($days);
    }

    public static function getBySubscriptionId($subscription)
    {
        return self::query()->where('transaction_id', $subscription)->firstOrFail();
    }

}
