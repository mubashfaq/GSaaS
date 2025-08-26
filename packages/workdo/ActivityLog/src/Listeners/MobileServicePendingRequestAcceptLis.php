<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\MobileServiceManagement\Events\MobileServicePendingRequestAccept;

class MobileServicePendingRequestAcceptLis
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
    public function handle(MobileServicePendingRequestAccept $event)
    {
        if (module_is_active('ActivityLog')) {
            $findService = $event->findService;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Mobile Service';
            $activity['sub_module']     = 'Pending Request';
            $activity['description']    =  __('Pending Request of service ') .  $findService->service_id . __(' accepted by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $findService['workspace_id'];
            $activity['created_by']     = $findService['created_by'];
            $activity->save();
        }
    }
}
