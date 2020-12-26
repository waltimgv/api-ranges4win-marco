<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{

    protected $fillable = [
        'number_days',
        'description',
        'price',
        'discount',
        'paypal_id',
        'currency'
    ];

    protected $appends = [
        'has_discount',
        'discount_price',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'plan_user');
    }

    public function getHasDiscountAttribute()
    {
        return $this->discount > 0;
    }

    public function getDiscountPriceAttribute()
    {
        return round($this->price - ($this->price * ($this->discount / 100)), 2);
    }

}
