<?php

namespace Workdo\ConsignmentManagement\Events;

use Illuminate\Queue\SerializesModels;

class ConvertSaleOrderToInvoice
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    Public $convertInvoice ;
    public function __construct($convertInvoice)
    {
        $this->convertInvoice = $convertInvoice;
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
