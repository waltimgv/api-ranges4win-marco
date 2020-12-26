<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CombinationLink extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'submenu_id',
        'is_free',
    ];

    protected $casts = [
        'is_free' => 'boolean',
    ];

    protected $appends = [
        'disabled',
    ];

    public function submenu()
    {
        return $this->belongsTo(CombinationSubmenu::class, 'submenu_id', 'id');
    }

    public function instructions()
    {
        return $this->hasMany(Instruction::class, 'link_id');
    }

    public function getDisabledAttribute()
    {
        return $this->is_free === false;
    }
}
