<?php

namespace Hunt;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'product_id', 'name', 'description', 'is_public'
    ];

    /**
     * Get all tags related to the feature request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get status related to the feature request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->hasOne(Status::class);
    }

    /**
     * Get vote related to the feature request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vote()
    {
        return $this->hasOne(Vote::class);
    }
}