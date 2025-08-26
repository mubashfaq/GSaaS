<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\CMMS\Events\UpdateCmmspos;

class UpdateCmmsposLis
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
    public function handle(UpdateCmmspos $event)
    {
        if (module_is_active('ActivityLog')) {
            $POs = $event->Pos;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'CMMS';
            $activity['sub_module']     = 'POs';
            $activity['description']    = __('POs Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $POs->workspace;
            $activity['created_by']     = $POs->created_by;
            $activity->save();
        }
    }
}
