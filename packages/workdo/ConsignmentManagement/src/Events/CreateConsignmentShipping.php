<?php

namespace Workdo\ConsignmentManagement\Events;

use Illuminate\Queue\SerializesModels;

class CreateConsignmentShipping
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $request;
    public $shipping;

    public function __construct($request ,$shipping)
    {
        $this->request = $request;
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
