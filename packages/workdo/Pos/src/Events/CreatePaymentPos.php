<?php

namespace Workdo\Pos\Events;

use Illuminate\Queue\SerializesModels;

class CreatePaymentPos
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $request;
    public $pos;
    public $posPayment;
    public function __construct($pos,$posPayment,$request)
    {
        $this->request = $request;
        $this->pos = $pos;
        $this->posPayment = $posPayment;
        
        \Log::info('CreatePaymentPos dispatched', [
        'trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5)
    ]);
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
