<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\BeverageManagement\Events\CreateManufacturing;

class CreateManufacturingLis
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
    public function handle(CreateManufacturing $event)
    {
        if (module_is_active('ActivityLog')) {
            $manufacturing = $event->manufacturing;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Beverage';
            $activity['sub_module']     = 'Manufacturing';
            $activity['description']    = __('New Manufacturing Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $manufacturing->workspace;
            $activity['created_by']     = $manufacturing->created_by;
            $activity->save();
        }
    }
}
