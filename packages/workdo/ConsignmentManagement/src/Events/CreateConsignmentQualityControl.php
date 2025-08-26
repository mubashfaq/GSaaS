<?php

namespace Workdo\ConsignmentManagement\Events;

use Illuminate\Queue\SerializesModels;

class CreateConsignmentQualityControl
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $request;
    public $Consignmentquality;

    public function __construct($request ,$Consignmentquality)
    {
        $this->request = $request;
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
