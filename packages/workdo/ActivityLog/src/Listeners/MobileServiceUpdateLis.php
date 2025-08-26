<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\MobileServiceManagement\Events\MobileServiceUpdate;

class MobileServiceUpdateLis
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
    public function handle(MobileServiceUpdate $event)
    {
        if (module_is_active('ActivityLog')) {
            $servicereqData = $event->servicereqData;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Mobile Service';
            $activity['sub_module']     = 'Create Request';
            $activity['description']    =  __('Service Request ') .  $servicereqData->service_id . __(' updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $servicereqData['workspace_id'];
            $activity['created_by']     = $servicereqData['created_by'];
            $activity->save();
        }
    }
}
