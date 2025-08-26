<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Requests\Events\UpdateRequests;

class UpdateRequestsLis
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
    public function handle(UpdateRequests $event)
    {
        if (module_is_active('ActivityLog')) {
            $Requests = $event->Requests;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Requests';
            $activity['sub_module']     = 'Requests';
            $activity['description']    =  __('Request updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $Requests['workspace'];
            $activity['created_by']     = $Requests['created_by'];
            $activity->save();
        }
    }
}
