<?php

namespace Workdo\ConsignmentManagement\Events;

use Illuminate\Queue\SerializesModels;

class DestroyConsignmentReturn
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $return;

    public function __construct($return)
    {
        $this->return = $return;
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
