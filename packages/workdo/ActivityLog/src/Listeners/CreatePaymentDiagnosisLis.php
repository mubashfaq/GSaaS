<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\MachineRepairManagement\Entities\MachineInvoice;
use Workdo\MachineRepairManagement\Events\CreatePaymentDiagnosis;

class CreatePaymentDiagnosisLis
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
    public function handle(CreatePaymentDiagnosis $event)
    {
        if (module_is_active('ActivityLog')) {
            $invoice = $event->invoice;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Machine Repair';
            $activity['sub_module']     = 'Diagnosis';
            $activity['description']    = __('Add Payment in Diagnosis ') . MachineInvoice::machineInvoiceNumberFormat($invoice->invoice_id) . __(' by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $invoice->workspace;
            $activity['created_by']     = $invoice->created_by;
            $activity->save();
        }
    }
}
