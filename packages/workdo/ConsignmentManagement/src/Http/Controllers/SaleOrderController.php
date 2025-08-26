<?php

namespace Workdo\ConsignmentManagement\Http\Controllers;

use App\Http\Controllers\InvoiceController;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Workdo\ConsignmentManagement\DataTables\SaleOrderDatatable;
use Workdo\ConsignmentManagement\Entities\Consignment;
use Workdo\ConsignmentManagement\Entities\ConsignmentItem;
use Workdo\ConsignmentManagement\Entities\SaleOrder;
use Workdo\ConsignmentManagement\Events\ConvertSaleOrderToInvoice;
use Workdo\ConsignmentManagement\Events\CreateSaleOrder;
use Workdo\ConsignmentManagement\Events\DestroySaleOrder;
use Workdo\ConsignmentManagement\Events\UpdateSaleOrder;
use Workdo\ProductService\Entities\ProductService;

class SaleOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(SaleOrderDatatable $dataTable)
    {
        if (Auth::check() && Auth::user()->isAbleTo('sale order manage')) {
            return $dataTable->render('consignment-management::sale.index');
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
        if (Auth::check() && Auth::user()->isAbleTo('sale order create')) {

            $consignments = Consignment::where('workspace_id', getActiveWorkSpace())->pluck('title', 'id');
            $customer = User::where('workspace_id', '=', getActiveWorkSpace())->where('type', 'Client')->get()->pluck('name', 'id');

            return view('consignment-management::sale.create', [
                'customer' => $customer,
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
        if (Auth::check() && Auth::user()->isAbleTo('sale order create')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'consignment' => 'required',
                    'customer' => 'required',
                    'date' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $SaleOrder = SaleOrder::where('created_by',creatorId())->where('workspace_id' , getActiveWorkSpace())->orderBy('id', 'desc')->first();

            try {
                DB::beginTransaction();

                $saleOrder = SaleOrder::create([
                    'sale_order_id' => !empty($SaleOrder) ? $SaleOrder->sale_order_id + 1 : 1,
                    'consignment_id' => $request->consignment,
                    'customer_id' => $request->customer,
                    'date' => $request->date,
                    'subtotal' => $request->subtotal,
                    'totalamount' => $request->totalamount,
                    'commission' => $request->consignment_amount,
                    'created_by' => creatorId(),
                    'workspace_id' => getActiveWorkSpace(),
                ]);

                DB::commit();
                event(new CreateSaleOrder($request, $saleOrder));

                return redirect()->route('sale-order.index')->with('success', __('The Sale order has been created successfully.'));
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
        if (Auth::check() && Auth::user()->isAbleTo('sale order show')) {

            $saleOrder = SaleOrder::find($id);

            return view('consignment-management::sale.show', ['saleOrder' => $saleOrder]);
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
        if (Auth::check() && Auth::user()->isAbleTo('sale order edit')) {

            $consignments = Consignment::where('workspace_id', getActiveWorkSpace())->pluck('title', 'id');
            $saleOrder = SaleOrder::find($id);

            $customer = User::where('workspace_id', '=', getActiveWorkSpace())->where('type', 'Client')->get()->pluck('name', 'id');

            return view('consignment-management::sale.edit', [
                'customer' => $customer,
                'consignments' => $consignments,
                'saleOrder' => $saleOrder,
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
        if (Auth::check() && Auth::user()->isAbleTo('sale order edit')) {

            $saleOrder = SaleOrder::find($id);
            $validator = \Validator::make(
                $request->all(),
                [
                    'consignment' => 'required',
                    'customer' => 'required',
                    'date' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            try {
                DB::beginTransaction();

                $saleOrder->update([
                    'consignment_id' => $request->consignment,
                    'customer_id' => $request->customer,
                    'date' => $request->date,
                    'subtotal' => $request->subtotal,
                    'totalamount' => $request->totalamount,
                    'commission' => $request->consignment_amount,
                    'created_by' => creatorId(),
                    'workspace_id' => getActiveWorkSpace(),
                ]);

                DB::commit();
                event(new UpdateSaleOrder($request, $saleOrder));

                return redirect()->route('sale-order.index')->with('success', __('The Sale order has been updated successfully.'));
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
        if (Auth::check() && Auth::user()->isAbleTo('sale order delete')) {
            $SaleOrder = SaleOrder::findOrFail($id);
            event(new DestroySaleOrder($SaleOrder));

            $SaleOrder->delete();
            return redirect()->back()->with('success', __('The Sale order has been deleted successfully.'));
        }
    }

    public function ConvertToSalePopup($saleOrderId)
    {
        if (\Auth::user()->isAbleTo('sale order convert to invoice')) {
            if (module_is_active('ProductService')) {
                $category = [];
                $category = \Workdo\ProductService\Entities\Category::where('created_by', '=', creatorId())->where('workspace_id', getActiveWorkSpace())->where('type', 1)->get()->pluck('name', 'id');
                $category->prepend('Select Category', '');
                $company_settings = getCompanyAllSetting();
                $selectedTemplate = $company_settings['invoice_template'];

                $warehouse = Warehouse::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id');
                $warehouse->prepend('Select Warehouse', '');

                return view('consignment-management::sale.convertToSale', compact('category', 'saleOrderId', 'selectedTemplate', 'warehouse'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function ConvertToInvoice(Request $request, $saleOrder_id)
    {
        if (Auth::user()->isAbleTo('sale order convert to invoice')) {
            $saleOrder_id = Crypt::decrypt($saleOrder_id);
            $saleOrder = SaleOrder::where('id', $saleOrder_id)->first();
            $saleOrder->is_convert_invoice = 1;

            $convertInvoice = new Invoice();

            if ($saleOrder->account_type == 'Projects') {
                $account_type = 'Taskly';
            } else {
                $account_type = 'Account';
            }

            if (module_is_active('Account')) {
                $customer = \Workdo\Account\Entities\Customer::where('user_id', $saleOrder['customer_id'])->first();
                $convertInvoice->customer_id = !empty($customer) ? $customer->id : null;
            }
            $invoiceController = new InvoiceController();

            $convertInvoice->invoice_id = $invoiceController->invoiceNumber();
            $convertInvoice->user_id = $saleOrder->customer_id;
            $convertInvoice->account_type = $account_type;
            $convertInvoice->issue_date = date('Y-m-d');
            $convertInvoice->due_date = date('Y-m-d');
            $convertInvoice->send_date = null;
            $convertInvoice->category_id = $request->category_id;
            $convertInvoice->status = 0;
            $convertInvoice->invoice_module = 'account';
            $convertInvoice->invoice_template = $request->invoice_template;
            $convertInvoice->workspace = $saleOrder->workspace_id;
            $convertInvoice->created_by = $saleOrder->created_by;
            $convertInvoice->save();
            Invoice::starting_number($convertInvoice->invoice_id + 1, 'invoice');
            $saleOrder->converted_invoice_id = $convertInvoice->id;
            $saleOrder->save();

            if ($convertInvoice) {
                $consignmentItem = ConsignmentItem::where('consignment_id', $saleOrder->consignment_id)->get();
                foreach ($consignmentItem as $item) {
                    $description = ProductService::where('id', $item->product_id)->first();

                    $duplicateProduct = new InvoiceProduct();
                    $duplicateProduct->invoice_id = $convertInvoice->id;
                    $duplicateProduct->product_type = 'consignment';
                    $duplicateProduct->product_id = $item->product_id;
                    $duplicateProduct->quantity = $item->quantity;
                    $duplicateProduct->tax = $item->tax;
                    $duplicateProduct->discount = isset($item->discount) ? $item->discount : 0.00;
                    $duplicateProduct->price = $item->price;
                    $duplicateProduct->description = str_replace(array('\'', '"', '`', '{', "\n"), ' ', $description->description);
                    $duplicateProduct->save();

                    //inventory management (Quantity)
                    if ($convertInvoice['invoice_module'] == 'account') {
                        Invoice::total_quantity('minus', $duplicateProduct->quantity, $duplicateProduct->product_id);
                    }

                    //Product Stock Report
                    if (module_is_active('Account')) {
                        $type = 'invoice';
                        $type_id = $convertInvoice->id;
                        $description = $duplicateProduct->quantity . '' . __(' quantity sold in Sale order') . ' , ' . __('The Sale Order convert to invoice') . ' ' . Invoice::invoiceNumberFormat($convertInvoice->invoice_id);
                        \Workdo\Account\Entities\AccountUtility::addProductStock($duplicateProduct->product_id, $duplicateProduct->quantity, $type, $description, $type_id);
                    }

                    //Warehouse Stock Report
                    if (isset($duplicateProduct->product_id)) {
                        $type = 'minus';
                        Invoice::warehouse_quantity($type , $duplicateProduct->quantity, $duplicateProduct->product_id, $request->warehouse_id);
                    }
                }
            }
            event(new ConvertSaleOrderToInvoice($convertInvoice));

            return redirect()->back()->with('success', __('The Sale Order convert to invoice successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
