<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\AgricultureManagement\Events\CreateAgriculturefleet;

class CreateAgriculturefleetLis
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
    public function handle(CreateAgriculturefleet $event)
    {
        if (module_is_active('ActivityLog')) {
            $agriculture_fleet = $event->agriculture_fleet;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Agriculture';
            $activity['sub_module']     = 'Agriculture Fleet';
            $activity['description']    = __('New Agriculture Fleet Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $agriculture_fleet->workspace;
            $activity['created_by']     = $agriculture_fleet->created_by;
            $activity->save();
        }
    }
}
