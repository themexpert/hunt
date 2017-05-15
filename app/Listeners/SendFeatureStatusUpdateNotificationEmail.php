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
        $developers = config("developers");

        foreach($developers as $developer) {
            $user = User::whereEmail($developer)->first();

            if(is_null($user)) continue;

            Mail::to($user->email)
                ->queue(
                new FeatureStatusUpdatedMailable($user, $event->feature, $event->status)
            );
        }
    }
}
