<?php

namespace Workdo\ConsignmentManagement\Events;

use Illuminate\Queue\SerializesModels;

class DestroyConsignmentItem
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    Public $request;
    Public $consignmentitem;

    public function __construct($request , $consignmentitem)
    {
        $this->request = $request;
        $this->consignmentitem = $consignmentitem;
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
