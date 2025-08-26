<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\RepairManagementSystem\Events\CretaeRepairInvoice;

class CretaeRepairInvoiceLis
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
    public function handle(CretaeRepairInvoice $event)
    {
        if (module_is_active('ActivityLog')) {
            $repair_invoice = $event->repair_invoice;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Repair';
            $activity['sub_module']     = 'Repair Order Request';
            $activity['description']    = __('New Invoice Created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $repair_invoice->workspace;
            $activity['created_by']     = $repair_invoice->created_by;
            $activity->save();
        }
    }
}
