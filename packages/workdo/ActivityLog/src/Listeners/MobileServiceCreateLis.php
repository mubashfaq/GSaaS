<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\MobileServiceManagement\Events\MobileServiceCreate;

class MobileServiceCreateLis
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
    public function handle(MobileServiceCreate $event)
    {
        if (module_is_active('ActivityLog')) {
            $data = $event->data;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Mobile Service';
            $activity['sub_module']     = 'Create Request';
            $activity['description']    =  __('New Service Request ') .  $data->service_id . __(' created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $data['workspace_id'];
            $activity['created_by']     = $data['created_by'];
            $activity->save();
        }
    }
}
