<?php

namespace Workdo\ConsignmentManagement\Events;

use Illuminate\Queue\SerializesModels;

class UpdateProduct
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $request;
    public $consignmentProduct;

    public function __construct($request ,$consignmentProduct)
    {
        $this->request = $request;
        $this->consignmentProduct = $consignmentProduct;
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
