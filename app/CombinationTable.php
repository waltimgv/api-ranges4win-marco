<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CombinationTable extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'columns',
    ];

    public function getColumnsAttribute()
    {
        return explode(',', $this->attributes['columns']);
    }

}
