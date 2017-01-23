<?php

namespace App\Listeners;

use Mail;
use App\User;
use App\Events\FeatureReleased;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\FeatureReleased as FeatureReleasedMailable;

class SendFeatureReleasedEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FeatureReleased  $event
     * @return void
     */
    public function handle(FeatureReleased $event)
    {
        $users = User::all();

        foreach($users as $user) {
            Mail::to($user->email)
                ->queue(
                new FeatureReleasedMailable($user, $event->feature)
            );
        }
    }
}
