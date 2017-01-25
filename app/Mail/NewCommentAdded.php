<?php

namespace Hunt\Mail;

use Hunt\User;
use Hunt\Feature;
use Hunt\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCommentAdded extends Mailable
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
     * Instance of comment.
     *
     * @var Comment
     */
    public $comment;

    /**
     * Create a new message instance.
     *
     * @param User    $user
     * @param Feature $feature
     * @param Comment $comment
     */
    public function __construct(User $user, Feature $feature, Comment $comment)
    {
        $this->user = $user;

        $this->feature = $feature;

        $this->comment = $comment;
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
                    ->subject("[{$appName}] New comments in {$this->feature->name}")
                    ->view('mail.new-comment-added');
    }
}
