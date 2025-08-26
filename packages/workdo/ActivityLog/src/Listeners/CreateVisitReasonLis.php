<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\VisitorManagement\Events\CreateVisitReason;

class CreateVisitReasonLis
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
    public function handle(CreateVisitReason $event)
    {
        if (module_is_active('ActivityLog')) {
            $visitorReason = $event->visitorReason;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Visitors';
            $activity['sub_module']     = 'Visit Purpose';
            $activity['description']    = __('New Visit Purpose Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $visitorReason->workspace;
            $activity['created_by']     = $visitorReason->created_by;
            $activity->save();
        }
    }
}
