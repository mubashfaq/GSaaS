<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Holidayz\Events\UpdateHotelService;

class UpdateHotelServiceLis
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
    public function handle(UpdateHotelService $event)
    {
        if (module_is_active('ActivityLog')) {
            $service = $event->service;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Hotel&Room';
            $activity['sub_module']     = 'Amenities';
            $activity['description']    = __('Service Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $service->workspace;
            $activity['created_by']     = $service->created_by;
            $activity->save();
        }
    }
}
