<?php

namespace Workdo\Documents\Events;

use Illuminate\Queue\SerializesModels;

class CreateDocumentsType
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $request;
    public $documentsType;

    public function __construct($request, $documentsType)
    {
        $this->request = $request;
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
