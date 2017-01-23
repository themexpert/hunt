<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Effort extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'feature_id', 'value'
    ];
}