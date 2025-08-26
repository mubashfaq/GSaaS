<?php

namespace Workdo\RestaurantMenu\Http\Controllers;

use App\Models\WorkSpace;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Workdo\RestaurantMenu\Entities\RestaurantCustomer;
use Workdo\RestaurantMenu\Entities\RestaurantDiningTable;
use Workdo\RestaurantMenu\Entities\RestaurantOrder;
use Illuminate\Support\Facades\Session;
use Workdo\RestaurantMenu\DataTables\OrderDatatable;

class RestaurantOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(OrderDatatable $dataTable)
    {
        return $dataTable->render('restaurant-menu::order.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('restaurant-menu::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request,$workspace,$tableId)
    {
        $workspace = WorkSpace::find($workspace);
        $diningTables = RestaurantDiningTable::find($tableId);
        $table_id = $tableId;
        $customer             = new RestaurantCustomer();
        $customer->first_name = $request->first_name;
        $customer->last_name  = $request->last_name;
        $customer->email      = $request->email;
        $customer->mobile_no  = $request->mobile_no;
        $customer->workspace  = $diningTables->workspace;
        $customer->created_by = $diningTables->created_by;
        $customer->save();

        $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
        $order              = new RestaurantOrder();
        $order->order_id    = $orderID;
        $order->customer_id = $customer->id;
        $order->product     = isset($request->cart) ? $request->cart : 'null';
        $order->total       = $request->total;
        $order->status      = 0;
        $order->table_id    = $table_id;
        $order->workspace   = $diningTables->workspace;
        $order->created_by  = $diningTables->created_by;
        $order->save();
        session()->forget($workspace->slug);

            $orders    = session()->get('order_id');
            $orders[] = $order->toArray();
            session()->put('order_id',$orders);

        return redirect()->route('restaurant-qr-reader',compact('workspace','table_id'))->with('success', __('Order Successfully added!'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $order = RestaurantOrder::find($id);
        $statues = RestaurantOrder::$statues;

        return view('restaurant-menu::order.show',compact('order','statues'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('restaurant-menu::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $order = RestaurantOrder::find($id);
        //Order Placed
        if($request->orderStatus == 0)
        {
            $order->status = 0;
            $order->save();
        }
        //Order Accept
        if($request->orderStatus == 1)
        {
            $order->status = 1;
            $order->save();
        }
        //Order Procesing
        if($request->orderStatus == 2)
        {
            $order->status = 2;
            $order->save();
        }
        //Order Delivered
        if($request->orderStatus == 3)
        {
            $order->status = 3;
            $order->save();
        }
        return response()->json(['success' => __('The status has been changed successfully!')]);


    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function showOrderStatus($workspace,$tableId){
        $workspace = WorkSpace::find($workspace);
        $diningTable = RestaurantDiningTable::find($tableId);
        $orders = session()->get('order_id');
        $company_id = $diningTable->created_by;
        $workspace_id = $diningTable->workspace;
        return view('restaurant-menu::order.invoice',compact('workspace','diningTable','orders','company_id','workspace_id'));
    }
    public function orderStatusChange($workspace,$tableId,$orderId){

        $workspace = WorkSpace::find($workspace);
        $diningTable = RestaurantDiningTable::find($tableId);
        $orders = RestaurantOrder::where('order_id',$orderId)->first();
        if($orders != null)
        {
            $company_id = $diningTable->created_by;
            $workspace_id = $diningTable->workspace;
            return view('restaurant-menu::order.invoice_show',compact('workspace','diningTable','orders','company_id','workspace_id'));
        }
        else
        {
            abort(404);
        }
    }
}
