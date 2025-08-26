<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\AgricultureManagement\Events\CreateAgricultureSeason;

class CreateAgricultureSeasonLis
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
    public function handle(CreateAgricultureSeason $event)
    {
        if (module_is_active('ActivityLog')) {
            $agricultureseason = $event->agricultureseason;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Agriculture';
            $activity['sub_module']     = 'Agriculture Season';
            $activity['description']    = __('New Agriculture Season Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $agricultureseason->workspace;
            $activity['created_by']     = $agricultureseason->created_by;
            $activity->save();
        }
    }
}
