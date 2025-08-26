<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\ParkingManagement\Events\CreateParking;

class CreateParkingLis
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
    public function handle(CreateParking $event)
    {
        if (module_is_active('ActivityLog')) {
            $parking = $event->parking;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Parking';
            $activity['sub_module']     = 'Parking';
            $activity['description']    = __('New Parking Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $parking->workspace;
            $activity['created_by']     = $parking->created_by;
            $activity->save();
        }
    }
}
