<?php

namespace App\Http\Controllers;
use Workdo\Pos\Entities\Pos;
use Workdo\Pos\Entities\PosProduct;
use Illuminate\Http\Request;


use App\Models\PosReturn;
use App\Models\PosReturnProduct;
use App\Models\PosReturnPayment;
use App\Models\User;
use App\Models\Warehouse;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PosReturnController extends Controller
{
     /**
     * Show the list of returns
     */
    public function index()
    {
       
        if (\Auth::user()->isAbleTo('pos add manage')) {
            $returns = PosReturn::where('created_by', creatorId())
                ->where('workspace', getActiveWorkSpace())
                ->orderBy('id', 'desc')
                ->get();
           
            return view('pos::return.index', compact('returns'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
     /**
     * Show the sales to select for return
     */
    public function selectSale()
    {
        if (\Auth::user()->isAbleTo('pos add manage')) {
            $sales = Pos::where('created_by', creatorId())
                ->where('workspace', getActiveWorkSpace())
                ->orderBy('id', 'desc')
                ->get();
                
            
                
            return view('pos::return.select-sale', compact('sales'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    
     /**
     * Create a return form for the selected sale
     */
     
     
    // public function create($pos_id)
    // {
    //     if (\Auth::user()->isAbleTo('pos add manage')) {
    //         $pos = Pos::where('id', $pos_id)
    //             ->where('created_by', creatorId())
    //             ->where('workspace', getActiveWorkSpace())
    //             ->first();
                
    //         if (!$pos) {
    //             return redirect()->back()->with('error', __('Sale not found.'));
    //         }
           
            
    //         $posProducts = PosProduct::where('pos_id', $pos->id)->get();
    //         $customer = User::find($pos->customer_id);
    //         $warehouse = Warehouse::find($pos->warehouse_id);
            
    //         // Generate return number
    //          $returnId = $this->returnNumber();
            
    //         return view('pos::return.create', compact('pos', 'posProducts', 'customer', 'warehouse', 'returnId'));
    //     } else {
    //         return redirect()->back()->with('error', __('Permission denied.'));
    //     }
    // }
    
    public function create($pos_id)
{
    if (\Auth::user()->isAbleTo('pos add manage')) {
        $pos = Pos::where('id', $pos_id)
            ->where('created_by', creatorId())
            ->where('workspace', getActiveWorkSpace())
            ->first();
            
        if (!$pos) {
            return redirect()->back()->with('error', __('Sale not found.'));
        }
       
        $posProducts = PosProduct::where('pos_id', $pos->id)->get()->where('workspace', getActiveWorkSpace());
       
        $customer = User::find($pos->customer_id);
        $warehouse = Warehouse::find($pos->warehouse_id);
        
        // Get already returned quantities for each product
        $returnedQuantities = [];
        
        // Get all previous returns for this sale
        $previousReturns = PosReturn::where('pos_id', $pos->id)->pluck('id')->toArray();
        
        if (!empty($previousReturns)) {
            // Get all returned products and sum their quantities grouped by product_id and batch_no
            $returnedItems = PosReturnProduct::whereIn('return_id', $previousReturns)
                ->select(
                    'product_id', 
                    'batch_no',
                    DB::raw('SUM(quantity) as total_returned')
                )
                ->groupBy('product_id', 'batch_no')
                ->get();
                
            // Create a lookup array with product_id and batch_no as key
            foreach ($returnedItems as $item) {
                $key = $item->product_id . '-' . ($item->batch_no ?? 'null');
                $returnedQuantities[$key] = $item->total_returned;
            }
        }
        
        // Generate return number
        $returnId = $this->returnNumber();
        
        return view('pos::return.create', compact('pos', 'posProducts', 'customer', 'warehouse', 'returnId', 'returnedQuantities'));
    } else {
        return redirect()->back()->with('error', __('Permission denied.'));
    }
}

    
    
    
    
    
    
    
     /**
     * Store a newly created return
     */
    // public function store(Request $request)
    // {
    //     if (\Auth::user()->isAbleTo('pos add manage')) {
    //         // Validate request
    //         $request->validate([
    //             'pos_id' => 'required|exists:pos,id',
    //             'return_date' => 'required|date',
    //             'product_id' => 'required|array',
    //             'product_id.*' => 'required|exists:product_services,id',
    //             'quantity' => 'required|array',
    //             'quantity.*' => 'required|numeric|min:1',
    //         ]);
            
    //         $pos = Pos::find($request->pos_id);
    //         if (!$pos) {
    //             return redirect()->back()->with('error', __('Sale not found.'));
    //         }
            
    //         DB::beginTransaction();
    //         try {
    //             // Create return record
    //             $return = new PosReturn();
    //             $return->return_id = $this->returnNumber();
    //             $return->pos_id = $pos->id;
    //             $return->customer_id = $pos->customer_id;
    //             $return->warehouse_id = $pos->warehouse_id;
    //             $return->return_date = $request->return_date;
    //             $return->note = $request->note;
    //             $return->workspace = getActiveWorkSpace();
    //             $return->created_by = creatorId();
    //             $return->save();
                
    //             $totalAmount = 0;
                
    //             // Process returned products
    //             foreach ($request->product_id as $key => $productId) {
    //                 // Get the original POS product
    //                 $posProduct = PosProduct::where('pos_id', $pos->id)
    //                     ->where('product_id', $productId)
    //                     ->where('batch_no', $request->batch_no[$key] ?? null)
    //                     ->first();
                    
    //                 if (!$posProduct) {
    //                     throw new \Exception('Product not found in the original sale.');
    //                 }
                    
    //                 $returnQty = $request->quantity[$key];
                    
    //                 if ($returnQty > $posProduct->quantity) {
    //                     throw new \Exception('Return quantity cannot exceed the sold quantity.');
    //                 }
                    
    //                 // Calculate amount
    //                 $productPrice = $posProduct->price;
    //                 $amount = $productPrice * $returnQty;
    //                 $totalAmount += $amount;
                    
    //                 // Create return product record
    //                 $returnProduct = new PosReturnProduct();
    //                 $returnProduct->return_id = $return->id;
    //                 $returnProduct->product_id = $productId;
    //                 $returnProduct->price = $productPrice;
    //                 $returnProduct->original_price = $posProduct->original_price;
    //                 $returnProduct->quantity = $returnQty;
    //                 $returnProduct->tax = $posProduct->tax;
    //                 $returnProduct->discount = isset($request->discount[$key]) ? $request->discount[$key] : 0;
    //                 $returnProduct->batch_no = $posProduct->batch_no;
    //                 $returnProduct->workspace = getActiveWorkSpace();
    //                 $returnProduct->save();
                    
    //                 // Update product inventory
    //                 $product = \Workdo\ProductService\Entities\ProductService::find($productId);
    //                 if ($product) {
    //                     $product->quantity += $returnQty;
    //                     $product->save();
    //                 }
                    
    //                 // Update warehouse quantity
    //                 $this->updateWarehouseQuantity('plus', $returnQty, $productId, $pos->warehouse_id);
                    
    //                 // Handle FIFO for batch - restock to the appropriate batch
    //                 if (!empty($posProduct->batch_no)) {
    //                     $batch = DB::table('purchase_product_batches')
    //                         ->where('product_id', $productId)
    //                         ->where('batch_no', $posProduct->batch_no)
    //                         ->where('workspace', getActiveWorkSpace())
    //                         ->first();
                        
    //                     if ($batch) {
    //                         DB::table('purchase_product_batches')
    //                             ->where('id', $batch->id)
    //                             ->update(['rem_quantity' => DB::raw("rem_quantity + $returnQty")]);
    //                     } else {
    //                         // If batch doesn't exist, create a new batch entry
    //                         DB::table('purchase_product_batches')->insert([
    //                             'product_id' => $productId,
    //                             'batch_no' => $posProduct->batch_no,
    //                             'quantity' => $returnQty,
    //                             'rem_quantity' => $returnQty,
    //                             'workspace' => getActiveWorkSpace(),
    //                             'created_at' => now(),
    //                             'updated_at' => now()
    //                         ]);
    //                     }
    //                 }
                    
    //                 // Add Stock Report if Account module is active
    //                 if (module_is_active('Account')) {
    //                     $type = 'PosReturn';
    //                     $type_id = $return->id;
    //                     $description = $returnQty . ' ' . __('quantity returned in POS return') . ' ' . PosReturn::returnNumberFormat($return->return_id);
    //                     $this->addReturnProductStock($productId, $returnQty, $type, $description, $type_id);
    //                 }
    //             }
                
    //             // Create payment record for the return
    //             $returnPayment = new PosReturnPayment();
    //             $returnPayment->return_id = $return->id;
    //             $returnPayment->date = $request->return_date;
    //             $returnPayment->amount = $totalAmount;
    //             $returnPayment->discount = isset($request->discount_amount) ? $request->discount_amount : 0;
    //             $returnPayment->discount_amount = $totalAmount - (isset($request->discount_amount) ? $request->discount_amount : 0);
    //             $returnPayment->payment_method = $request->payment_method ?? 'Cash';
    //             $returnPayment->reference = $request->reference;
    //             $returnPayment->description = $request->payment_note;
    //             $returnPayment->workspace = getActiveWorkSpace();
    //             $returnPayment->created_by = creatorId();
    //             $returnPayment->save();
                
    //             // Fire event for payment return (if needed)
    //             // event(new CreatePaymentPosReturn($request, $returnPayment, $return));
                
    //             DB::commit();
                
    //             return redirect()->route('pos.return.index')->with('success', __('Return created successfully.'));
                
    //         } catch (\Exception $e) {
    //             DB::rollBack();
    //             return redirect()->back()->with('error', $e->getMessage());
    //         }
    //     } else {
    //         return redirect()->back()->with('error', __('Permission denied.'));
    //     }
    // }
    
    
    
    
  public function store(Request $request)
    {
        
        if (\Auth::user()->isAbleTo('pos add manage')) {
           
            $request->validate([
                'pos_id' => 'required|exists:pos,id',
                'return_date' => 'required|date',
                'product_id' => 'required|array',
                'product_id.*' => 'required|exists:product_services,id',
                'quantity' => 'required|array',
                'quantity.*' => 'required|numeric|min:0',
            ]);
            
            $pos = Pos::find($request->pos_id);
            if (!$pos) {
                return redirect()->back()->with('error', __('Sale not found.'));
            }
            
            // Get previously returned quantities for validation
            $previousReturns = PosReturn::where('pos_id', $pos->id)->pluck('id')->toArray();
            $returnedQuantities = [];
            
            if (!empty($previousReturns)) {
                $returnedItems = PosReturnProduct::whereIn('return_id', $previousReturns)
                    ->select(
                        'product_id', 
                        'batch_no',
                        DB::raw('SUM(quantity) as total_returned')
                    )
                    ->groupBy('product_id', 'batch_no')
                    ->get();
                    
                foreach ($returnedItems as $item) {
                    $key = $item->product_id . '-' . ($item->batch_no ?? 'null');
                    $returnedQuantities[$key] = $item->total_returned;
                }
            }
            
            // First, collect valid items to be returned
            $validItems = [];
            $totalAmount = 0;
            
            // Pre-process all items - THIS IS CRITICAL
            for ($i = 0; $i < count($request->product_id); $i++) {
                // Skip if index doesn't exist in quantity array
                if (!isset($request->quantity[$i])) {
                    continue;
                }
                
                $productId = $request->product_id[$i];
                $returnQty = floatval($request->quantity[$i]);
                $batchNo = isset($request->batch_no[$i]) ? $request->batch_no[$i] : null;
                
                // Skip if quantity is zero
                if ($returnQty <= 0) {
                    continue;
                }
                
                // Get the original POS product
                $posProduct = PosProduct::where('pos_id', $pos->id)
                    ->where('product_id', $productId)
                    ->where('batch_no', $batchNo)
                    ->first();
                
                if (!$posProduct) {
                    return redirect()->back()->with('error', __('Product not found in the original sale.'));
                }
                
                $productKey = $productId . '-' . ($batchNo ?? 'null');
                $alreadyReturnedQty = isset($returnedQuantities[$productKey]) ? $returnedQuantities[$productKey] : 0;
                $maxReturnableQty = $posProduct->quantity - $alreadyReturnedQty;
                
                if ($returnQty > $maxReturnableQty) {
                    return redirect()->back()->with('error', __("Return quantity for product ID $productId cannot exceed the available quantity ($maxReturnableQty)."));
                }
                
                // This item is valid - add to our processing list
                $validItems[] = [
                    'product_id' => $productId,
                    'batch_no' => $batchNo,
                    'quantity' => $returnQty,
                    'pos_product' => $posProduct,
                    'discount' => isset($request->discount[$i]) ? $request->discount[$i] : 0
                ];
                
                // Add to total amount
                $taxPerItem = 0;
                if ($posProduct->quantity > 0) {
                    $taxPerItem = $posProduct->tex_price / $posProduct->quantity;
                }
                
                // Add to total amount - multiply tax per item by the return quantity
                $totalAmount += ($posProduct->price * $returnQty) + ($taxPerItem * $returnQty);
            }
            
            // Check if we have any valid returns
            if (empty($validItems)) {
                return redirect()->back()->with('error', __('No valid products selected for return.'));
            }
            
            DB::beginTransaction();
            try {
                // Create return record
                $return = new PosReturn();
                $return->return_id = $this->returnNumber();
                $return->pos_id = $pos->id;
                $return->customer_id = $pos->customer_id;
                $return->warehouse_id = $pos->warehouse_id;
                $return->return_date = $request->return_date;
                $return->note = $request->note;
                $return->workspace = getActiveWorkSpace();
                $return->created_by = creatorId();
                $return->save();
                
                // Process each valid item
                foreach ($validItems as $item) {
                    $productId = $item['product_id'];
                    $returnQty = $item['quantity'];
                    $posProduct = $item['pos_product'];
                    $batchNo = $item['batch_no'];
                    
                    // Create return product record
                    $returnProduct = new PosReturnProduct();
                    $returnProduct->return_id = $return->id;
                    $returnProduct->product_id = $productId;
                    $returnProduct->price = $posProduct->price;
                    $returnProduct->original_price = $posProduct->original_price;
                    $returnProduct->quantity = $returnQty;
                    $returnProduct->t_quantity = $posProduct->quantity;
                    $returnProduct->tax = $posProduct->tex_price;
                    $returnProduct->discount = $item['discount'];
                    $returnProduct->batch_no = $posProduct->batch_no;
                    $returnProduct->workspace = getActiveWorkSpace();
                    $returnProduct->save();
                    
                    // Update product inventory
                    $product = \Workdo\ProductService\Entities\ProductService::find($productId);
                    if ($product) {
                        $product->quantity += $returnQty;
                        $product->save();
                    }
                    
                    // Update warehouse quantity
                    $this->updateWarehouseQuantity('plus', $returnQty, $productId, $pos->warehouse_id);
                    
                    // Handle FIFO for batch - restock to the appropriate batch
                    if (!empty($posProduct->batch_no)) {
                        $batch = DB::table('purchase_product_batches')
                            ->where('product_id', $productId)
                            ->where('batch_no', $posProduct->batch_no)
                            ->where('workspace', getActiveWorkSpace())
                            ->first();
                        
                        if ($batch) {
                            DB::table('purchase_product_batches')
                                ->where('id', $batch->id)
                                ->update(['rem_quantity' => DB::raw("rem_quantity + $returnQty")]);
                        } else {
                            // If batch doesn't exist, create a new batch entry
                            DB::table('purchase_product_batches')->insert([
                                'product_id' => $productId,
                                'batch_no' => $posProduct->batch_no,
                                'quantity' => $returnQty,
                                'rem_quantity' => $returnQty,
                                'workspace' => getActiveWorkSpace(),
                                'created_at' => now(),
                                'updated_at' => now()
                            ]);
                        }
                    }
                    
                    // Add Stock Report if Account module is active
                    if (module_is_active('Account')) {
                        $type = 'PosReturn';
                        $type_id = $return->id;
                        $description = $returnQty . ' ' . __('quantity returned in POS return') . ' ' . PosReturn::returnNumberFormat($return->return_id);
                        $this->addReturnProductStock($productId, $returnQty, $type, $description, $type_id);
                    }
                }
                
                // Create payment record for the return
                $returnPayment = new PosReturnPayment();
                $returnPayment->return_id = $return->id;
                $returnPayment->date = $request->return_date;
                $returnPayment->amount = $totalAmount;
                $returnPayment->discount = isset($request->discount_amount) ? $request->discount_amount : 0;
                $returnPayment->discount_amount = $totalAmount - (isset($request->discount_amount) ? $request->discount_amount : 0);
                $returnPayment->payment_method = $request->payment_method ?? 'Cash';
                $returnPayment->reference = $request->reference;
                $returnPayment->description = $request->payment_note;
                $returnPayment->workspace = getActiveWorkSpace();
                $returnPayment->created_by = creatorId();
                $returnPayment->save();
                
                DB::commit();
                
                return redirect()->route('pos.return.index')->with('success', __('Return created successfully.'));
                
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    /**
     * Display the specified return
     */
    public function show($id)
    {
        if (\Auth::user()->isAbleTo('pos show')) {
            $return = PosReturn::where('id', $id)
                ->where('created_by', creatorId())
                ->where('workspace', getActiveWorkSpace())
                ->first();
                
            if (!$return) {
                return redirect()->back()->with('error', __('Return not found.'));
            }
            
            $returnProducts = PosReturnProduct::where('return_id', $return->id)->get();
            $customer = User::find($return->customer_id);
            $warehouse = warehouse::find($return->warehouse_id);
            $returnPayment = PosReturnPayment::where('return_id', $return->id)->first();
            
            return view('pos::return.show', compact('return', 'returnProducts', 'customer', 'warehouse', 'returnPayment'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    
    /**
     * Generate a unique return number
     */
    private function returnNumber()
    {
        $latest = PosReturn::where('created_by', creatorId())
            ->where('workspace', getActiveWorkSpace())
            ->latest()
            ->first();
            
        if ($latest) {
            $number = intval(substr($latest->return_id, -5)) + 1;
        } else {
            $number = 1;
        }
        
        return PosReturn::returnNumberFormat($number);
    }
    
    /**
     * Update warehouse quantity
     */
    private function updateWarehouseQuantity($type, $quantity, $product_id, $warehouse_id)
    {
        $warehouse_product = DB::table('warehouse_products')
            ->where('warehouse_id', $warehouse_id)
            ->where('product_id', $product_id)
            ->where('workspace', getActiveWorkSpace())
            ->first();
            
        if ($warehouse_product) {
            $new_quantity = $type == 'plus' ? 
                $warehouse_product->quantity + $quantity : 
                $warehouse_product->quantity - $quantity;
                
            DB::table('warehouse_products')
                ->where('id', $warehouse_product->id)
                ->update(['quantity' => $new_quantity]);
        } else if ($type == 'plus') {
            // Only create a new entry if we're adding stock
            DB::table('warehouse_products')->insert([
                'warehouse_id' => $warehouse_id,
                'product_id' => $product_id,
                'quantity' => $quantity,
                'workspace' => getActiveWorkSpace(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
    
    /**
     * Add return product stock record
     */
    private function addReturnProductStock($product_id, $quantity, $type, $description, $type_id)
    {
        if (module_is_active('Account')) {
            // First clean up any existing records for this return to avoid duplicates
            \Workdo\Account\Entities\StockReport::where('type', $type)
                ->where('type_id', $type_id)
                ->where('product_id', $product_id)
                ->delete();
                
            // Then add the new stock record
            $stock = new \Workdo\Account\Entities\StockReport();
            $stock->product_id = $product_id;
            $stock->quantity = $quantity;
            $stock->type = $type;
            $stock->type_id = $type_id;
            $stock->description = $description;
            $stock->workspace = getActiveWorkSpace();
            $stock->created_by = creatorId();
            $stock->save();
        }
    }
    
}
