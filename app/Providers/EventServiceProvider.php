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
        'Illuminate\Auth\Events\Registered' => [
            'Hunt\Listeners\SendConfirmationEmail'
        ],

        'Hunt\Events\FeatureReleased' => [
            'Hunt\Listeners\SendFeatureReleasedEmail',
        ],

        'Hunt\Events\FeatureStatusUpdated' => [
            'Hunt\Listeners\SendFeatureStatusUpdateNotificationEmail',
        ],
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
