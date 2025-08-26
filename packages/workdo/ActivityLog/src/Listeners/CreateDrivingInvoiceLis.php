<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\DrivingSchool\Entities\DrivingInvoice;
use Workdo\DrivingSchool\Events\CreateDrivingInvoice;

class CreateDrivingInvoiceLis
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
    public function handle(CreateDrivingInvoice $event)
    {
        if (module_is_active('ActivityLog')) {
            $invoice = $event->invoice;

            $activity                   = new AllActivityLog();
            $activity['module']         = 'Driving School';
            $activity['sub_module']     = 'Invoice';
            $activity['description']    = __('New Invoice ') . DrivingInvoice::invoiceNumberFormat($invoice->invoice_id) . __(' created by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $invoice['workspace'];
            $activity['created_by']     = $invoice['created_by'];
            $activity->save();
        }
    }
}
