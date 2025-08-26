<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\RepairManagementSystem\Entities\RepairOrderRequest;
use Workdo\RepairManagementSystem\Events\CreateRepairPart;

class CreateRepairPartLis
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
    public function handle(CreateRepairPart $event)
    {
        if (module_is_active('ActivityLog')) {
            $repair_order_request = $event->repair_order_request;
            $reapair_request = RepairOrderRequest::find($repair_order_request->repair_id);
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Repair';
            $activity['sub_module']     = 'Repair Order Request';
            $activity['description']    = __('New Product Part Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $reapair_request->workspace;
            $activity['created_by']     = $reapair_request->created_by;
            $activity->save();
        }
    }
}
