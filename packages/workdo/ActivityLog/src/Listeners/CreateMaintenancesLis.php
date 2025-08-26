<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Fleet\Entities\Vehicle;
use Workdo\Fleet\Events\CreateMaintenances;

class CreateMaintenancesLis
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
    public function handle(CreateMaintenances $event)
    {
        if (module_is_active('ActivityLog')) {
            $maintenances = $event->Maintenances;
            $vehicle = Vehicle::find($maintenances->vehicle_name);
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Fleet';
            $activity['sub_module']     = 'Maintenance';
            $activity['description']    = __('Maintenance Created of vehicle ') . $vehicle->name . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $maintenances->workspace;
            $activity['created_by']     = $maintenances->created_by;
            $activity->save();
        }
    }
}
