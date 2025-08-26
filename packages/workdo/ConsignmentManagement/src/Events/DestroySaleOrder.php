<?php

namespace Workdo\ConsignmentManagement\Events;

use Illuminate\Queue\SerializesModels;

class DestroySaleOrder
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $SaleOrder;

    public function __construct($SaleOrder)
    {
        $this->SaleOrder = $SaleOrder;
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
