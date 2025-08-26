<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\ConsignmentManagement\Events\UpdateSaleOrder;

class UpdateSaleOrderLis
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
    public function handle(UpdateSaleOrder $event)
    {
        if (module_is_active('ActivityLog')) {
            $saleOrder = $event->saleOrder;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Consignment';
            $activity['sub_module']     = 'Sale Order';
            $activity['description']    = __('Sale Order Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $saleOrder->workspace_id;
            $activity['created_by']     = $saleOrder->created_by;
            $activity->save();
        }
    }
}
