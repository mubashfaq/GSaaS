<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\VisitorManagement\Events\UpdateVisitorLog;

class UpdateVisitorLogLis
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
    public function handle(UpdateVisitorLog $event)
    {
        if (module_is_active('ActivityLog')) {
            $visitorLog = $event->visitorLog;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Visitors';
            $activity['sub_module']     = 'Visitor Log';
            $activity['description']    = __('Visitor Log Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $visitorLog->workspace;
            $activity['created_by']     = $visitorLog->created_by;
            $activity->save();
        }
    }
}
