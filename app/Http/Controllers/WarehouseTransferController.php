<?php

namespace App\Http\Controllers;

use App\DataTables\WarehouseTransferDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Workdo\Pos\Entities\Pos;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;
use App\Models\WarehouseTransfer;
use App\Models\WorkSpace;
use App\Models\WorkspaceTransfer;
use App\Models\WorkspaceTransferProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Workdo\ProductService\Entities\ProductService;
use Illuminate\Support\Facades\Auth;
use Workdo\ProductService\Entities\Category;
use Workdo\ProductService\Entities\Tax;
use Workdo\ProductService\Entities\Unit;
use Workdo\ProductService\Entities\Discount;
class WarehouseTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(WarehouseTransferDataTable $dataTable)
    {
        return $dataTable->render('warehouses-transfer.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $from_warehouses      = Warehouse ::where('created_by', '=', creatorId())->where('workspace',getActiveWorkSpace())->get()->pluck('name', 'id');
        $to_warehouses     = warehouse::where('created_by', '=', creatorId())->where('workspace',getActiveWorkSpace())->get()->pluck('name', 'id');
        $to_warehouses->prepend('Select Warehouse', '');
         $from_warehouses->prepend('Select Warehouse', '');
        $ware_pro= WarehouseProduct::join('product_services', 'warehouse_products.product_id', '=', 'product_services.id')
            ->pluck('name','product_id');
        $ware_pro->prepend('Select products', '');
        return view('warehouses-transfer.create', compact('from_warehouses','to_warehouses','ware_pro'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        if(\Auth::user()->isAbleTo('warehouse create'))
        {

            $validator = \Validator::make(
                $request->all(), [
                    'from_warehouse' => 'required',
                    'to_warehouse' => 'required',
                    'product_id' => 'required',
                    'quantity' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $fromWarehouse    = WarehouseProduct::where('warehouse_id',$request->from_warehouse)
                ->where('product_id',$request->product_id)->first();

            if($request->quantity <= $fromWarehouse->quantity)
            {
                $warehouse_transfer                  = new WarehouseTransfer();
                $warehouse_transfer->from_warehouse  = $request->from_warehouse;
                $warehouse_transfer->to_warehouse    = $request->to_warehouse;
                $warehouse_transfer->product_id      = $request->product_id;
                $warehouse_transfer->quantity        = $request->quantity;
                $warehouse_transfer->date            = $request->date;
                $warehouse_transfer->workspace       = getActiveWorkSpace();
                $warehouse_transfer->created_by      = creatorId();
                $warehouse_transfer->save();
            }
            else
            {
                return redirect()->route('warehouses-transfer.index')->with('error', __('Product out of stock!.'));
            }
            WarehouseTransfer::warehouse_transfer_qty($request->from_warehouse,$request->to_warehouse,$request->product_id,$request->quantity);

            return redirect()->route('warehouses-transfer.index')->with('success', __('The warehouse transfer has been created successfully'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function getproduct(Request $request)
    {
        if($request->warehouse_id == 0)
        {
            $ware_products= WarehouseProduct::join('product_services', 'warehouse_products.product_id', '=', 'product_services.id')
                ->get()
                ->pluck('name', 'product_id')->toArray();
            $to_warehouses     = warehouse::where('created_by', '=', creatorId())->where('workspace',getActiveWorkSpace())->pluck('name', 'id');
        }
        else
        {
            $ware_products= WarehouseProduct::join('product_services', 'warehouse_products.product_id', '=', 'product_services.id')
                ->where('warehouse_products.warehouse_id', $request->warehouse_id)
                ->get()
                ->pluck('name', 'product_id')->toArray();
            $to_warehouses     = warehouse::where('id','!=',$request->warehouse_id)->where('created_by', '=', creatorId())->where('workspace',getActiveWorkSpace())->pluck('name', 'id');
        }
        $result = [];
        $result['ware_products'] = $ware_products;
        $result['to_warehouses'] = $to_warehouses;
        return response()->json($result);
    }

    public function getquantity(Request $request)
    {
       
        if($request->product_id == 0)
        {
            $pro_qty = WarehouseProduct::where('created_by', '=', creatorId())->where('workspace',getActiveWorkSpace())
                ->get()->pluck('quantity', 'product_id')->toArray();
        }
        else
        {
            // $pro_qty = WarehouseProduct::where('created_by', '=', creatorId())->where('workspace',getActiveWorkSpace())
            //     ->where('product_id', $request->product_id)
            //     ->get()->pluck('quantity');
                $pro_qty = WarehouseProduct::where('created_by', creatorId())
                    ->where('workspace', getActiveWorkSpace())
                    ->where('product_id', $request->product_id)
                    ->when($request->warehouse_id, function ($query, $warehouse_id) {
                        return $query->where('warehouse_id', $warehouse_id);
                    })
                    ->pluck('quantity');
        }
        
       
        return response()->json($pro_qty);
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return redirect()->route('warehouses-transfer.index');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('pos::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */


    public function destroy($id)
    {
        if(\Auth::user()->isAbleTo('warehouse delete'))
        {
            $warehouseTransfer = WarehouseTransfer::find($id);
            if($warehouseTransfer->created_by == creatorId()  && $warehouseTransfer->workspace == getActiveWorkSpace())
            {
                WarehouseTransfer::warehouse_transfer_qty($warehouseTransfer->to_warehouse,$warehouseTransfer->from_warehouse,$warehouseTransfer->product_id,$warehouseTransfer->quantity,'delete');

                $warehouseTransfer->delete();

                return redirect()->route('warehouses-transfer.index')->with('success', __('The warehouse Transfer has been deleted'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    
    public function getWorkspace()
    {
        
        $query = DB::table('workspace_transfers as wt')
                    ->join('work_spaces as from_ws', 'wt.workspace', '=', 'from_ws.id')
                    ->join('work_spaces as to_ws', 'wt.to_workspace', '=', 'to_ws.id')
                    ->join('warehouses as from_wh', 'wt.from_warehouse', '=', 'from_wh.id')
                    ->leftjoin('warehouses as to_wh', 'wt.to_warehouse', '=', 'to_wh.id')
                    ->leftJoin('workspace_transfer_products as wtp', 'wt.id', '=', 'wtp.workspace_transfer_id')
                    ->select([
                        'wt.*',
                        'from_ws.name as from_workspace_name',
                        'to_ws.name as to_workspace_name',
                        'from_wh.name as from_warehouse_name',
                        'to_wh.name as to_warehouse_name',
                        DB::raw('COUNT(wtp.id) as product_count'),
                        DB::raw('SUM(wtp.quantity) as total_quantity')
                    ])
                    ->where('wt.workspace', getActiveWorkSpace())
                    ->groupBy([
                        'wt.id',
                        'wt.workspace',
                        'wt.to_workspace',
                        'wt.from_warehouse',
                        'wt.to_warehouse',
                        'wt.created_at',
                        'wt.updated_at',
                        'from_ws.name',
                        'to_ws.name',
                        'from_wh.name',
                        'to_wh.name'
                    ]);
        
           $transfers = $query->orderBy('wt.created_at', 'desc')->paginate(15);
        //   return  $transfers ;
        return view('workspace-transfer.index',compact('transfers'));
    }
    public function transferProducts()
    {
        $workspaces = WorkSpace::where('created_by', '=', creatorId())->get()->pluck('name', 'id');
        $workspaces->prepend('Select Workspace', '');
        
        // Get warehouses for current workspace
        $from_warehouses = Warehouse::where('created_by', '=', creatorId())
            ->where('workspace', getActiveWorkSpace())
            ->get()
            ->pluck('name', 'id');
        
        $to_warehouses = Warehouse::where('created_by', '=', creatorId())
            ->where('workspace', getActiveWorkSpace())
            ->get()
            ->pluck('name', 'id');
        
        $to_warehouses->prepend('Select Warehouse', '');
        $from_warehouses->prepend('Select Warehouse', '');
        $ware_pro = collect(); 
        // $ware_pro = WarehouseProduct::join('product_services', 'warehouse_products.product_id', '=', 'product_services.id')
        //     ->pluck('name','product_id');
        $ware_pro->prepend('Select products', '');
        return view('workspace-transfer.transfer-products', compact('from_warehouses','to_warehouses','ware_pro','workspaces'));
    }
    
    public function getWarehousesByWorkspace(Request $request)
    {
        $workspace_id = $request->workspace_id;
        
        if($workspace_id == 0) {
            $warehouses = [];
        } else {
            $warehouses = Warehouse::where('created_by', '=', creatorId())
                ->where('workspace', $workspace_id)
                ->pluck('name', 'id')
                ->toArray();
        }
        
        return response()->json($warehouses);
    }
    //  public function storeWorkspaceProduct(Request $request)
    // {
        
    //     $validator = Validator::make($request->all(), [
    //         'from_warehouse' => 'required|integer',
    //         'to_workspace' => 'required|integer',
    //         'date' => 'required|date',
    //         'products' => 'required|array|min:1',
    //         'products.*.product_id' => 'required|integer',
    //         'products.*.quantity' => 'required|integer|min:1',
    //         'notes' => 'nullable|string|max:1000'
    //     ]);

    //     if ($validator->fails()) {
    //         $messages = $validator->getMessageBag();
    //             return redirect()->back()->with('error', $messages->first());
    //         // return response()->json([
    //         //     'success' => false,
    //         //     'message' => 'Validation failed',
    //         //     'errors' => $validator->errors()
    //         // ], 422);
    //     }

    //     DB::beginTransaction();

    //     try {
    //         // Create workspace transfer
    //         $transfer = WorkspaceTransfer::create([
    //             'from_warehouse' => $request->from_warehouse,
    //             'to_workspace' => $request->to_workspace,
    //             'to_warehouse' => $request->to_warehouse,
    //             'date' => $request->date,
    //             'status' => 'pending',
    //             'notes' => $request->notes,
    //             'workspace' => getActiveWorkSpace(),
    //             'created_by' => creatorId()
                
    //         ]);
               
    //         // Group products by product_id and sum quantities
    //         $productGroups = collect($request->products)->groupBy('product_id');
            
    //         foreach ($productGroups as $productId => $products) {
    //             $totalQuantity = $products->sum('quantity');
                
    //             WorkspaceTransferProduct::create([
    //                 'workspace_transfer_id' => $transfer->id,
    //                 'product_id' => $productId,
    //                 'quantity' => $totalQuantity
    //             ]);
    //         }

    //         DB::commit();
    //         return redirect()->route('workspace-transfer.index')->with('success', 'Workspace transfer created successfully');
            

    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         // return redirect()->back()->with('success', 'Failed to create workspace transfer');
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to create workspace transfer',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    
    // }
    public function storeWorkspaceProduct(Request $request)
{
    $validator = Validator::make($request->all(), [
        'from_warehouse' => 'required|integer',
        'to_workspace' => 'required|integer',
        'date' => 'required|date',
        'products' => 'required|array|min:1',
        'products.*.product_id' => 'required|integer',
        'products.*.quantity' => 'required|integer|min:1',
        'notes' => 'nullable|string|max:1000'
    ]);

    if ($validator->fails()) {
        $messages = $validator->getMessageBag();
        return redirect()->back()->with('error', $messages->first());
    }

    DB::beginTransaction();

    try {
        // Create workspace transfer
        $transfer = WorkspaceTransfer::create([
            'from_warehouse' => $request->from_warehouse,
            'to_workspace' => $request->to_workspace,
            'to_warehouse' => $request->to_warehouse,
            'date' => $request->date,
            'status' => 'pending',
            'notes' => $request->notes,
            'workspace' => getActiveWorkSpace(),
            'created_by' => creatorId()
        ]);

        // Group products by product_id and sum quantities
        $productGroups = collect($request->products)->groupBy('product_id');

        foreach ($productGroups as $productId => $products) {
            $totalQuantity = $products->sum('quantity');

            WorkspaceTransferProduct::create([
                'workspace_transfer_id' => $transfer->id,
                'product_id' => $productId,
                'quantity' => $totalQuantity
            ]);

            // Decrease quantity from from_warehouse stock
            $fromWarehouse = WarehouseProduct::where('warehouse_id', $request->from_warehouse)
                ->where('product_id', $productId)
                ->first();

            if (!empty($fromWarehouse)) {
                $fromWarehouse->quantity -= $totalQuantity;
                
                if ($fromWarehouse->quantity <= 0) {
                    $fromWarehouse->quantity = 0;
                    
                } 
                $fromWarehouse->save();
            }
            $product = ProductService::find($productId);
            if ($product) {
                $product->quantity -= $totalQuantity;
                if ($product->quantity <= 0) {
                    $product->quantity = 0; // Optional: or delete if you want
                }
                $product->save();
            }
        }

        DB::commit();
        return redirect()->route('workspace-transfer.index')->with('success', 'Workspace transfer created successfully');

    } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
            'success' => false,
            'message' => 'Failed to create workspace transfer',
            'error' => $e->getMessage()
        ], 500);
    }
}

    
    public function transferProductShow($id)
    {
        
        $query = DB::table('workspace_transfer_products as wtp')
                    ->join('product_services as product', 'wtp.product_id', '=', 'product.id')
                    ->select([
                        'wtp.*',
                        'product.name as name',
                        'product.purchase_price as price'
                        
                    ])
                    ->where('wtp.workspace_transfer_id', $id);
           $transfers = $query->orderBy('wtp.created_at', 'desc')->paginate(15);
        return view('workspace-transfer.product-details',compact('transfers'));
    }
    
    public function transferProductReceive()
    {
        $query = DB::table('workspace_transfers as wt')
                    ->join('work_spaces as from_ws', 'wt.workspace', '=', 'from_ws.id')
                    ->join('work_spaces as to_ws', 'wt.to_workspace', '=', 'to_ws.id')
                    ->join('warehouses as from_wh', 'wt.from_warehouse', '=', 'from_wh.id')
                    ->leftJoin('warehouses as to_wh', 'wt.to_warehouse', '=', 'to_wh.id')
                    ->leftJoin('workspace_transfer_products as wtp', 'wt.id', '=', 'wtp.workspace_transfer_id')
                    ->select([
                        'wt.*',
                        'from_ws.name as from_workspace_name',
                        'to_ws.name as to_workspace_name',
                        'from_wh.name as from_warehouse_name',
                        'to_wh.name as to_warehouse_name',
                        DB::raw('COUNT(wtp.id) as product_count'),
                        DB::raw('SUM(wtp.quantity) as total_quantity')
                    ])
                    ->where('wt.to_workspace', getActiveWorkSpace())
                    ->groupBy([
                        'wt.id',
                        'wt.workspace',
                        'wt.to_workspace',
                        'wt.from_warehouse',
                        'wt.to_warehouse',
                        'wt.created_at',
                        'wt.updated_at',
                        'from_ws.name',
                        'to_ws.name',
                        'from_wh.name',
                        'to_wh.name'
                    ]);
        
           $transfers = $query->orderBy('wt.created_at', 'desc')->paginate(15);
        //   return  $transfers ;
        return view('workspace-transfer.product-receive',compact('transfers'));
    }
    
    public function transferProductReceiveShow($id)
    {
        
        $query = DB::table('workspace_transfer_products as wtp')
                    ->join('product_services as product', 'wtp.product_id', '=', 'product.id')
                    ->select([
                        'wtp.*',
                        'product.name as name',
                        'product.purchase_price as price',
                         'product.sku as sku'
                        
                    ])
                    ->where('wtp.workspace_transfer_id', $id);
           $transfers = $query->orderBy('wtp.created_at', 'desc')->paginate(15);
           $warehouses =  Warehouse::where('created_by', '=', creatorId())->where('workspace', getActiveWorkSpace())->get();
        return view('workspace-transfer.receive-product-details',compact('transfers', 'warehouses'));
    }
    
    public function storeReceiveWorkspaceProduct(Request $request)
    {
    // Check permission
    

    $validator = Validator::make($request->all(), [
        'warehouse_id' => 'required|integer',
        'transfer_date' => 'required|date',
        'selected_products' => 'required|array|min:1',
        'selected_products.*' => 'required|integer',
        'notes' => 'nullable|string|max:1000'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->getMessageBag()->first()
        ], 400);
    }

    DB::beginTransaction();
    try {
        $user = Auth::user();
        $currentWorkspace = getActiveWorkSpace();
        $creatorId = creatorId();
        
        $successCount = 0;
        $failedProducts = [];
        
        foreach ($request->selected_products as $transferId) {
            // Get the workspace transfer product
            $transferProduct = WorkspaceTransferProduct::with(['workspaceTransfer', 'product'])
                ->where('id', $transferId)
                ->whereHas('workspaceTransfer', function($query) use ($currentWorkspace) {
                    $query->where('to_workspace', $currentWorkspace)
                          ->where('status', 'pending');
                })
                ->first();
            
            if (!$transferProduct) {
                $failedProducts[] = "Transfer product ID: {$transferId} not found or already processed";
                continue;
            }
            
            $originalProduct = $transferProduct->product;
            if (!$originalProduct) {
                $failedProducts[] = "Original product not found for transfer ID: {$transferId}";
                continue;
            }
            
            try {
                // Check if product already exists in current workspace
                $existingProduct = ProductService::where('name', $originalProduct->name)
                    ->where('workspace_id', $currentWorkspace)
                    ->where('created_by', $creatorId)
                    ->first();
                
                if ($existingProduct) {
                    // Update existing product quantity
                    $existingProduct->quantity += $transferProduct->quantity;
                    $existingProduct->save();
                    
                    // Update or create warehouse product record
                    $warehouseProduct = WarehouseProduct::where('warehouse_id', $request->warehouse_id)
                        ->where('product_id', $existingProduct->id)
                        ->first();
                    
                    if ($warehouseProduct) {
                        $warehouseProduct->quantity += $transferProduct->quantity;
                        $warehouseProduct->save();
                    } else {
                        WarehouseProduct::create([
                            'warehouse_id' => $request->warehouse_id,
                            'product_id' => $existingProduct->id,
                            'quantity' => $transferProduct->quantity,
                            'created_by' => $creatorId,
                            'workspace' => $currentWorkspace
                        ]);
                    }
                } else {
                    // Create new product in current workspace
                    
                    // Get related data from original workspace
                    $tax = null;
                    if ($originalProduct->tax_id) {
                        $originalTax = Tax::find($originalProduct->tax_id);
                        if ($originalTax) {
                            $tax = Tax::firstOrCreate([
                                'name' => $originalTax->name,
                                'workspace_id' => $currentWorkspace
                            ], [
                                'rate' => $originalTax->rate,
                                'created_by' => $creatorId
                            ]);
                        }
                    }
                    
                    // Handle Category
                    $category = null;
                    if ($originalProduct->category_id) {
                        $originalCategory = Category::find($originalProduct->category_id);
                        if ($originalCategory) {
                            $category = Category::firstOrCreate([
                                'name' => $originalCategory->name,
                                'workspace_id' => $currentWorkspace,
                                'type' => 0
                            ], [
                                'created_by' => $creatorId
                            ]);
                        }
                    }
                    
                    // Handle Brand
                    $brand = null;
                    if ($originalProduct->brand_id) {
                        $originalBrand = Category::find($originalProduct->brand_id);
                        if ($originalBrand) {
                            $brand = Category::firstOrCreate([
                                'name' => $originalBrand->name,
                                'workspace_id' => $currentWorkspace,
                                'type' => 3
                            ], [
                                'created_by' => $creatorId
                            ]);
                        }
                    }
                    
                    // Handle Unit
                    $unit = null;
                    if ($originalProduct->unit_id) {
                        $originalUnit = Unit::find($originalProduct->unit_id);
                        if ($originalUnit) {
                            $unit = Unit::firstOrCreate([
                                'name' => $originalUnit->name,
                                'workspace_id' => $currentWorkspace
                            ], [
                                'created_by' => $creatorId
                            ]);
                        }
                    }
                    
                    // Handle Discount
                    $discount = null;
                    if ($originalProduct->discount_id) {
                        $originalDiscount = Discount::find($originalProduct->discount_id);
                        if ($originalDiscount) {
                            $discount = Discount::firstOrCreate([
                                'title' => $originalDiscount->title,
                                'workspace_id' => $currentWorkspace
                            ], [
                                'discount' => $originalDiscount->discount,
                                'created_by' => $creatorId
                            ]);
                        }
                    }
                    
                    // Create new product
                    $newProduct = ProductService::create([
                        'name' => $originalProduct->name,
                        'sku' => $originalProduct->sku,
                        'sale_price' => $originalProduct->sale_price,
                        'purchase_price' => $originalProduct->purchase_price,
                        'tax_id' => $tax ? $tax->id : 0,
                        'discount_id' => $discount ? $discount->id : 0,
                        'brand_id' => $brand ? $brand->id : 0,
                        'category_id' => $category ? $category->id : 0,
                        'unit_id' => $unit ? $unit->id : 0,
                        'low_stock_limit' => $originalProduct->low_stock_limit,
                        'quantity' => $transferProduct->quantity,
                        'type' => $originalProduct->type,
                        'description' => $originalProduct->description ?? '',
                        'image' => $originalProduct->image ?? '',
                        'created_by' => $creatorId,
                        'workspace_id' => $currentWorkspace,
                    ]);
                    
                    // Create warehouse product record
                    WarehouseProduct::create([
                        'warehouse_id' => $request->warehouse_id,
                        'product_id' => $newProduct->id,
                        'quantity' => $transferProduct->quantity,
                        'created_by' => $creatorId,
                        'workspace' => $currentWorkspace
                    ]);
                }
                
                // Update transfer product status
                $transferProduct->status = 'received';
                $transferProduct->received_date = $request->transfer_date;
                $transferProduct->received_by = $creatorId;
                $transferProduct->save();
                
                $successCount++;
                
            } catch (\Exception $e) {
                $failedProducts[] = "Product '{$originalProduct->name}': " . $e->getMessage();
                continue;
            }
        }
        
        // Update main transfer status if all products are received
        if ($successCount > 0) {
            $transferIds = WorkspaceTransferProduct::whereIn('id', $request->selected_products)
                ->pluck('workspace_transfer_id')
                ->unique();
            
            foreach ($transferIds as $transferId) {
                $transfer = WorkspaceTransfer::find($transferId);
                if ($transfer) {
                    $remainingPending = WorkspaceTransferProduct::where('workspace_transfer_id', $transferId)
                        ->where('status', 'pending')
                        ->count();
                    
                    if ($remainingPending == 0) {
                        $transfer->status = 'completed';
                        $transfer->completed_date = now();
                        $transfer->save();
                    }
                }
            }
        }
        
        DB::commit();
        
        // Prepare response
        if (count($failedProducts) > 0) {
            $html = '<h3 class="text-danger text-center">Some products could not be processed</h3><br>';
            $html .= '<div class="alert alert-warning"><ul>';
            foreach ($failedProducts as $error) {
                $html .= '<li>' . $error . '</li>';
            }
            $html .= '</ul></div>';
            $html .= '<p class="text-success">Successfully processed: ' . $successCount . ' products</p>';
            
            return response()->json([
                'success' => true,
                'html' => true,
                'response' => $html,
                'message' => "Partially completed: {$successCount} products received successfully"
            ]);
        } else {
            return response()->json([
                'success' => true,
                'html' => false,
                'message' => "All {$successCount} products received successfully!",
                'redirect' => route('workspace-transfer.ProductReceive')
            ]);
        }
        
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
            'success' => false,
            'message' => 'Failed to receive products: ' . $e->getMessage()
        ], 500);
    }
}


    public function getWorkspaceReport(Request $request)
    {
    // Base query for workspace transfers
    $query = DB::table('workspace_transfers as wt')
        ->join('work_spaces as from_ws', 'wt.workspace', '=', 'from_ws.id')
        ->join('work_spaces as to_ws', 'wt.to_workspace', '=', 'to_ws.id')
        ->join('warehouses as from_wh', 'wt.from_warehouse', '=', 'from_wh.id')
        ->leftJoin('warehouses as to_wh', 'wt.to_warehouse', '=', 'to_wh.id')
        ->leftJoin('workspace_transfer_products as wtp', 'wt.id', '=', 'wtp.workspace_transfer_id')
        ->leftJoin('product_services as ps', 'wtp.product_id', '=', 'ps.id')
        ->where('from_ws.created_by', '=', creatorId())
        ->select([
            'wt.*',
            'from_ws.name as from_workspace_name',
            'to_ws.name as to_workspace_name',
            'from_wh.name as from_warehouse_name',
            'to_wh.name as to_warehouse_name',
            DB::raw('COUNT(wtp.id) as product_count'),
            DB::raw('SUM(wtp.quantity) as total_quantity'),
            DB::raw('SUM(wtp.quantity * ps.purchase_price) as total_price')
        ]);

    // Apply filters
    if ($request->filled('from_workspace')) {
        $query->where('wt.workspace', $request->from_workspace);
    }

    if ($request->filled('to_workspace')) {
        $query->where('wt.to_workspace', $request->to_workspace);
    }

    if ($request->filled('from_warehouse')) {
        $query->where('wt.from_warehouse', $request->from_warehouse);
    }

    if ($request->filled('to_warehouse')) {
        $query->where('wt.to_warehouse', $request->to_warehouse);
    }

    if ($request->filled('date_from')) {
        $query->whereDate('wt.created_at', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $query->whereDate('wt.created_at', '<=', $request->date_to);
    }
    if (!$request->filled('date_from') && !$request->filled('date_to')) {
        $query->whereDate('wt.created_at', '>=', now()->subDays(30));
    }

    // Group by required fields
    $query->groupBy([
        'wt.id', 'wt.workspace', 'wt.to_workspace', 'wt.from_warehouse', 
        'wt.to_warehouse', 'wt.created_at', 'wt.updated_at', 'wt.status',
        'from_ws.name', 'to_ws.name', 'from_wh.name', 'to_wh.name'
    ]);

    $transfers = $query->orderBy('wt.created_at', 'desc')->get();

    // Calculate summary data
    $summary = [
        'from' => [
            'total_products' => $transfers->sum('product_count'),
            'total_price' => $transfers->sum('total_price'),
            'total_quantity' => $transfers->sum('total_quantity')
        ],
        'to' => [
            'total_products' => $transfers->sum('product_count'),
            'total_price' => $transfers->sum('total_price'),
            'total_quantity' => $transfers->sum('total_quantity')
        ],
        'total_transfers' => $transfers->count()
    ];

   
   
     // Get dropdown data for filters (only for active user)
    $workspaces = DB::table('work_spaces')
        ->select('id', 'name')
         ->where('created_by', '=', creatorId())
        ->get();
    
    // Initial empty warehouses - will be populated via AJAX
    $warehouses = [];


    return view('workspace-transfer.report', compact('transfers', 'summary', 'workspaces', 'warehouses', 'request'));
}


    
}
