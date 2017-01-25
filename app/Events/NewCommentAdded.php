<?php

namespace Hunt\Events;

use Hunt\Feature;
use Hunt\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

class NewCommentAdded
{
    use InteractsWithSockets, SerializesModels;

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
     * Create a new event instance.
     *
     * @param Feature $feature
     * @param Comment $comment
     */
    public function __construct(Feature $feature, Comment $comment)
    {
        $this->feature = $feature;

        $this->comment = $comment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
