<?php

namespace Hunt;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'feature_id', 'type', 'subject', 'message'
    ];

    /**
     * Status type for feature awaiting feedback.
     *
     * @var string
     */
    public static $AWAITING_FOR_FEEDBACK = "PENDING";

    /**
     * Status type for feature in progress.
     *
     * @var string
     */
    public static $IN_PROGRESS = "WIP";

    /**
     * Status type for feature released.
     *
     * @var string
     */
    public static $RELEASED = "RELEASED";

    /**
     * Status type for feature decline.
     *
     * @var string
     */
    public static $DECLINED = "DECLINED";

    /**
     * Get feature related to the status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}