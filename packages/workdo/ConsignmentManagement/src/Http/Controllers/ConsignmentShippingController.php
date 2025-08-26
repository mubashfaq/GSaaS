<?php

namespace Workdo\ConsignmentManagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Workdo\ConsignmentManagement\DataTables\ConsignmentShippingDatatable;
use Workdo\ConsignmentManagement\Entities\Consignment;
use Workdo\ConsignmentManagement\Entities\ConsignmentShipping;
use Illuminate\Support\Facades\Auth;
use Workdo\ConsignmentManagement\Events\CreateConsignmentShipping;
use Workdo\ConsignmentManagement\Events\UpdateConsignmentShipping;
use Workdo\ConsignmentManagement\Events\DestroyConsignmentShipping;
class ConsignmentShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(ConsignmentShippingDatatable $dataTable)
    {
        if (Auth::user()->isAbleTo('consignment shipping manage')) {
            return $dataTable->render('consignment-management::shipping.index');
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
        if (Auth::user()->isAbleTo('consignment shipping create')) {
            $consignment = Consignment::where('workspace_id', getActiveWorkSpace())->where('created_by', creatorId())->pluck('title', 'id');
            $status = ConsignmentShipping::$status;

            return view('consignment-management::shipping.create',compact('consignment','status'));
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
        if (Auth::user()->isAbleTo('consignment shipping create')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'consignment_id' => 'required',
                    'shipping_company' => 'required',
                    'tracking_number' => 'required',
                    'status' => 'required',
                    'shipping_date' => 'required',
                    'estimated_delivery_date' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
             $shipping = new ConsignmentShipping();
             $shipping->consignment_id = $request->consignment_id;
             $shipping->shipping_company = $request->shipping_company;
             $shipping->tracking_number = $request->tracking_number;
             $shipping->status = $request->status;
             $shipping->shipping_date = $request->shipping_date;
             $shipping->estimated_delivery_date = $request->estimated_delivery_date;
             $shipping->workspace = getActiveWorkSpace();
             $shipping->created_by = creatorId();
             $shipping->save();
             event(new CreateConsignmentShipping($request, $shipping));

             return redirect()->back()->with('success', __('The shipping has been created successfully'));
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
        if (Auth::user()->isAbleTo('consignment shipping create')) {
            $consignment = Consignment::where('workspace_id', getActiveWorkSpace())->where('created_by', creatorId())->pluck('title', 'id');
            $shipping = ConsignmentShipping::find($id);
            $status = ConsignmentShipping::$status;
            return view('consignment-management::shipping.edit',compact('consignment' ,'shipping','status'));
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
        if (Auth::user()->isAbleTo('consignment shipping edit')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'consignment_id' => 'required',
                    'shipping_company' => 'required',
                    'tracking_number' => 'required',
                    'status' => 'required',
                    'shipping_date' => 'required',
                    'estimated_delivery_date' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
             $shipping = ConsignmentShipping::find($id);
             $shipping->consignment_id = $request->consignment_id;
             $shipping->shipping_company = $request->shipping_company;
             $shipping->tracking_number = $request->tracking_number;
             $shipping->status = $request->status;
             $shipping->shipping_date = $request->shipping_date;
             $shipping->estimated_delivery_date = $request->estimated_delivery_date;
             $shipping->workspace = getActiveWorkSpace();
             $shipping->created_by = creatorId();
             $shipping->save();

             event(new UpdateConsignmentShipping($request, $shipping));

             return redirect()->back()->with('success', __('The shipping details are updated successfully'));
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
        if (Auth::user()->isAbleTo('consignment shipping delete')) {
            $shipping = ConsignmentShipping::find($id);
            event(new DestroyConsignmentShipping($shipping));
            $shipping->delete();
            return redirect()->back()->with('success', __('The shipping has been deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
