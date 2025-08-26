<?php

namespace Workdo\ConsignmentManagement\Events;

use Illuminate\Queue\SerializesModels;

class DestroyConsignmentShipping
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $shipping;

    public function __construct($shipping)
    {
        $this->shipping = $shipping;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
