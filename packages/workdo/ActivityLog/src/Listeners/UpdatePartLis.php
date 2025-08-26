<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\CMMS\Events\UpdatePart;

class UpdatePartLis
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
    public function handle(UpdatePart $event)
    {
        if (module_is_active('ActivityLog')) {
            $parts = $event->parts;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'CMMS';
            $activity['sub_module']     = 'Parts';
            $activity['description']    = __('Parts Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $parts->workspace;
            $activity['created_by']     = $parts->created_by;
            $activity->save();
        }
    }
}
