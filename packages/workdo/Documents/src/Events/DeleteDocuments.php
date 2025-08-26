<?php

namespace Workdo\Documents\Events;

use Illuminate\Queue\SerializesModels;

class DeleteDocuments
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $documents;

    public function __construct($documents)
    {
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
