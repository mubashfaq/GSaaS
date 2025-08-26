<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\ConsignmentManagement\Events\UpdateProduct;

class UpdateConsignmentProductLis
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
    public function handle(UpdateProduct $event)
    {
        if (module_is_active('ActivityLog')) {
            $consignmentProduct = $event->consignmentProduct;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Consignment';
            $activity['sub_module']     = 'Product';
            $activity['description']    = __('Product Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $consignmentProduct->workspace_id;
            $activity['created_by']     = $consignmentProduct->created_by;
            $activity->save();
        }
    }
}
