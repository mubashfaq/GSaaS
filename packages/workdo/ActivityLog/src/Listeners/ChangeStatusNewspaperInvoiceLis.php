<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Newspaper\Entities\NewspaperInvoice;
use Workdo\Newspaper\Events\ChangeStatusNewspaperInvoice;

class ChangeStatusNewspaperInvoiceLis
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
    public function handle(ChangeStatusNewspaperInvoice $event)
    {
        if (module_is_active('ActivityLog')) {
            $newspaperinvoice = $event->newspaperinvoice;
            $invoice = NewspaperInvoice::find($newspaperinvoice->invoice_id);
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Newspaper';
            $activity['sub_module']     = 'Invoice';
            $activity['description']    = __('Invoice ') . NewspaperInvoice::invoiceNumberFormat($invoice->invoice_id) . __(' Status Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $newspaperinvoice->workspace;
            $activity['created_by']     = $newspaperinvoice->created_by;
            $activity->save();
        }
    }
}
