<?php

namespace Workdo\VCard\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Workdo\VCard\Entities\Businessfield;
use App\Events\DefaultData;
use Illuminate\Support\Facades\Log;

class DataDefault
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(DefaultData $event)
    {
        $user_module = $event->user_module;
        if(!empty($user_module))
        {
            if (in_array("VCard", $user_module))
            {
                Businessfield::addBusinessField();
            }
        }
    }
}
