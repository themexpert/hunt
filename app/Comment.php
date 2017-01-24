<?php

namespace Hunt;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'feature_id', 'message'
    ];

    /**
     * Get comment created at.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

    /**
     * Get comment updated at.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }

    /**
     * Get user related to the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}