<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\VehicleInspectionManagement\Events\CreateInspectionList;

class CreateInspectionListLis
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
    public function handle(CreateInspectionList $event)
    {
        if (module_is_active('ActivityLog')) {
            $inspectionList = $event->inspectionList;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Vehicle Inspection';
            $activity['sub_module']     = 'Inspection List';
            $activity['description']    = __('New Inspection Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $inspectionList->workspace;
            $activity['created_by']     = $inspectionList->created_by;
            $activity->save();
        }
    }
}
