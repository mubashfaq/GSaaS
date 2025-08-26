<?php

namespace Workdo\ConsignmentManagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Workdo\ConsignmentManagement\Entities\Consignment;
use Workdo\ConsignmentManagement\Entities\ConsignmentItem;
use Workdo\ProductService\Entities\ProductService;
use Workdo\ConsignmentManagement\Entities\ConsignmentQualityControl;
use Workdo\ConsignmentManagement\Events\CreateConsignmentQualityControl;
use Workdo\ConsignmentManagement\Events\UpdateConsignmentQualityControl;
use Workdo\ConsignmentManagement\Events\DestroyConsignmentQualityControl;
use Illuminate\Support\Facades\Auth;
use Workdo\ConsignmentManagement\DataTables\ConsignmentQualityControlDatatable;

class ConsignmentQualityControlController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(ConsignmentQualityControlDatatable $dataTable)
    {
        if (Auth::user()->isAbleTo('consignment qualitycontrol manage')) {
            return $dataTable->render('consignment-management::qualitycontrol.index');
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
        if (Auth::user()->isAbleTo('consignment qualitycontrol create')) {
            $consignment =Consignment::where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->get()->pluck('title','id');
            $status = ConsignmentQualityControl::$status;
            return view('consignment-management::qualitycontrol.create',compact('consignment','status'));
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

        if (Auth::user()->isAbleTo('consignment qualitycontrol create')) {

            $validator = \Validator::make(
                $request->all(),
                [
                    'consignment_id' => 'required',
                    'product_id' => 'required',
                    'check_date' => 'required',
                    'status' => 'required',
                    'inspector' => 'required',
                    'remarks' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

             $Consignmentquality  = new ConsignmentQualityControl();
             $Consignmentquality->consignment_id  = $request->consignment_id;
             $Consignmentquality->product_id  = implode(',',$request->product_id);
             $Consignmentquality->check_date  = $request->check_date;
             $Consignmentquality->status  = $request->status;
             $Consignmentquality->inspector  = $request->inspector;
             $Consignmentquality->remarks  = $request->remarks;
             $Consignmentquality->workspace = getActiveWorkSpace();
             $Consignmentquality->created_by = creatorId();
             $Consignmentquality->save();
             event(new CreateConsignmentQualityControl($request, $Consignmentquality));

             return redirect()->back()->with('success', __('The quality control has been created successfully'));
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
        return redirect()->back();
        return view('consignment-management::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        if (Auth::user()->isAbleTo('consignment qualitycontrol edit')) {
            $consignment =Consignment::where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->get()->pluck('title','id');
            $status = ConsignmentQualityControl::$status;
            $consignmentquality =ConsignmentQualityControl::find($id);
            $selectedProducts = explode(',' ,$consignmentquality->product_id);
            $product = ProductService::whereIN('id' ,$selectedProducts)->get()->pluck('name','id');

            return view('consignment-management::qualitycontrol.edit' ,compact('consignment','status','consignmentquality','selectedProducts','product'));
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

        if (Auth::user()->isAbleTo('consignment qualitycontrol edit')) {

            $validator = \Validator::make(
                $request->all(),
                [
                    'consignment_id' => 'required',
                    'product_id' => 'required',
                    'check_date' => 'required',
                    'status' => 'required',
                    'inspector' => 'required',
                    'remarks' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

             $Consignmentquality  = ConsignmentQualityControl::find($id);
             $Consignmentquality->consignment_id  = $request->consignment_id;
             $Consignmentquality->product_id  = implode(',',$request->product_id);
             $Consignmentquality->check_date  = $request->check_date;
             $Consignmentquality->status  = $request->status;
             $Consignmentquality->inspector  = $request->inspector;
             $Consignmentquality->remarks  = $request->remarks;
             $Consignmentquality->workspace = getActiveWorkSpace();
             $Consignmentquality->created_by = creatorId();
             $Consignmentquality->save();
             event(new UpdateConsignmentQualityControl($request, $Consignmentquality));

             return redirect()->back()->with('success', __('The quality control details are updated successfully'));

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
        if (Auth::user()->isAbleTo('consignment qualitycontrol delete')) {
            $consignmentquality =ConsignmentQualityControl::find($id);
            event(new DestroyConsignmentQualityControl($consignmentquality));
            $consignmentquality->delete();
            return redirect()->back()->with('success', __('The quality control has been deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function qualitycontrolproduct(Request $request){
        $Consignment = ConsignmentItem::where('consignment_id',$request->consignment_id)->pluck('product_id')->toArray();
        $product = ProductService::whereIn('id',$Consignment)->get()->pluck('name','id');
        return $product;
    }
}
