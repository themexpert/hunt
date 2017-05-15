<?php

namespace Hunt\Listeners;

use Mail;
use Hunt\User;
use Hunt\Events\NewFeatureRequested;
use Illuminate\Contracts\Queue\ShouldQueue;
use Hunt\Mail\NewFeatureRequested as NewFeatureRequestedMailable;

class SendNewFeatureRequestEmail implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  NewFeatureRequested  $event
     * @return void
     */
    public function handle(NewFeatureRequested $event)
    {
        $developers = config("developers");

        foreach($developers as $developer) {
            $user = User::whereEmail($developer)->first();

            if(is_null($user)) continue;

            Mail::to($user->email)
                ->queue(
                new NewFeatureRequestedMailable($user, $event->feature)
            );
        }
    }
}
