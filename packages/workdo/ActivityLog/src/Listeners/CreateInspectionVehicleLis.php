<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\VehicleInspectionManagement\Events\CreateInspectionVehicle;

class CreateInspectionVehicleLis
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
    public function handle(CreateInspectionVehicle $event)
    {
        if (module_is_active('ActivityLog')) {
            $inspectionVehicle = $event->inspectionVehicle;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Vehicle Inspection';
            $activity['sub_module']     = 'Vehicle';
            $activity['description']    = __('New Vehicle Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $inspectionVehicle->workspace;
            $activity['created_by']     = $inspectionVehicle->created_by;
            $activity->save();
        }
    }
}
