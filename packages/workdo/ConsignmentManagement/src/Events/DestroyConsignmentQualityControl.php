<?php

namespace Workdo\ConsignmentManagement\Events;

use Illuminate\Queue\SerializesModels;

class DestroyConsignmentQualityControl
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $Consignmentquality;

    public function __construct($Consignmentquality)
    {
        $this->Consignmentquality = $Consignmentquality;
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
