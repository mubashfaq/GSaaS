<?php

namespace Workdo\ConsignmentManagement\Events;

use Illuminate\Queue\SerializesModels;

class UpdateConsignment
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $request;
    public $consignment;

    public function __construct($request ,$consignment)
    {
        $this->request = $request;
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
