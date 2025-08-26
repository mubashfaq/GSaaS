<?php

namespace Workdo\FindGoogleLeads\Events;

use Illuminate\Queue\SerializesModels;

class DestroyGoogleLead
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $lead;

    public function __construct($lead)
    {
        $this->lead = $lead;
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
