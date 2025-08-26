<?php

namespace Workdo\Documents\Events;

use Illuminate\Queue\SerializesModels;

class DeleteDocumentsType
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $documentsType;

    public function __construct($documentsType)
    {
        $this->documentsType = $documentsType;
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
