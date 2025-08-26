<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Requests\Events\CreateRequests;

class CreateRequestsLis
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
    public function handle(CreateRequests $event)
    {
        if (module_is_active('ActivityLog')) {
            $CreateRequests = $event->CreateRequests;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Requests';
            $activity['sub_module']     = 'Requests';
            $activity['description']    =  __('New Request created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $CreateRequests['workspace'];
            $activity['created_by']     = $CreateRequests['created_by'];
            $activity->save();
        }
    }
}
