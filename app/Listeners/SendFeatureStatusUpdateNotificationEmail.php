<?php

namespace Hunt\Listeners;

use Mail;
use Hunt\User;
use Hunt\Events\FeatureStatusUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Hunt\Mail\FeatureStatusUpdated as FeatureStatusUpdatedMailable;

class SendFeatureStatusUpdateNotificationEmail implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  FeatureStatusUpdated  $event
     * @return void
     */
    public function handle(FeatureStatusUpdated $event)
    {
        $users = User::all();

        foreach($users as $user) {
            Mail::to($user->email)
                ->queue(
                new FeatureStatusUpdatedMailable($user, $event->feature, $event->status)
            );
        }
    }
}
