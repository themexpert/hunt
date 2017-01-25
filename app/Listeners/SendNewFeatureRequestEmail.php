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
        $users = User::all();

        foreach($users as $user) {
            Mail::to($user->email)
                ->queue(
                new NewFeatureRequestedMailable($user, $event->feature)
            );
        }
    }
}
