<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\MachineRepairManagement\Events\CreateMachine;

class CreateMachineLis
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
    public function handle(CreateMachine $event)
    {
        if (module_is_active('ActivityLog')) {
            $machine = $event->machine;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Machine Repair';
            $activity['sub_module']     = 'Machine';
            $activity['description']    = __('New Machine Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $machine->workspace;
            $activity['created_by']     = $machine->created_by;
            $activity->save();
        }
    }
}
