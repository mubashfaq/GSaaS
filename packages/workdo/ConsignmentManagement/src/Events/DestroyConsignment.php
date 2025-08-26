<?php

namespace Workdo\ConsignmentManagement\Events;

use Illuminate\Queue\SerializesModels;

class DestroyConsignment
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $consignment;

    public function __construct($consignment)
    {
        $this->consignment = $consignment;
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
