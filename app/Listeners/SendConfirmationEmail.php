<?php

namespace Hunt\Listeners;

use Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Hunt\Mail\SendConfirmationEmail as SendConfirmationEmailMailable;

class SendConfirmationEmail implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        Mail::to($event->user->email)
            ->send(new SendConfirmationEmailMailable($event->user));
    }
}
