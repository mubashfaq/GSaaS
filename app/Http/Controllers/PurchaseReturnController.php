<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\PurchaseProductBatch;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnProduct;
use App\Models\PurchaseReturnPayment;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
use App\Models\PurchasePayment;
use App\Events\CreatePaymentPurchase;
class PurchaseReturnController extends Controller
{
    //
    
    public function index(Request $request)
    {
        if (\Auth::user()->isAbleTo('purchase manage')) {
            $vender = [];
            if (module_is_active('Account')) {
                $vender = \Workdo\Account\Entities\Vender::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id');
                $vender->prepend('Select Vendor', '');
            }
            $status = PurchaseReturn::$statues;
            $query = PurchaseReturn::where('created_by', creatorId())->where('workspace', getActiveWorkSpace());
            
            // Apply filters if provided
            if (!empty($request->vender_id)) {
                $query->where('vender_id', $request->vender_id);
            }
            if (!empty($request->status)) {
                $query->where('status', $request->status);
            }
            
            $returns = $query->orderBy('id', 'desc')->get();
            
            return view('purchase_returns.index', compact('returns', 'status', 'vender'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($purchaseId = null)
    {
     
        if (\Auth::user()->isAbleTo('purchase create')) {
            $purchases = Purchase::where('created_by', creatorId())
                ->where('workspace', getActiveWorkSpace())
                ->where('status', 4) // Only completed purchases can be returned
                ->get()
                ->mapWithKeys(function ($purchase) {
                    return [
                        $purchase->id => Purchase::purchaseNumberFormat($purchase->purchase_id),
                    ];
                });
            $purchases->prepend('Select Purchase', '');
              
            $selectedPurchase = null;
            $purchaseProducts = [];
            
            if ($purchaseId) {
                try {
                  
                    $id = Crypt::decrypt($purchaseId);
                    $selectedPurchase = Purchase::find($id);
                  
                    
                    if ($selectedPurchase && $selectedPurchase->created_by == creatorId() && $selectedPurchase->workspace == getActiveWorkSpace()) {
                        $purchaseProducts = $selectedPurchase->itemswithproduct;
                        foreach ($purchaseProducts as $product) {
                                // Find the corresponding batch record
                                $batchProduct = PurchaseProductBatch::where('purchase_id', $selectedPurchase->id)
                                    ->where('product_id', $product->product_id)
                                    ->where('batch_no', $product->batch_no)
                                    ->first();
                                
                                // Add remaining quantity to product object
                                $product->remaining_qty = $batchProduct ? $batchProduct->rem_quantity : $product->quantity;
                                
                                // Get tax rate from taxes table
                                if (!empty($product->tax)) {
                                    $tax = \DB::table('taxes')->where('id', $product->tax)->first();
                                    $product->tax_rate = $tax ? $tax->rate : 0;
                                    $product->tax_name = $tax ? $tax->name : '';
                                } else {
                                    $product->tax_rate = 0;
                                    $product->tax_name = '';
                                }
                            }
                    }
                } catch (\Throwable $th) {
                    return redirect()->back()->with('error', __('Purchase Not Found.'));
                }
            }
           
            $return_number = PurchaseReturn::returnNumberFormat($this->returnNumber());
           
            return view('purchase_returns.create', compact('purchases', 'selectedPurchase', 'purchaseProducts', 'return_number'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Generate a unique return number
     */
    public function returnNumber()
    {
        $latest = PurchaseReturn::where('created_by', '=', creatorId())->where('workspace', getActiveWorkSpace())->latest()->first();
        if (!$latest) {
            return 1;
        }
        return $latest->return_id + 1;
    }

    /**
     * Get purchase products for a given purchase ID
     */
   public function getPurchaseProducts($id)
{
    $purchase = Purchase::find($id);
    
    if (!$purchase || $purchase->created_by != creatorId() || $purchase->workspace != getActiveWorkSpace()) {
        return response()->json(['error' => __('Purchase not found')], 404);
    }
    
    // Get purchase products with their associated product details
    $products = $purchase->itemswithproduct;
    
    // Get remaining quantities from PurchaseProductBatch and tax rate from taxes table
    foreach ($products as $product) {
        // Find the corresponding batch record
        $batchProduct = PurchaseProductBatch::where('purchase_id', $purchase->id)
            ->where('product_id', $product->product_id)
            ->where('batch_no', $product->batch_no)
            ->first();
        
        // Add remaining quantity to product object
        $product->remaining_qty = $batchProduct ? $batchProduct->rem_quantity : $product->quantity;
        
        // Get tax rate from taxes table
        if (!empty($product->tax)) {
            $tax = \DB::table('taxes')->where('id', $product->tax)->first();
            $product->tax_rate = $tax ? $tax->rate : 0;
            $product->tax_name = $tax ? $tax->name : '';
        } else {
            $product->tax_rate = 0;
            $product->tax_name = '';
        }
    }
    
    $html = view('purchase_returns.product_list', compact('products', 'purchase'))->render();
    
    return response()->json([
        'html' => $html,
        'purchase' => $purchase
    ]);
}

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    if (\Auth::user()->isAbleTo('purchase create')) {
        $validator = \Validator::make(
            $request->all(),
            [
                'purchase_id' => 'required',
                'return_date' => 'required|date',
                'items' => 'required',
            ]
        );
        
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        
        $purchase = Purchase::find($request->purchase_id);
        
        if (!$purchase || $purchase->created_by != creatorId() || $purchase->workspace != getActiveWorkSpace()) {
            return redirect()->back()->with('error', __('Purchase not found'));
        }
        
        // Create purchase return record
        $return = new PurchaseReturn();
        $return->return_id = $this->returnNumber();
        $return->purchase_id = $purchase->id;
        $return->vender_id = $purchase->vender_id;
        $return->user_id = $purchase->user_id;
        $return->vender_name = $purchase->vender_name;
        $return->warehouse_id = $purchase->warehouse_id;
        $return->return_date = $request->return_date;
        $return->return_number = $request->return_number;
        $return->return_reason = $request->return_reason;
        $return->status = 0; // Default: Pending
        $return->category_id = $purchase->category_id;
        $return->purchase_module = $purchase->purchase_module;
        $return->workspace = getActiveWorkSpace();
        $return->created_by = creatorId();
        $return->save();
        
        $products = $request->items;
        $totalAmount = 0;
        $totalTax = 0;
        
        for ($i = 0; $i < count($products); $i++) {
            if (isset($products[$i]['return_qty']) && $products[$i]['return_qty'] > 0) {
                // Get original purchase product details
                $purchaseProduct = PurchaseProduct::find($products[$i]['id']);
                
                if ($purchaseProduct && $purchaseProduct->purchase_id == $purchase->id) {
                    // Get the batch product to check remaining quantity
                    $batchProduct = PurchaseProductBatch::where('purchase_id', $purchase->id)
                        ->where('product_id', $purchaseProduct->product_id)
                        ->where('batch_no', $purchaseProduct->batch_no)
                        ->first();
                    
                    $remainingQty = $batchProduct ? $batchProduct->rem_quantity : $purchaseProduct->quantity;
                    
                    // Check if return quantity is valid against remaining quantity
                    if ($products[$i]['return_qty'] > $remainingQty) {
                        return redirect()->back()->with('error', __('Return quantity cannot be greater than remaining quantity'));
                    }
                    
                    // Get tax rate from taxes table
                    $taxRate = 0;
                    if (!empty($purchaseProduct->tax)) {
                        $tax = \DB::table('taxes')->where('id', $purchaseProduct->tax)->first();
                        $taxRate = $tax ? $tax->rate : 0;
                    }
                    
                    // Create return product record
                    $returnProduct = new PurchaseReturnProduct();
                    $returnProduct->return_id = $return->id;
                    $returnProduct->purchase_product_id = $purchaseProduct->id;
                    $returnProduct->product_id = $purchaseProduct->product_id;
                    $returnProduct->quantity = $products[$i]['return_qty'];
                    $returnProduct->price = $purchaseProduct->price;
                    $returnProduct->tax = $purchaseProduct->tax; // Store tax ID
                    $returnProduct->tax_rate = $taxRate; // Also store the tax rate for historical record
                    $returnProduct->discount = $purchaseProduct->discount;
                    $returnProduct->batch_no = $purchaseProduct->batch_no;
                    $returnProduct->description = $request->return_reason;
                    $returnProduct->workspace = getActiveWorkSpace();
                    $returnProduct->save();
                    
                    // Calculate total amount with proper tax calculation
                    $price = $purchaseProduct->price * $products[$i]['return_qty'];
                    $tax = ($price * $taxRate) / 100;
                    $subtotal = $price;
                    $discount = ($subtotal * $purchaseProduct->discount) / 100;
                    
                    $totalTax += $tax;
                    $totalAmount += ($subtotal - $discount);
                    
                    // Update inventory (quantity)
                    Purchase::total_quantity('minus', $products[$i]['return_qty'], $purchaseProduct->product_id);
                    
                    // Update Product Stock Report
                    if (module_is_active('Account')) {
                        $type = 'Purchase Return';
                        $type_id = $return->id;
                        $description = $products[$i]['return_qty'] . '  ' . __(' quantity returned from purchase') . ' ' . Purchase::purchaseNumberFormat($purchase->purchase_id);
                        Purchase::addProductStock($purchaseProduct->product_id, -$products[$i]['return_qty'], $type, $description, $type_id);
                    }
                    
                    // Update Warehouse Stock Report
                    if ($purchase->warehouse_id) {
                        Purchase::addWarehouseStock($purchaseProduct->product_id, -$products[$i]['return_qty'], $purchase->warehouse_id);
                    }
                    
                    // Update batch quantities if applicable
                    if ($batchProduct) {
                        $batchProduct->rem_quantity -= $products[$i]['return_qty'];
                        $batchProduct->save();
                    }
                }
            }
        }
        
        // Update total amount and tax in return record
        $return->total_amount = $totalAmount;
        $return->total_tax = $totalTax;
        $return->final_amount = $totalAmount + $totalTax;
       
        $return->save();
        
        return redirect()->route('purchase.returns.index')->with('success', __('Purchase return has been created successfully'));
    } else {
        return redirect()->back()->with('error', __('Permission denied.'));
    }
}





    /**
     * Display the specified resource.
     */
    public function show($ids)
    {
        if (\Auth::user()->isAbleTo('purchase show')) {
            try {
                $id = Crypt::decrypt($ids);
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', __('Purchase Return Not Found.'));
            }

            $return = PurchaseReturn::find($id);

            if (!$return || $return->created_by != creatorId() || $return->workspace != getActiveWorkSpace()) {
                return redirect()->back()->with('error', __('Permission denied.'));
            }

            $company_settings = getCompanyAllSetting();
            $vendor = [];
            if (module_is_active('Account')) {
                $vendor = $return->vender;
            }
            
            $purchase = Purchase::find($return->purchase_id);
            $items = $return->returnProducts;
            
            return view('purchase_returns.view', compact('return', 'purchase', 'vendor', 'items', 'company_settings'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource status.
     */
    public function updateStatus(Request $request, $id)
    {
        if (\Auth::user()->isAbleTo('purchase edit')) {
            $return = PurchaseReturn::find($id);
            
            if (!$return || $return->created_by != creatorId() || $return->workspace != getActiveWorkSpace()) {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
            
            $return->status = $request->status;
            $return->save();
            
            return redirect()->back()->with('success', __('Purchase return status updated successfully'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    
    public function paymentReturn($purchase_id)
    {
       if (\Auth::user()->isAbleTo('purchase payment create')) {
            $purchase = PurchaseReturn::where('id', $purchase_id)->first();
            $venders = \Workdo\Account\Entities\Vender::where('created_by', '=', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id');
               
            $categories = \Workdo\ProductService\Entities\Category::where('created_by', '=', creatorId())->where('workspace_id', getActiveWorkSpace())->get()->pluck('name', 'id');
            $accounts = \Workdo\Account\Entities\BankAccount::select(
                '*',
                \DB::raw("CONCAT(COALESCE(bank_name, ''), ' ', COALESCE(holder_name, '')) AS name")
            )
            ->where('created_by', creatorId())
            ->where('workspace', getActiveWorkSpace())
            ->get()
            ->pluck('name', 'id');

            return view('purchase_returns.payment', compact('venders', 'categories', 'accounts', 'purchase'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }
     public function createReturnPayment(Request $request, $purchase_id)
    {
       
        if (\Auth::user()->isAbleTo('purchase payment create')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'date' => 'required',
                    'amount' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            

            $purchasePayment = new PurchasePayment();

            if (module_is_active('Account')) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'account_id' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $purchasePayment->account_id = $request->account_id;
            }

            $purchasePayment->purchase_id = $purchase_id;
            $purchasePayment->date = $request->date;
            $purchasePayment->amount = $request->amount;
            $purchasePayment->account_id = $request->account_id;
            $purchasePayment->payment_method = 0;
            $purchasePayment->reference = $request->reference;
            $purchasePayment->description = $request->description;
            if (!empty($request->add_receipt)) {
                $fileName = time() . "_" . $request->add_receipt->getClientOriginalName();
                $uplaod = upload_file($request, 'add_receipt', $fileName, 'payment');
                if ($uplaod['flag'] == 1) {
                    $url = $uplaod['url'];
                } else {
                    return redirect()->back()->with('error', $uplaod['msg']);
                }
                $purchasePayment->add_receipt = $url;
            }
            $purchasePayment->save();

            $purchase = PurchaseReturn::where('id', $purchase_id)->first();
            // $due = $purchase->getDue();
            // $total = $purchase->getTotal();

            if ($purchase->status == 0) {
                $purchase->send_date = date('Y-m-d');
                $purchase->save();
            }
             $purchase->status = 1;
              $purchase->save();
            // if ($due <= 0) {
            //     $purchase->status = 4;
            //     $purchase->save();
            // } else {
            //     $purchase->status = 3;
            //     $purchase->save();
            // }
            if ($purchase->vender_name) {

                $purchasePayment->vendor_name = $purchase->vender_name;
            } else {
                $purchasePayment->user_id = $purchase->vender_id;
            }
            $purchasePayment->user_type = 'Vendor';
            $purchasePayment->type = 'Partial';
            $purchasePayment->created_by = \Auth::user()->id;
            $purchasePayment->payment_id = $purchasePayment->id;
            $purchasePayment->category = 'Purchase';
            $purchasePayment->account = $request->account_id;

            if (module_is_active('Account')) {
                \Workdo\Account\Entities\Transaction::addTransaction($purchasePayment);

                $vender_acc = \Workdo\Account\Entities\Vender::where('user_id', $purchase->vender_id)->first();
                if (empty($vender_acc)) {
                    $Vendor = $vender_acc;
                }
                \Workdo\Account\Entities\AccountUtility::userBalance('Vendor', $purchase->vender_id, $request->amount, 'credit');

                 \Workdo\Account\Entities\Transfer::bankAccountBalance($request->account_id, $request->amount, 'credit');
            }
            else
            {
                Purchase::userBalance('vendor', $purchase->vender_id, $request->amount, 'debit');
                Purchase::bankAccountBalance($request->account_id, $request->amount, 'debit'); 
            }

            $payment = new PurchasePayment();
            $payment->name = !empty($vender['name']) ? $purchasePayment->vendor_name : '';
            $payment->method = '-';
            $payment->date = company_date_formate($request->date);
            $payment->amount = currency_format_with_sym($request->amount);
            $payment->bill = 'purchase' . Purchase::purchaseNumberFormat($purchasePayment->purchase_id);

           

            if (!empty(company_setting('Purchase Payment Create')) && company_setting('Purchase Payment Create') == true) {
                $uArr = [
                    'payment_name' => $payment->name,
                    'payment_bill' => $payment->bill,
                    'payment_amount' => $payment->amount,
                    'payment_date' => $payment->date,
                    'payment_method' => $payment->method

                ];
                try {

                    $resp = EmailTemplate::sendEmailTemplate('Purchase Payment Create', [$vender_acc->id => $vender_acc->email], $uArr);
                } catch (\Exception $e) {
                    $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                }
            }

            event(new CreatePaymentPurchase($request, $payment,$purchase));
            return redirect()->back()->with('success', __('Payment successfully added.') . ((isset($smtp_error)) ? '<br> <span class="text-danger">' . $smtp_error . '</span>' : ''));
        }
    }
}
