<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\DrivingSchool\Events\CreateDrivingVehicle;

class CreateDrivingVehicleLis
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
    public function handle(CreateDrivingVehicle $event)
    {
        if (module_is_active('ActivityLog')) {
            $Vehicle = $event->Vehicle;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Driving School';
            $activity['sub_module']     = 'Vehicle';
            $activity['description']    = __('New Vehicle created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $Vehicle['workspace'];
            $activity['created_by']     = $Vehicle['created_by'];
            $activity->save();
        }
    }
}
