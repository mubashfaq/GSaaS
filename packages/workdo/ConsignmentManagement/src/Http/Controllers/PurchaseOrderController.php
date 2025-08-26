<?php

namespace Workdo\ConsignmentManagement\Http\Controllers;

use App\Http\Controllers\PurchaseController;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Workdo\ConsignmentManagement\DataTables\PurchaseOrderDatatable;
use Workdo\ConsignmentManagement\Entities\Consignment;
use Workdo\ConsignmentManagement\Entities\ConsignmentItem;
use Workdo\ConsignmentManagement\Entities\PurchaseOrder;
use Workdo\ConsignmentManagement\Events\ConvertToPurchase;
use Workdo\ConsignmentManagement\Events\CreatePurchaseOrder;
use Workdo\ConsignmentManagement\Events\DestroyPurchaseOrder;
use Workdo\ConsignmentManagement\Events\UpdatePurchaseOrder;
use Workdo\ProductService\Entities\ProductService;

use function Termwind\render;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(PurchaseOrderDatatable $dataTable)
    {
        if (Auth::check() && Auth::user()->isAbleTo('purchase order manage')) {
            return $dataTable->render('consignment-management::purchase.index');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (Auth::check() && Auth::user()->isAbleTo('purchase order create')) {

            $consignments = Consignment::where('workspace_id', getActiveWorkSpace())->pluck('title', 'id');
            $vendors = User::where([
                ['created_by', creatorId()],
                ['workspace_id', getActiveWorkSpace()],
                ['type', 'vendor'],
            ])->pluck('name', 'id');

            return view('consignment-management::purchase.create', [
                'vendors' => $vendors,
                'consignments' => $consignments,
            ]);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        if (Auth::check() && Auth::user()->isAbleTo('purchase order create')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'consignment' => 'required',
                    'vendor' => 'required',
                    'date' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            try {
                DB::beginTransaction();

                $purchaseOrder = PurchaseOrder::create([
                    'consignment_id' => $request->consignment,
                    'vendor_id' => $request->vendor,
                    'date' => $request->date,
                    'subtotal' => $request->subtotal,
                    'totalamount' => $request->totalamount,
                    'commission' => $request->consignment_amount,
                    'created_by' => creatorId(),
                    'workspace_id' => getActiveWorkSpace(),
                ]);

                DB::commit();
                event(new CreatePurchaseOrder($request, $purchaseOrder));

                return redirect()->route('purchase-order.index')->with('success', __('The Purchase order has been created successfully'));
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->back()->with('error', $th->getMessage());

            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        if (Auth::check() && Auth::user()->isAbleTo('purchase order show')) {

            $purchaseOrder = PurchaseOrder::find($id);
            return view('consignment-management::purchase.show', [
                'purchaseOrder' => $purchaseOrder,
            ]);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        if (Auth::check() && Auth::user()->isAbleTo('purchase order edit')) {

            $consignments = Consignment::where('workspace_id', getActiveWorkSpace())->pluck('title', 'id');
            $purchaseOrder = PurchaseOrder::find($id);

            $vendors = User::where([
                ['created_by', creatorId()],
                ['workspace_id', getActiveWorkSpace()],
                ['type', 'vendor'],
            ])->pluck('name', 'id');

            return view('consignment-management::purchase.edit', [
                'vendors' => $vendors,
                'consignments' => $consignments,
                'purchaseOrder' => $purchaseOrder,
            ]);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        if (Auth::check() && Auth::user()->isAbleTo('purchase order edit')) {

            $purchaseOrder = PurchaseOrder::find($id);

            $validator = \Validator::make(
                $request->all(),
                [
                    'consignment' => 'required',
                    'vendor' => 'required',
                    'date' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            try {
                DB::beginTransaction();

                $purchaseOrder->update([
                    'consignment_id' => $request->consignment,
                    'vendor_id' => $request->vendor,
                    'date' => $request->date,
                    'subtotal' => $request->subtotal,
                    'totalamount' => $request->totalamount,
                    'commission' => $request->consignment_amount,
                    'created_by' => creatorId(),
                    'workspace_id' => getActiveWorkSpace(),
                ]);

                DB::commit();
                event(new UpdatePurchaseOrder($request, $purchaseOrder));

                return redirect()->route('purchase-order.index')->with('success', __('The Purchase order has been updated successfully'));
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->back()->with('error', $th->getMessage());
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if (Auth::check() && Auth::user()->isAbleTo('purchase order delete')) {
            $purchaseOrder = PurchaseOrder::findOrFail($id);
            event(new DestroyPurchaseOrder($purchaseOrder));

            $purchaseOrder->delete();
            return redirect()->back()->with('success', __('The Purchase order has been deleted successfully'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function getSection(Request $request)
    {

        $consignment = Consignment::find($request->consignment_id);
        if ($consignment) {

            $consignmentItems = ConsignmentItem::with('product')->where('consignment_id', $consignment->id)->get();

            $company_settings = getCompanyAllSetting();

            $returnHTML = view('consignment-management::purchase.section', [
                'consignment' => $consignment,
                'consignmentItems' => $consignmentItems,
                'module' => $request->module,
                'company_settings' => $company_settings,
            ])->render();

            return response()->json([
                'status' => true,
                'date' => $consignment->date,
                'html' => $returnHTML,
            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }

    public function ConvertToPurchasePopup($purchaseOrderId)
    {
        if (\Auth::user()->isAbleTo('purchase order convert to Purchase')) {
            if (module_is_active('ProductService')) {
                $category = [];
                if (module_is_active('ProductService')) {
                    $category = \Workdo\ProductService\Entities\Category::where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->where('type', 2)->get()->pluck('name', 'id');
                    $category->prepend('Select Category', '');
                }
                $warehouse = Warehouse::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id');
                $warehouse->prepend('Select Warehouse', '');

                return view('consignment-management::purchase.convertToPurchase', compact('category', 'warehouse', 'purchaseOrderId'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function ConvertToPurchase(Request $request, $purchaseOrder_id)
    {

        if (Auth::user()->isAbleTo('purchase order convert to Purchase')) {
            $purchaseOrder_id = Crypt::decrypt($purchaseOrder_id);
            $purchaseOrder = PurchaseOrder::where('id', $purchaseOrder_id)->first();
            $purchaseOrder->is_convert_purchase = 1;

            $convertPurchase = new Purchase();

            if ($purchaseOrder->account_type == 'Projects') {
                $account_type = 'Taskly';
            } else {
                $account_type = 'Accounting';
            }

            if (!empty($purchaseOrder->vendor_id)) {
                $vendor = \Workdo\Account\Entities\Vender::where('user_id', $purchaseOrder->vendor_id)->first();
            }
            $purchaseController = new PurchaseController();

            $convertPurchase->purchase_id = $purchaseController->purchaseNumber();
            $convertPurchase->vender_id = $purchaseOrder->vendor_id;
            $convertPurchase->user_id = !empty($vendor) ? $vendor->user_id : null;
            $convertPurchase->vender_name = !empty($purchaseOrder->vender_name) ? $purchaseOrder->vender_name : '';
            $convertPurchase->account_type = $account_type;
            $convertPurchase->warehouse_id = isset($request->warehouse_id) ? $request->warehouse_id : 0;
            $convertPurchase->purchase_date = $purchaseOrder->date;
            $convertPurchase->purchase_number = !empty($purchaseOrder->purchase_number) ? $purchaseOrder->purchase_number : 0;
            $convertPurchase->status = 0;
            $convertPurchase->category_id = isset($request->category_id) ? $request->category_id : 0;
            $convertPurchase->purchase_module = 'account';
            $convertPurchase->workspace = $purchaseOrder->workspace_id;
            $convertPurchase->created_by = $purchaseOrder->created_by;
            $convertPurchase->save();
            $purchaseOrder->converted_purchase_id = $convertPurchase->id;
            $purchaseOrder->save();

            if ($convertPurchase) {
                $consignmentItem = ConsignmentItem::where('consignment_id', $purchaseOrder->consignment_id)->get();
                foreach ($consignmentItem as $item) {
                    $description = ProductService::where('id', $item->product_id)->first();

                    $duplicateProduct = new PurchaseProduct();
                    $duplicateProduct->purchase_id = $convertPurchase->id;
                    $duplicateProduct->product_type = 'consignment';
                    $duplicateProduct->product_id = $item->product_id;
                    $duplicateProduct->quantity = $item->quantity;
                    $duplicateProduct->tax = $item->tax;
                    $duplicateProduct->discount = isset($item->discount) ? $item->discount : 0.00;
                    $duplicateProduct->price = $item->price;
                    $duplicateProduct->description = str_replace(array('\'', '"', '`', '{', "\n"), ' ', $description->description);
                    $duplicateProduct->save();

                    //inventory management (Quantity)
                    if ($convertPurchase['purchase_module'] == 'account') {
                        Purchase::total_quantity('plus', $duplicateProduct->quantity, $duplicateProduct->product_id);
                    }

                    //Product Stock Report
                    if (module_is_active('Account')) {
                        $type = 'Purchase';
                        $type_id = $convertPurchase->id;
                        $description = $duplicateProduct->quantity . ' ' . __(' quantity add in purchase') . ' , ' . __('The Purchase Order convert to Purchase') . ' ' . Purchase::purchaseNumberFormat($convertPurchase->purchase_id);
                        Purchase::addProductStock($duplicateProduct->product_id, $duplicateProduct->quantity, $type, $description, $type_id);
                    }

                    //Warehouse Stock Report
                    if (isset($duplicateProduct->product_id)) {
                        Purchase::addWarehouseStock($duplicateProduct->product_id, $duplicateProduct->quantity, $request->warehouse_id);
                    }
                }
            }
            event(new ConvertToPurchase($convertPurchase));

            return redirect()->back()->with('success', __('The Purchase Order convert to Purchase successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
