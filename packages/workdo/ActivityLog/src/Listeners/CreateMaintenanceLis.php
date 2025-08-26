<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\FixEquipment\Events\CreateMaintenance;

class CreateMaintenanceLis
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
    public function handle(CreateMaintenance $event)
    {
        if (module_is_active('ActivityLog')) {
            $maintenance = $event->maintenance;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Fix Equipment';
            $activity['sub_module']     = 'Maintenance';
            $activity['description']    = __('New Maintenance Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $maintenance->workspace;
            $activity['created_by']     = $maintenance->created_by;
            $activity->save();
        }
    }
}
