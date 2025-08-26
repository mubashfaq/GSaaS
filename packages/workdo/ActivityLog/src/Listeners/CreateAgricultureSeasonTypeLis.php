<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\AgricultureManagement\Events\CreateAgricultureSeasonType;

class CreateAgricultureSeasonTypeLis
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
    public function handle(CreateAgricultureSeasonType $event)
    {
        if (module_is_active('ActivityLog')) {
            $agricultureseasontype = $event->agricultureseasontype;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Agriculture';
            $activity['sub_module']     = 'Agriculture Season Type';
            $activity['description']    = __('New Agriculture Season Type Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $agricultureseasontype->workspace;
            $activity['created_by']     = $agricultureseasontype->created_by;
            $activity->save();
        }
    }
}
