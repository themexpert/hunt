<?php

namespace Hunt;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'feature_id', 'up', 'down'
    ];

    /**
     * Get feature related to the vote.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }

    /**
     * Get feature related to the vote.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function voters()
    {
        return $this->belongsToMany(User::class);
    }
}