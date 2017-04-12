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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['userVoted'];

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

    /**
     * Get product related to the feature.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get user related to the feature.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get priority related to the feature.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function priority()
    {
        return $this->hasOne(Priority::class);
    }

    /**
     * Get effort related to the feature.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function effort()
    {
        return $this->hasOne(Effort::class);
    }

    /**
     * User voted attribute.
     *
     * @return bool
     */
    public function getUserVotedAttribute()
    {
        $userGiveVote = auth()->user()->vote()->withPivot('vote_type')
            ->whereVoteId($this->id)->first();

        if(is_null($userGiveVote)) {
            return 0;
        }

        return ($userGiveVote->pivot->vote_type == 'up')
                ? 1
                : -1;
    }
}