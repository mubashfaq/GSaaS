<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Fleet\Events\CreateDriver;

class CreateDriverLis
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
    public function handle(CreateDriver $event)
    {
        if (module_is_active('ActivityLog')) {
            $driver = $event->driver;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Fleet';
            $activity['sub_module']     = 'Driver';
            $activity['description']    = __('New Driver Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $driver->workspace;
            $activity['created_by']     = $driver->created_by;
            $activity->save();
        }
    }
}
