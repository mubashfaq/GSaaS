<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\ConsignmentManagement\Events\CreatePurchaseOrder;

class CreatePurchaseOrderLis
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
    public function handle(CreatePurchaseOrder $event)
    {
        if (module_is_active('ActivityLog')) {
            $purchaseOrder = $event->purchaseOrder;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Consignment';
            $activity['sub_module']     = 'Purchase Order';
            $activity['description']    = __('New Purchase Order Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $purchaseOrder->workspace_id;
            $activity['created_by']     = $purchaseOrder->created_by;
            $activity->save();
        }
    }
}
