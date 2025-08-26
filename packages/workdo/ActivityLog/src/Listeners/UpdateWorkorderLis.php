<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\CMMS\Events\UpdateWorkorder;

class UpdateWorkorderLis
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
    public function handle(UpdateWorkorder $event)
    {
        if (module_is_active('ActivityLog')) {
            $workorder = $event->request;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'CMMS';
            $activity['sub_module']     = 'Work Order';
            $activity['description']    = __('Work Order Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $workorder->workspace;
            $activity['created_by']     = $workorder->created_by;
            $activity->save();
        }
    }
}
