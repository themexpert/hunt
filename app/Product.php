<?php

namespace Hunt;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'description', 'logo'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['logo_url'];

    /**
     * The hidden fields.
     *
     * @var array
     */
    protected $hidden = ['logo'];

    /**
     * Get product logo url.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getLogoUrlAttribute()
    {
        return url("storage/logos/{$this->id}." . $this->logo);
    }

    /**
     * Get all suggests related to the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function suggests()
    {
        return $this->hasMany(Feature::class);
    }
}