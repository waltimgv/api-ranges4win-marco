<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CombinationSubmenu extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'menu_id',
        'is_free',
    ];

    protected $casts = [
        'is_free' => 'boolean',
    ];

    protected $appends = [
        'disabled',
    ];

    public function menu()
    {
        return $this->belongsTo(CombinationMenu::class, 'menu_id', 'id');
    }

    public function links()
    {
        return $this->hasMany(CombinationLink::class, 'submenu_id', 'id');
    }

    public function getDisabledAttribute()
    {
        return $this->is_free === false;
    }

}
