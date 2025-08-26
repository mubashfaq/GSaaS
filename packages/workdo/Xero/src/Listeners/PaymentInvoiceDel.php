<?php

namespace Workdo\Xero\Listeners;

use App\Events\PaymentDestroyInvoice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Workdo\Xero\Entities\XeroPayment;
use Workdo\Xero\Http\Controllers\XeroController;

class PaymentInvoiceDel
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
    public function handle(PaymentDestroyInvoice $event)
    {
        if (module_is_active('Xero'))
        {
            $setting = getCompanyAllSetting();
            if(isset($setting['xero_is_on']) && $setting['xero_is_on'] == "on")
            {
                if(isset($setting['xero_refresh_token']))
                {
                    $base_url = "https://api.xero.com/api.xro/2.0/";

                    $xeropayment = XeroPayment::where('payment_id', $event->payment->id)->where('workspace', getActiveWorkSpace())->where('created_by', creatorId())->first();

                    $paymenturl   = $base_url . "Payments/" . $xeropayment->xero_payment_id;
                    $refreshtoken = $setting['xero_refresh_token'];

                    $data = [
                        'Status' => 'DELETED',
                    ];

                    $itemResponse = XeroController::sendQuickBooksRequest('POST', $paymenturl, $refreshtoken, $data);
                    if(isset($itemResponse->Payments[0]->PaymentID))
                    {
                        $xeropayment->delete();
                    }
                }
            }
        }
    }
}
