<?php

namespace Workdo\ConsignmentManagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\ConsignmentManagement\DataTables\ConsignmentReturnDatatable;
use Workdo\ConsignmentManagement\Entities\Consignment;
use Workdo\ConsignmentManagement\Entities\SaleOrder;
use Workdo\ConsignmentManagement\Entities\ConsignmentItem;
use Workdo\ConsignmentManagement\Entities\ConsignmentProduct;
use Workdo\ConsignmentManagement\Entities\ConsignmentReturn;
use  Workdo\ConsignmentManagement\Events\CreateConsignmentReturn;
use  Workdo\ConsignmentManagement\Events\UpdateConsignmentReturn;
use  Workdo\ConsignmentManagement\Events\DestroyConsignmentReturn;
use Workdo\ProductService\Entities\ProductService;

class ConsignmentReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(ConsignmentReturnDatatable $dataTable)
    {
        if (Auth::user()->isAbleTo('consignment return manage')) {
            return $dataTable->render('consignment-management::return.index');
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
        if (Auth::user()->isAbleTo('consignment return create')) {

            $sale_order  = SaleOrder::where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->get()->pluck('sale_order_id','id');
            $status = ConsignmentReturn::$status;
            return view('consignment-management::return.create' ,compact('sale_order','status'));
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
        if (Auth::user()->isAbleTo('consignment return create')) {

            $validator = \Validator::make(
                $request->all(),
                [
                    'sale_order_id' => 'required',
                    'product_id' => 'required',
                    'quantity' => 'required',
                    'return_reason' => 'required',
                    'return_date' => 'required',
                    'status' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

             $sale_order = SaleOrder::where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->where('sale_order_id' ,$request->sale_order_id)->first();
             $ConsignmentReturn  = new ConsignmentReturn();
             $ConsignmentReturn->sale_order_id  = $request->sale_order_id;
             $ConsignmentReturn->consignment_id  = $sale_order->consignment_id;
             $ConsignmentReturn->product_id  = $request->product_id;
             $ConsignmentReturn->quantity  = $request->quantity;
             $ConsignmentReturn->return_reason  = $request->return_reason;
             $ConsignmentReturn->return_date  = $request->return_date;
             $ConsignmentReturn->status  = $request->status;
             $ConsignmentReturn->workspace = getActiveWorkSpace();
             $ConsignmentReturn->created_by = creatorId();
             $ConsignmentReturn->save();
             event(new CreateConsignmentReturn($request, $ConsignmentReturn));

             return redirect()->back()->with('success', __('The return has been created successfully'));
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
        return view('consignment-management::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        if (Auth::user()->isAbleTo('consignment return edit')) {
            $sale_order  = SaleOrder::where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->get()->pluck('sale_order_id','id');
            $status = ConsignmentReturn::$status;
            $products = ProductService::where([['type', 'consignment'], ['created_by', creatorId()], ['workspace_id', getActiveWorkSpace()]])->pluck('name', 'id');
            $return = ConsignmentReturn::find($id);
            return view('consignment-management::return.edit' ,compact('sale_order','products','status','return'));
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
        if (Auth::user()->isAbleTo('consignment return edit')) {

            $validator = \Validator::make(
                $request->all(),
                [
                    'sale_order_id' => 'required',
                    'product_id' => 'required',
                    'quantity' => 'required',
                    'return_reason' => 'required',
                    'return_date' => 'required',
                    'status' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
             $ConsignmentReturn  = ConsignmentReturn::find($id);
             $ConsignmentReturn->sale_order_id  = $request->sale_order_id;
             $ConsignmentReturn->product_id  = $request->product_id;
             $ConsignmentReturn->quantity  = $request->quantity;
             $ConsignmentReturn->return_reason  = $request->return_reason;
             $ConsignmentReturn->return_date  = $request->return_date;
             $ConsignmentReturn->status  = $request->status;
             $ConsignmentReturn->workspace = getActiveWorkSpace();
             $ConsignmentReturn->created_by = creatorId();
             $ConsignmentReturn->save();
             event(new UpdateConsignmentReturn($request, $ConsignmentReturn));

             return redirect()->back()->with('success', __('The return details are updated successfully'));

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
         if(Auth::user()->isAbleTo('consignment return delete')) {
            $return = ConsignmentReturn::find($id);
            event(new DestroyConsignmentReturn($return));
            $return->delete();
            return redirect()->back()->with('success', __('The return has been deleted.'));
         }else{
            return redirect()->back()->with('error', __('Permission denied.'));

         }

    }

    public function ReturnProduct(Request $request){
        $sale_order = SaleOrder::where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->where('sale_order_id' ,$request->sale_order_id)->first();
        // dd($sale_order);
        $ConsignmentItem = ConsignmentItem::where('consignment_id',$sale_order->consignment_id)->get()->pluck('product_id');
        $products = ProductService::where([['type', 'consignment'], ['created_by', creatorId()], ['workspace_id', getActiveWorkSpace()]])->whereIn('id',$ConsignmentItem)->pluck('name', 'id');

            return response()->json(
                [
                    'products' => $products
                ]
            );
    }
}
