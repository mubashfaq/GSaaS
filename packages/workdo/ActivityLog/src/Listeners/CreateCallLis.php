<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Sales\Events\CreateCall;

class CreateCallLis
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
    public function handle(CreateCall $event)
    {
        if (module_is_active('ActivityLog')) {
            $call = $event->call;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Sales';
            $activity['sub_module']     = 'Calls';
            $activity['description']    = __('New Call Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $call->workspace;
            $activity['created_by']     = $call->created_by;
            $activity->save();
        }
    }
}
