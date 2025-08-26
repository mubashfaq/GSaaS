<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\MachineRepairManagement\Events\CreateRepairRequest;

class CreateRepairRequestLis
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
    public function handle(CreateRepairRequest $event)
    {
        if (module_is_active('ActivityLog')) {
            $repair_request = $event->repair_request;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Machine Repair';
            $activity['sub_module']     = 'Repair Request';
            $activity['description']    = __('New Repair Request Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $repair_request->workspace;
            $activity['created_by']     = $repair_request->created_by;
            $activity->save();
        }
    }
}
