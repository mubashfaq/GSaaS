<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\AgricultureManagement\Events\UpdateAgricultureCycles;

class UpdateAgricultureCyclesLis
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
    public function handle(UpdateAgricultureCycles $event)
    {
        if (module_is_active('ActivityLog')) {
            $agriculturecycles = $event->agriculturecycles;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Agriculture';
            $activity['sub_module']     = 'Agriculture Cycles';
            $activity['description']    = __('Agriculture Cycle Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $agriculturecycles->workspace;
            $activity['created_by']     = $agriculturecycles->created_by;
            $activity->save();
        }
    }
}
