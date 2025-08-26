<?php

namespace Workdo\RestaurantMenu\Events;

use Illuminate\Queue\SerializesModels;

class UpdateDiningTable
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $request;
    public $diningTable;

    public function __construct($request,$diningTable)
    {
        $this->request = $request;
        $this->diningTable = $diningTable;
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
