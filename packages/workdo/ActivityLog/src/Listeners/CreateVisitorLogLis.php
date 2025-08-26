<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\VisitorManagement\Events\CreateVisitorLog;

class CreateVisitorLogLis
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
    public function handle(CreateVisitorLog $event)
    {
        if (module_is_active('ActivityLog')) {
            $visitorLog = $event->visitorLog;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Visitors';
            $activity['sub_module']     = 'Visitor Log';
            $activity['description']    = __('New Visitor Log Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $visitorLog->workspace;
            $activity['created_by']     = $visitorLog->created_by;
            $activity->save();
        }
    }
}
