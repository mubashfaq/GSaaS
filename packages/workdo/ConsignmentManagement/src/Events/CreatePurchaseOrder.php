<?php

namespace Workdo\ConsignmentManagement\Events;

use Illuminate\Queue\SerializesModels;

class CreatePurchaseOrder
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $request;
    public $purchaseOrder;

    public function __construct($request ,$purchaseOrder)
    {
        $this->request = $request;
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
