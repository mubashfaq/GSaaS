<?php

namespace Workdo\Xero\Listeners;

use App\Http\Controllers\InvoiceController;
use App\Models\Invoice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\CreateInvoice;
use App\Models\User;
use Workdo\ProductService\Entities\Tax;
use Workdo\Xero\Entities\XeroContact;
use Workdo\Account\Entities\Customer;
use Workdo\Xero\Entities\XeroInvoice;
use Workdo\Xero\Http\Controllers\XeroController;

class CreateInvoiceLis
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
    public function handle(CreateInvoice $event)
    {
        if (module_is_active('Xero')) {
            $base_url = "https://api.xero.com/api.xro/2.0/";
            $setting = getCompanyAllSetting();

            if(isset($setting['xero_is_on']) && $setting['xero_is_on']=="on")
            {
                if(isset($setting['xero_refresh_token']))
                {
                    $refreshToken = $setting['xero_refresh_token'];
                    // $refreshToken = $setting['']

                    if(isset($event->request->customer_id))
                    {
                        $xerocontact=XeroContact::where('customer_id',$event->request->customer_id)->first();

                        if(!isset($xerocontact) || empty($xerocontact))
                        {
                            $user = User::where('id',$event->request->customer_id)->first();
                            $customer = Customer::where('user_id',$user->id)->first();

                            $contacturl=$base_url."Contact";

                            $Contactdata=[
                                "Contacts" => [
                                    [
                                        'Name' => $user->name,
                                        'FirstName' => $user->name,
                                        'LastName' => $user->name,
                                        'Phone' => $user->contact,
                                        'EmailAddress' => $user->email,
                                        // "Addresses" => [
                                        //     [
                                        //         "AddressType" => "POBOX",
                                        //         "AddressLine1" => $customer->billing_address,
                                        //         "City" => $customer->billing_city,
                                        //         "PostalCode" => $customer->billing_zip,
                                        //         "Country" => $customer->billing_country,
                                        //     ],
                                        //     [
                                        //         "AddressType" => "STREET",
                                        //         "AddressLine1" => $customer->shipping_address,
                                        //         "City" => $customer->shipping_city,
                                        //         "PostalCode" => $customer->shipping_zip,
                                        //         "Country" => $customer->shipping_country,
                                        //     ],
                                        // ],
                                    ],
                                ],
                            ];

                            $customerResponse = XeroController::sendQuickBooksRequest('POST', $contacturl, $refreshToken, $Contactdata);
                            if(isset($customerResponse->Contacts[0]))
                            {
                                $contactid=$customerResponse->Contacts[0]->ContactID;
                                $xerocontact = New XeroContact();
                                $xerocontact->customer_id = $user->id;
                                $xerocontact->xero_contact_id = $contactid;
                                $xerocontact->workspace = getActiveWorkSpace();
                                $xerocontact->created_by = creatorId();
                                $xerocontact->save();
                            }
                            else
                            {
                                //                            if($customerResponse==false)
                                //                            {
                                //                                return redirect()->route('invoice.index')->with('error','Your Xero token is expired please regenrate xero Token');
                                //                            }
                            }
                        }

                        $xeroinvoice = XeroInvoice::where('invoice_id',$event->invoice->id)->where('workspace', getActiveWorkSpace())->where('created_by', creatorId())->first();
                        if($xeroinvoice==null)
                        {

                            $invoiceData = [
                                'Type' => 'ACCREC',
                                'Contact' => [
                                    'ContactID' => $xerocontact->xero_contact_id, // Replace with the actual contact ID
                                ],
                                'Date' => $event->request->input('issue_date'), // Invoice date
                                'DueDate' =>  $event->request->input('due_date'), // Due date
                                'LineAmountTypes' => "NoTax",
                                'InvoiceNumber' => Invoice::invoiceNumberFormat(XeroController::invoiceNumber()),
                                'Status' => 'DRAFT',
                                'LineItems' => [],
                            ];
                            $lineItems = $event->request->input('items', []);
                            foreach ($lineItems as $item) {
                                if($item['tax']==null)
                                {
                                    $invoiceData['LineItems'][] = [
                                        'Description' => $item['description'],
                                        'Quantity' => $item['quantity'],
                                        'UnitAmount' => $item['price'],
                                        'AccountCode' => 200,
                                    ];
                                }
                                else
                                {
                                    $total_tax=0;
                                    $taxarray = explode(",",$item['tax']);
                                    $taxs = Tax::whereIn('id',$taxarray)->get();
                                    $price =($item['price'] * $item['quantity'])- $item['discount'] ;
                                    foreach($taxs as $tax)
                                    {
                                        $total_tax = $total_tax + ($price  * ($tax->rate / 100));
                                    }

                                    $invoiceData['LineItems'][] = [
                                        'Description' => $item['description'],
                                        'Quantity' => 1,
                                        'UnitAmount' => $total_tax + $price,
                                        'AccountCode' => 200,
                                    ];
                                }
                            }

                            $invoiceurl=$base_url."invoices";
                            $itemResponse = XeroController::sendQuickBooksRequest('POST', $invoiceurl, $refreshToken, $invoiceData);

                            if(isset($itemResponse->Invoices[0]))
                            {
                                $invoiceid=$itemResponse->Invoices[0]->InvoiceID;

                                $xeroinvoice = New XeroInvoice();
                                $xeroinvoice->invoice_id = $event->invoice->id;
                                $xeroinvoice->xero_invoice_id = $invoiceid;
                                $xeroinvoice->workspace = getActiveWorkSpace();
                                $xeroinvoice->created_by = creatorId();
                                $xeroinvoice->save();
                            }
                            else
                            {

                                //                            if($itemResponse==false)
                                //                            {
                                //                                return redirect()->route('invoice.index')->with('error','Your Xero token is expired please regenrate xero Token');
                                //                            }
                                //                            else
                                //                            {
                                //                                return redirect()->route('invoice.index')->with('error','Somethings Went Wrong');
                                //                            }
                            }
                        }
                    }
                }
                //            else
                //            {
                //                return redirect()->route('invoice.index')->with('error','Please genrate xero token the after sync invoice to Xero');
                //            }
            }
        }
    }
}
