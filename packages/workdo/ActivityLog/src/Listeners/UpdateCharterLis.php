<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Planning\Events\UpdateCharter;

class UpdateCharterLis
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
    public function handle(UpdateCharter $event)
    {
        if (module_is_active('ActivityLog')) {
            $Charter = $event->Charter;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Planning';
            $activity['sub_module']     = 'Charters';
            $activity['description']    =  __('Charter updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $Charter['workspace'];
            $activity['created_by']     = $Charter['created_by'];
            $activity->save();
        }
    }
}
