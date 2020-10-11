<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nuwave\Lighthouse\Schema\Types\GraphQLSubscription;

class TestEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The subscription field that was requested.
     *
     * @var \Nuwave\Lighthouse\Schema\Types\GraphQLSubscription
     */
    public $subscription;

    /**
     * The name of the field.
     *
     * @var string
     */
    public $fieldName;

    /**
     * The root element to be passed when resolving the subscription.
     *
     * @var mixed User defined.
     */
    public $root;

    public function __construct(GraphQLSubscription $subscription, string $fieldName, $root)
    {
        $this->subscription = $subscription;
        $this->fieldName = $fieldName;
        $this->root = $root;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('test');
    }
}
