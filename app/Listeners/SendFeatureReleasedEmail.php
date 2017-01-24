<?php

namespace Hunt\Listeners;

use Mail;
use Hunt\User;
use Hunt\Events\FeatureReleased;
use Illuminate\Contracts\Queue\ShouldQueue;
use Hunt\Mail\FeatureReleased as FeatureReleasedMailable;

class SendFeatureReleasedEmail implements ShouldQueue
{
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
