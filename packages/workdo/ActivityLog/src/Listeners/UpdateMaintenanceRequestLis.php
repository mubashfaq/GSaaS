<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\PropertyManagement\Events\UpdateMaintenanceRequest;

class UpdateMaintenanceRequestLis
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
    public function handle(UpdateMaintenanceRequest $event)
    {
        if (module_is_active('ActivityLog')) {
            $maintenance = $event->maintenance;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Property Manage';
            $activity['sub_module']     = 'Maintenance Request';
            $activity['description']    = __('Maintenance Request Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $maintenance->workspace;
            $activity['created_by']     = $maintenance->created_by;
            $activity->save();
        }
    }
}
