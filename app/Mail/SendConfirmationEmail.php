<?php

namespace Hunt\Mail;

use Hunt\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Instance of user model.
     *
     * @var \Hunt\User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $appName = config('app.name');

        return $this->from(env('FROM_EMAIL'), $appName)
                ->subject("[{$appName}] Confirm your email address")
                ->view('mail.send-confirmation-email');
    }
}
