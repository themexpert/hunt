<?php

namespace Hunt\Listeners;

use Mail;
use Hunt\User;
use Hunt\Events\NewCommentAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Hunt\Mail\NewCommentAdded as NewCommentAddedMailable;

class SendNewCommentAddedEmail implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  NewCommentAdded  $event
     * @return void
     */
    public function handle(NewCommentAdded $event)
    {
        $user = User::whereFeatureId($event->feature->id)->first();

        Mail::to($user->email)
            ->queue(
                new NewCommentAddedMailable($user, $event->feature, $event->comment)
            );
    }
}
