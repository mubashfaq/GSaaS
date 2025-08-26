<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\BusinessProcessMapping\Events\CreateBusinessProcessMapping;

class CreateBusinessProcessMappingLis
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
    public function handle(CreateBusinessProcessMapping $event)
    {
        if (module_is_active('ActivityLog')) {
            $businessProcess = $event->businessProcess;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Business Mapping';
            $activity['sub_module']     = '--';
            $activity['description']    = __('New Business Process Mapping Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $businessProcess->workspace;
            $activity['created_by']     = $businessProcess->created_by;
            $activity->save();
        }
    }
}
