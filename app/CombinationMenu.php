<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CombinationMenu extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'is_free',
    ];

    protected $casts = [
        'is_free' => 'boolean',
    ];

    protected $appends = [
        'disabled',
    ];

    public function submenus()
    {
        return $this->hasMany(CombinationSubmenu::class, 'menu_id', 'id');
    }

    public function getDisabledAttribute()
    {
        return $this->is_free === false;
    }

}
