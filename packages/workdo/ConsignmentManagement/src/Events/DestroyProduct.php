<?php

namespace Workdo\ConsignmentManagement\Events;

use Illuminate\Queue\SerializesModels;

class DestroyProduct
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $consignmentProduct;

    public function __construct($consignmentProduct)
    {

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
