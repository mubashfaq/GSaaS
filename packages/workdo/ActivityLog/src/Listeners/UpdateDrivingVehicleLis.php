<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\DrivingSchool\Events\UpdateDrivingVehicle;

class UpdateDrivingVehicleLis
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
    public function handle(UpdateDrivingVehicle $event)
    {
        if (module_is_active('ActivityLog')) {
            $vehicle = $event->vehicle;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Driving School';
            $activity['sub_module']     = 'Vehicle';
            $activity['description']    = __('Vehicle updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $vehicle['workspace'];
            $activity['created_by']     = $vehicle['created_by'];
            $activity->save();
        }
    }
}
