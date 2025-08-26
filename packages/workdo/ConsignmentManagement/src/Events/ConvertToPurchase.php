<?php

namespace Workdo\ConsignmentManagement\Events;

use Illuminate\Queue\SerializesModels;

class ConvertToPurchase
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    Public $convertPurchase;
    public function __construct($convertPurchase)
    {
        $this->convertPurchase = $convertPurchase;
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
