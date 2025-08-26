<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\VehicleInspectionManagement\Entities\InspectionDefectsAndRepairs;
use Workdo\VehicleInspectionManagement\Events\UpdateDefectsAndRepairs;

class UpdateDefectsAndRepairsLis
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
    public function handle(UpdateDefectsAndRepairs $event)
    {
        if (module_is_active('ActivityLog')) {
            $invoice = $event->invoice;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Vehicle Inspection';
            $activity['sub_module']     = 'Defects And Repairs';
            $activity['description']    = __('Defects And Repairs ') . InspectionDefectsAndRepairs::inspectionInvoiceNumberFormat($invoice->invoice_id) . __(' Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $invoice->workspace;
            $activity['created_by']     = $invoice->created_by;
            $activity->save();
        }
    }
}
