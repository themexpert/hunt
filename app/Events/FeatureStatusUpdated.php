<?php

namespace Hunt\Events;

use Hunt\Feature;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

class FeatureStatusUpdated
{
    use InteractsWithSockets, SerializesModels;

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
     * Create a new event instance.
     *
     * @param Feature $feature
     * @param array   $status
     */
    public function __construct(Feature $feature, array $status)
    {
        $this->feature = $feature;

        $this->status = $status;
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
