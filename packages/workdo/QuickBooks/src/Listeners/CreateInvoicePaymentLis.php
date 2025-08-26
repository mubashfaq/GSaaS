<?php

namespace Workdo\QuickBooks\Listeners;

use App\Events\CreatePaymentInvoice;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Workdo\Account\Entities\Customer;
use Workdo\QuickBooks\Entities\QuickbookCustomer;
use Workdo\QuickBooks\Entities\QuickbookInvoice;
use Workdo\QuickBooks\Entities\QuickbookPayment;
use Workdo\QuickBooks\Http\Controllers\QuickBooksController;

class CreateInvoicePaymentLis
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


        $setting      = getCompanyAllSetting();

        if(isset($setting['quickbook_is_on']) && $setting['quickbook_is_on']=="on")
        {
            if(isset($setting['quickbook_refresh_token']))
            {
                $company_id   = $setting['quickbook_company_id'];
                $type         = $setting['company_quickbook_mode'];
                $refreshToken = $setting['quickbook_refresh_token'];

                if($setting['company_quickbook_mode'] == "live")
                {
                    $base_url = "https://quickbooks.api.intuit.com";
                }
                else
                {
                    $base_url = "https://sandbox-quickbooks.api.intuit.com";
                }

                if(isset($event->request) && isset($event->invoice))
                {
                    $quickbookpayment = QuickbookPayment::where('payment_id',$event->invoicePayment->id)->first();
                    if($quickbookpayment==null)
                    {
                        $user = User::where('id',$event->invoice->user_id)->first();

                        $customer=Customer::where('user_id',$user->id)->first();
                        $quickbookinvoice=QuickbookInvoice::where('invoice_id',$event->invoice->id)->first();
                        $quickbookcustomer= QuickbookCustomer::where('customer_id',$user->id)->first();
                        if(isset($quickbookinvoice) && isset($quickbookcustomer))
                        {
                            $paymentCreateUrl=$base_url.'/v3/company/'.$company_id.'/payment';
                            $paymentData = [
                                'CustomerRef'=>[
                                    "value"=> $quickbookcustomer->quickbook_customer_id,
                                    "name" => $user->name
                                ],
                                'Line' => [
                                    [
                                        'Amount' => floatval($event->invoicePayment->amount), // Payment amount
                                        'LinkedTxn' => [
                                            [
                                                'TxnId' => $quickbookinvoice->quickbook_invoice_id, // ID of the invoice to link to
                                                'TxnType' => 'Invoice', // Type of transaction (Invoice)
                                            ],
                                        ],
                                    ],
                                ],
                                'TotalAmt' => floatval($event->invoicePayment->amount), // Total payment amount
                                'PaymentMethodRef' => [
                                    'value' => 1, // ID of the payment method used
                                ],
                            ];

                            $paymentResponse = QuickBooksController::sendQuickBooksRequest('POST', $paymentCreateUrl, $refreshToken, $paymentData);
                            if(isset($paymentResponse->Payment))
                            {
                                $paymentid=$paymentResponse->Payment->Id;

                                $quickbookpayment=New QuickbookPayment();
                                $quickbookpayment->payment_id=$event->invoicePayment->id;
                                $quickbookpayment->quickbook_payment_id=$paymentid;
                                $quickbookpayment->workspace = getActiveWorkSpace();
                                $quickbookpayment->created_by=creatorId();
                                $quickbookpayment->save();
                            }
                            else
                            {
                                //                        dd($paymentResponse);
                            }
                        }
                    }
                }
            }
//            else
//            {
//                return redirect()->route('invoice.index')->with('error',__('Please genrate first QuickBook Token'));
//            }
        }
    }
}
