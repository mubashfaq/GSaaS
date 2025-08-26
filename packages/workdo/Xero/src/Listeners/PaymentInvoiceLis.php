<?php

namespace Workdo\Xero\Listeners;

use App\Events\CreatePaymentInvoice;
use App\Models\XeroInvoice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Workdo\Account\Entities\BankAccount;
use Workdo\Account\Entities\ChartOfAccount;
use Workdo\Xero\Entities\XeroChartOfAccount;
use Workdo\Xero\Entities\XeroContact;
use Workdo\Xero\Entities\XeroPayment;
use Workdo\Xero\Http\Controllers\XeroController;

class PaymentInvoiceLis
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
    public function handle(CreatePaymentInvoice $event)
    {
        if (module_is_active('Xero'))
        {
            $setting = getCompanyAllSetting();
            if(isset($setting['xero_is_on']) && $setting['xero_is_on'] == "on")
            {

                if(isset($setting['xero_refresh_token']))
                {

                    $base_url = "https://api.xero.com/api.xro/2.0/";

                    $xeroinvoice  = \Workdo\Xero\Entities\XeroInvoice::where('invoice_id', $event->invoice->id)->first();
                    $xerocustomer = XeroContact::where('customer_id', $event->invoice->customer_id)->first();
                    $xeropayment  = XeroPayment::where('payment_id', $event->invoicePayment->id)->first();

                    if($xeropayment == null && $xeroinvoice != null)
                    {
                        $bankaccount    = BankAccount::find($event->request->account_id);
                        $chartofaccount = ChartOfAccount::find($bankaccount->chart_of_account);

                        $refreshtoken    = $setting['xero_refresh_token'];
                        $getinvoiceurl   = $base_url . "Invoices/" . $xeroinvoice->xero_invoice_id;
                        $invoiceResponse = XeroController::sendQuickBooksRequest('GET', $getinvoiceurl, $refreshtoken);

                        if(isset($invoiceResponse->Invoices[0]))
                        {
                            if($invoiceResponse->Invoices[0]->Status != "AUTHORISED")
                            {
                                $paymenturl   = $base_url . "Invoices/$xeroinvoice->xero_invoice_id";
                                $refreshtoken = $setting['xero_refresh_token'];

                                $invoicedata  = [
                                    'InvoiceNumber' => $invoiceResponse->Invoices[0]->InvoiceNumber,
                                    'SentToContact' => 'true',
                                    'Status' => 'AUTHORISED',
                                ];
                                $itemResponse = XeroController::sendQuickBooksRequest('POST', $paymenturl, $refreshtoken, $invoicedata);
                            }

                            if(($invoiceResponse->Invoices[0]->Status == "AUTHORISED") || (isset($itemResponse->Invoices[0]->Status) && ($itemResponse->Invoices[0]->Status == "AUTHORISED")))
                            {
                                if(isset($chartofaccount))
                                {
                                    $xeroaccount = XeroChartOfAccount::where('chartofaccount_id', $chartofaccount->id)->first();
                                }
                                $refreshtoken = $setting['xero_refresh_token'];
                                $paymenturl   = $base_url . "Payments";

                                $paymentData = [
                                    'Payments' => [
                                        [
                                            'Invoice' => [
                                                'InvoiceID' => $xeroinvoice->xero_invoice_id,
                                                // Replace with the actual InvoiceID
                                            ],
                                            'Amount' => floatval($event->request->amount),
                                            // Specify the payment amount
                                            'Date' => date('Y-m-d'),
                                            // Specify the payment date in ISO 8601 format
                                            'PaymentType' => 'ACCPAY',
                                            'Account' => [
                                                "AccountID" => isset($xeroaccount->xero_id) ? $xeroaccount->xero_id : "562555f2-8cde-4ce9-8203-0363922537a4",
                                                "Code" => isset($xeroaccount->xero_code) ? $xeroaccount->xero_code : "090"
                                                // Replace with the actual bank account ID
                                            ],
                                            'Reference' => 'Payment for Invoice INV-123',
                                            // Optional: Add a reference for the payment
                                            'IsReconciled' => true,
                                            // Optional: Set to true if the payment should be automatically reconciled
                                        ]
                                    ]
                                ];

                                $itemResponse = XeroController::sendQuickBooksRequest('POST', $paymenturl, $refreshtoken, $paymentData);

                                if(isset($itemResponse->Payments[0]->PaymentID))
                                {

                                    $xeropayment                  = new XeroPayment();
                                    $xeropayment->payment_id      = $event->invoicePayment->id;
                                    $xeropayment->xero_payment_id = $itemResponse->Payments[0]->PaymentID;
                                    $xeropayment->workspace       = getActiveWorkSpace();
                                    $xeropayment->created_by      = creatorId();
                                    $xeropayment->save();
                                }
                                else
                                {
                                    if($itemResponse == false)
                                    {
                                        return redirect()->route('invoice.index')->with('error', 'Your Xero token is expired please regenrate xero Token');
                                    }
                                }
                            }
                        }

                    }
                }
            }
        }
    }
}
