<?php

namespace Workdo\ConsignmentManagement\Events;

use Illuminate\Queue\SerializesModels;

class DestroyPurchaseOrder
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $purchaseOrder;

    public function __construct($purchaseOrder)
    {

        $this->purchaseOrder = $purchaseOrder;
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
