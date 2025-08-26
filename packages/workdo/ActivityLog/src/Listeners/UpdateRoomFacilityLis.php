<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Holidayz\Events\UpdateRoomFacility;

class UpdateRoomFacilityLis
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
    public function handle(UpdateRoomFacility $event)
    {
        if (module_is_active('ActivityLog')) {
            $facility = $event->facility;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Hotel&Room';
            $activity['sub_module']     = 'Facilities';
            $activity['description']    = __('Room Facility Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $facility->workspace;
            $activity['created_by']     = $facility->created_by;
            $activity->save();
        }
    }
}
