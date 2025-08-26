<?php

namespace Workdo\Xero\Listeners;

use App\Events\DestroyInvoice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Workdo\Xero\Entities\XeroInvoice;
use Workdo\Xero\Http\Controllers\XeroController;

class XeroInvoiceDel
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
    public function handle(DestroyInvoice $event)
    {
        if (module_is_active('Xero'))
        {
            $setting = getCompanyAllSetting();
            if(isset($setting['xero_is_on']) && $setting['xero_is_on'] == "on")
            {
                if(isset($setting['xero_refresh_token']))
                {
                    $base_url    = "https://api.xero.com/api.xro/2.0/";
                    $xeroinvoice = XeroInvoice::where('invoice_id', $event->invoice->id)->where('workspace', getActiveWorkSpace())->where('created_by', creatorId())->first();
                    if(isset($xeroinvoice->xero_invoice_id))
                    {
                        $refreshtoken    = $setting['xero_refresh_token'];
                        $getinvoiceurl   = $base_url . "Invoices/" . $xeroinvoice->xero_invoice_id;
                        $invoiceResponse = XeroController::sendQuickBooksRequest('GET', $getinvoiceurl, $refreshtoken);

                        if($invoiceResponse->Invoices[0]->Status == "DRAFT")
                        {
                            $paymenturl   = $base_url . "Invoices/" . $invoiceResponse->Invoices[0]->InvoiceNumber;
                            $statuschange = [
                                'InvoiceNumber' => $invoiceResponse->Invoices[0]->InvoiceNumber,
                                'Status' => 'DELETED',
                            ];

                            $itemResponse = XeroController::sendQuickBooksRequest('POST', $paymenturl, $refreshtoken, $statuschange);
                            if($invoiceResponse->Invoices[0]->Status == "DELETED")
                            {
                                $xeroinvoice->delete();
                            }
                        }
                    }
                }
            }
        }
    }
}
