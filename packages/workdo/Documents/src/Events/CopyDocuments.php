<?php

namespace Workdo\Documents\Events;

use Illuminate\Queue\SerializesModels;

class CopyDocuments
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $request;
    public $documents;

    public function __construct($request, $documents)
    {
        $this->request = $request;
        $this->documents = $documents;
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
