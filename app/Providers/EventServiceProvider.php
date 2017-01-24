<?php

namespace Hunt\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Hunt\Events\FeatureReleased' => [
            'Hunt\Listeners\SendFeatureReleasedEmail',
        ],

        'Illuminate\Auth\Events\Registered' => [
            'Hunt\Listeners\SendConfirmationEmail'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
