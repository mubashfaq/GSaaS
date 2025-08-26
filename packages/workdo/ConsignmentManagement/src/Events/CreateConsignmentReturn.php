<?php

namespace Workdo\ConsignmentManagement\Events;

use Illuminate\Queue\SerializesModels;

class CreateConsignmentReturn
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $request;
    public $ConsignmentReturn;

    public function __construct($request ,$ConsignmentReturn)
    {
        $this->request = $request;
        $this->ConsignmentReturn = $ConsignmentReturn;
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
