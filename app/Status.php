<?php

namespace App;

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
    public static $AWAITING_FOR_FEEDBACK = "Awaiting For Feedback";

    /**
     * Status type for feature in progress.
     *
     * @var string
     */
    public static $IN_PROGRESS = "In Progress";

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
    public static $DECLINE = "Decline Feature";
}