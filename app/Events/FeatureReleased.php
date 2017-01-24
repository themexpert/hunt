<?php

namespace Hunt\Events;

use Hunt\Feature;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

class FeatureReleased
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Instance of feature.
     *
     * @var Feature
     */
    public $feature;

    /**
     * Create a new event instance.
     *
     * @param Feature $feature
     */
    public function __construct(Feature $feature)
    {
        $this->feature = $feature;
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
