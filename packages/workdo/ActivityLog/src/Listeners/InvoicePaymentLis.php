<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Invoice;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\Retainer\Entities\Retainer;
use Workdo\Sales\Entities\SalesInvoice;
use Workdo\Stripe\Events\StripePaymentStatus;
use Workdo\Paypal\Events\PaypalPaymentStatus;

class InvoicePaymentLis
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
    public function handle($event)
    {
        if (module_is_active('ActivityLog')) {

            $payment = $event->payment;
            $type = $event->type;
            $data = $event->data;
            if ($type == 'invoice') {
                $activity                   = new AllActivityLog();
                $activity['module']         = 'Invoice';
                $activity['sub_module']     = '--';
                $activity['description']    = __('Invoice ') . Invoice::invoiceNumberFormat($data->invoice_id, $data->created_by, $data->workspace) . __(' Pay with ') . $payment->payment_type . __(' by the ');
                $activity['user_id']        =  $data->created_by;
                $activity['url']            = '';
                $activity['workspace']      = $data->workspace;
                $activity['created_by']     = $data->created_by;
                $activity->save();
            }
            if ($type == 'retainer') {
                $activity                   = new AllActivityLog();
                $activity['module']         = 'Retainer';
                $activity['sub_module']     = '--';
                $activity['description']    = __('Retainer ') . Retainer::retainerNumberFormat($data->retainer_id, $data->created_by,$data->workspace) . __(' Pay with ') . $payment->payment_type . __(' by the ');
                $activity['user_id']        =  $data->created_by;
                $activity['url']            = '';
                $activity['workspace']      = $data->workspace;
                $activity['created_by']     = $data->created_by;
                $activity->save();
            }
            if ($type == 'salesinvoice') {
                $activity                   = new AllActivityLog();
                $activity['module']         = 'Sales';
                $activity['sub_module']     = 'Sales Invoice';
                $activity['description']    = __('Sales Invoice ') . SalesInvoice::invoiceNumberFormat($data->invoice_id, $data->created_by,$data->workspace) . __(' Pay with ') . $payment->payment_type . __(' by the ');
                $activity['user_id']        =  $data->created_by;
                $activity['url']            = '';
                $activity['workspace']      = $data->workspace;
                $activity['created_by']     = $data->created_by;
                $activity->save();
            }
        }
    }
}
