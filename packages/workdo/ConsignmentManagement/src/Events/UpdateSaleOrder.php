<?php

namespace Workdo\ConsignmentManagement\Events;

use Illuminate\Queue\SerializesModels;

class UpdateSaleOrder
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $request;
    public $saleOrder;

    public function __construct($request ,$saleOrder)
    {
        $this->request = $request;
        $this->saleOrder = $saleOrder;
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
