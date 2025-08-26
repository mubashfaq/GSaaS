<?php

namespace Workdo\ConsignmentManagement\Events;

use Illuminate\Queue\SerializesModels;

class DestoryConsignmentCompliance
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $compliance;

    public function __construct($compliance)
    {
        $this->compliance = $compliance;
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
