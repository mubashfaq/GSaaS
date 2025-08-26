<?php

namespace Workdo\QuickBooks\Listeners;

use App\Events\CreateInvoice;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\Account\Entities\ChartOfAccount;
use Workdo\Account\Entities\Customer;
use Workdo\ProductService\Entities\ProductService;
use Workdo\QuickBooks\Entities\QuickbookChartOfAccount;
use Workdo\QuickBooks\Entities\QuickbookCustomer;
use Workdo\QuickBooks\Entities\QuickbookInvoice;
use Workdo\QuickBooks\Entities\QuickbookItem;
use Workdo\QuickBooks\Http\Controllers\QuickBooksController;

class CreateQuickBookLis
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
     * @param object $event
     *
     * @return void
     */
    public function handle(CreateInvoice $event)
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
                if(isset($event->request->customer_id))
                {
                    $user = User::where('id',$event->request->customer_id)->first();
                    $customer = Customer::where('user_id', '=', $event->request->customer_id)->first();

                    $quickbookcustomer = QuickbookCustomer::where('customer_id', $user->id)->first();

                    if($quickbookcustomer == null)
                    {
                        $customerCreateUrl = $base_url . '/v3/company/' . $company_id . '/customer';

                        $customerData = [
                            'FullyQualifiedName' => $user->name,
                            'PrimaryEmailAddr' => [
                                'Address' => $user->email,
                            ],
                            "DisplayName" => $user->name,
                            'PrimaryPhone' => [
                                'FreeFormNumber' => $user->contact,
                            ],
                            //                            'BillAddr' => [
                            //                                'Line1' => $customer->billing_address,
                            //                                'City' => $customer->billing_city,
                            //                                'Country' => $customer->billing_country,
                            //                                'PostalCode' => $customer->billing_zip,
                            //                            ],
                            //                            'ShipAddr' => [
                            //                                'Line1' => $customer->shipping_address,
                            //                                'City' => $customer->shipping_city,
                            //                                'Country' => $customer->shipping_country,
                            //                                'PostalCode' => $customer->shipping_zip,
                            //                            ],
                        ];

                        $customer_response = QuickBooksController::sendQuickBooksRequest('POST', $customerCreateUrl, $refreshToken, $customerData);

                        if(isset($customer_response->Customer))
                        {
                            $customer_id = $customer_response->Customer->Id;

                            $quickbookcustomer                        = new QuickbookCustomer();
                            $quickbookcustomer->customer_id           = $user->id;
                            $quickbookcustomer->quickbook_customer_id = $customer_id;
                            $quickbookcustomer->workspace             = getActiveWorkSpace();
                            $quickbookcustomer->created_by            = Auth::user()->id;
                            $quickbookcustomer->save();
                        }
                        else
                        {
                        }
                    }
                }

                if(isset($event->request->items))
                {
                    $itemproduct = $event->request->items;

                    for($i = 0; $i < count($event->request->items); $i++)
                    {
                        $quickbookitem = QuickbookItem::where('item_id', $itemproduct[$i]['item'])->where('workspace', getActiveWorkSpace())->where('created_by', creatorId())->get();

                        if($quickbookitem->count() == 0)
                        {
                            if(module_is_active('ProductService'))
                            {
                                $productservice = ProductService::where('id', $itemproduct[$i]['item'])->where('workspace_id', getActiveWorkSpace())->where('created_by', creatorId())->first();
                                if(isset($productservice))
                                {
                                    $incomequickbook  = QuickbookChartOfAccount::where('chartofaccount_id', $productservice->sale_chartaccount_id)->first();
                                    $incomeaccount    = ChartOfAccount::where('id', $productservice->sale_chartaccount_id)->first();
                                    $expensequickbook = QuickbookChartOfAccount::where('chartofaccount_id', $productservice->expense_chartaccount_id)->first();
                                    $expensaccount    = ChartOfAccount::where('id', $productservice->expense_chartaccount_id)->first();

                                    $itemCreateUrl = $base_url . '/v3/company/' . $company_id . '/item';

                                    if($productservice->type == "service")
                                    {
                                        $itemData = [
                                            'Type' => 'Service',
                                            "TrackQtyOnHand" => true,
                                            'Name' => $productservice->name,
                                            "InvStartDate" => date('Y-m-d'),
                                            'AssetAccountRef' => [
                                                'value' => '81',
                                                'name' => 'Inventory Asset',
                                            ],
                                            'ExpenseAccountRef' => [
                                                'value' => ($expensequickbook != null) ? $expensequickbook->quickbook_id : 80,
                                                'name' => ($expensequickbook != null) ? $expensaccount->name : "Cost of Goods Sold",
                                            ],
                                            'IncomeAccountRef' => [
                                                'value' => ($incomequickbook != null) ? $incomequickbook->quickbook_id : 79,
                                                'name' => ($incomequickbook != null) ? $incomeaccount->name : "Sales of Product Income",
                                            ],
                                            'QtyOnHand' => $productservice->quantity,
                                        ];
                                    }
                                    else
                                    {
                                        $itemData = [
                                            "TrackQtyOnHand" => true,
                                            'Name' => $productservice->name,
                                            'QtyOnHand' => $productservice->quantity,
                                            'IncomeAccountRef' => [
                                                'value' => ($incomequickbook != null) ? $incomequickbook->quickbook_id : 79,
                                                'name' => ($incomequickbook != null) ? $incomeaccount->name : "Sales of Product Income",
                                            ],
                                            'AssetAccountRef' => [
                                                'value' => '81',
                                                'name' => 'Inventory Asset',
                                            ],
                                            "InvStartDate" => date('Y-m-d'),
                                            "Type" => 'Inventory',
                                            'ExpenseAccountRef' => [
                                                'value' => ($expensequickbook != null) ? $expensequickbook->quickbook_id : 80,
                                                'name' => ($expensequickbook != null) ? $expensaccount->name : "Cost of Goods Sold",
                                            ],
                                            "UnitPrice" => (float)$productservice->sale_price,
                                        ];
                                    }


                                    $itemResponse = QuickBooksController::sendQuickBooksRequest('POST', $itemCreateUrl, $refreshToken, $itemData);
                                    if(isset($itemResponse->Item))
                                    {
                                        $itemId                           = $itemResponse->Item->Id;
                                        $quickbookitem                    = new QuickbookItem();
                                        $quickbookitem->item_id           = $productservice->id;
                                        $quickbookitem->quickbook_item_id = $itemId;
                                        $quickbookitem->workspace         = getActiveWorkSpace();
                                        $quickbookitem->created_by        = creatorId();
                                        $quickbookitem->save();
                                    }
                                    else
                                    {
//                                        dd($itemResponse);
//                                                                    return redirect()->back()->with('error',__(str_replace("'", '"',$itemResponse->Fault->Error[0]->Detail)));
                                    }
                                }
                            }
                        }
                    }
                }


                $quickbookinvoice = QuickbookInvoice::where('invoice_id', $event->invoice->id)->where('workspace', getActiveWorkSpace())->where('created_by', creatorId())->first();

                if($quickbookinvoice == null)
                {

                    $invoiceCreateUrl = $base_url . '/v3/company/' . $company_id . '/invoice';
                    $lineItems        = $event->request->input('items', []);

                    $invoiceData = [
                        'Line' => [],
                        'CustomerRef' => [
                            'value' => $quickbookcustomer->quickbook_customer_id,
                            // Replace with the customer's ID
                        ],
                        'TxnDate' => $event->request->input('issue_date'),
                        'DueDate' => $event->request->input('due_date'),
                        "GlobalTaxCalculation" => "NotApplicable",
                        //                "GlobalTaxCalculation" => "TaxExcluded",
                    ];
                    foreach($lineItems as $item)
                    {
                        $productservice = ProductService::find($item['item']);

                        $quickbookitem = QuickbookItem::where('item_id', $item['item'])->first();

                        $total_tax = 0;
                        if(isset($item['tax']))
                        {
                            $tax       = \Workdo\ProductService\Entities\Tax::where('id', $item['tax'])->where('workspace_id', getActiveWorkSpace())->first();
                            $total_tax = ($tax->rate / 100) * ($item['price'] * $item['quantity']);
                        }

                        $invoiceData['Line'][] = [
                            'Description' => $item['description'],
                            'Amount' => $total_tax + $item['price'],
                            // Line item amount
                            'DetailType' => 'SalesItemLineDetail',
                            'SalesItemLineDetail' => [
                                'ItemRef' => [
                                    "name" => $productservice->name,
                                    'value' => $quickbookitem->quickbook_item_id,
                                    // ID of the item being sold
                                ],
                                'UnitPrice' => $total_tax + $item['price'],
                                // Unit price of the item
                                'Qty' => $item['quantity'],
                                // Quantity of the item
                            ],
                        ];
                    }

                    $invoiceResponse = QuickBooksController::sendQuickBooksRequest('POST', $invoiceCreateUrl, $refreshToken, $invoiceData);

                    if(isset($invoiceResponse->Invoice))
                    {
                        $quickbookinvoiceid = $invoiceResponse->Invoice->Id;

                        $quickbookinvoice                       = new QuickbookInvoice();
                        $quickbookinvoice->invoice_id           = $event->invoice->id;
                        $quickbookinvoice->quickbook_invoice_id = $quickbookinvoiceid;
                        $quickbookinvoice->workspace            = getActiveWorkSpace();
                        $quickbookinvoice->created_by           = creatorId();
                        $quickbookinvoice->save();
                    }
                    else
                    {
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
