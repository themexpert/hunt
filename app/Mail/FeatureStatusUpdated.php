<?php

namespace Hunt\Mail;

use Hunt\User;
use Hunt\Feature;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeatureStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Instance of user.
     *
     * @var User
     */
    public $user;

    /**
     * Instance of feature.
     *
     * @var Feature
     */
    public $feature;

    /**
     * Feature status.
     *
     * @var array
     */
    public $status;

    /**
     * Create a new message instance.
     *
     * @param User    $user
     * @param Feature $feature
     * @param array   $status
     */
    public function __construct(User $user, Feature $feature, array $status)
    {
        $this->user = $user;

        $this->feature = $feature;

        $this->status = $status;
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
                    ->subject("[{$appName}] {$this->feature->name} status updated")
                    ->view('mail.feature-status-updated');
    }
}
