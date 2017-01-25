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
        $users = User::all();

        foreach($users as $user) {
            Mail::to($user->email)
                ->queue(
                new NewCommentAddedMailable($user, $event->feature, $event->comment)
            );
        }
    }
}
