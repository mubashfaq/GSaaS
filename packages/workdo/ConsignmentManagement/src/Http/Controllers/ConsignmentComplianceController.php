<?php

namespace Workdo\ConsignmentManagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Workdo\ConsignmentManagement\DataTables\ConsignmentComplianceDataTable;
use Workdo\ConsignmentManagement\Entities\ConsignmentCompliance;
use Workdo\ConsignmentManagement\Events\CreateConsignmentCompliance;
use Workdo\ConsignmentManagement\Events\DestoryConsignmentCompliance;
use Workdo\ConsignmentManagement\Events\UpdateConsignmentCompliance;

class ConsignmentComplianceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(ConsignmentComplianceDataTable $dataTable)
    {
        if (Auth::user()->isAbleTo('consignment compliance manage')) {

            return $dataTable->render('consignment-management::compliance.index');
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
        if (Auth::user()->isAbleTo('consignment compliance create')) {

            $status = ConsignmentCompliance::$status;

            return view('consignment-management::compliance.create' , compact('status'));
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
        if (Auth::user()->isAbleTo('consignment compliance create')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'related_entity'   => 'required|max:20',
                    'compliance_type'  => 'required|max:20',
                    'status'           => 'required',
                    'report_date'      => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $compliance                   = new ConsignmentCompliance();
            $compliance->related_entity   = $request->related_entity;
            $compliance->compliance_type  = $request->compliance_type;
            $compliance->status           = $request->status;
            $compliance->report_date      = $request->report_date;
            $compliance->remarks          = $request->remarks;
            $compliance->created_by       = creatorId();
            $compliance->workspace        = getActiveWorkSpace();
            $compliance->save();
            event(new CreateConsignmentCompliance($request, $compliance));

            return redirect()->back()->with('success', __('The compliance has been created successfully'));
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
        return view('school::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        if (Auth::user()->isAbleTo('consignment compliance edit')) {
            $id = Crypt::decrypt($id);
            $compliance = ConsignmentCompliance::find($id);
            $status = ConsignmentCompliance::$status;

            return view('consignment-management::compliance.edit', compact('compliance', 'status'));
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
        if (Auth::user()->isAbleTo('consignment compliance edit')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'related_entity'   => 'required|max:20',
                    'compliance_type'  => 'required|max:20',
                    'status'           => 'required',
                    'report_date'      => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $compliance                   = ConsignmentCompliance::find($id);
            $compliance->related_entity   = $request->related_entity;
            $compliance->compliance_type  = $request->compliance_type;
            $compliance->status           = $request->status;
            $compliance->report_date      = $request->report_date;
            $compliance->remarks          = $request->remarks;
            $compliance->update();
            event(new UpdateConsignmentCompliance($request, $compliance));

            return redirect()->back()->with('success', __('The compliance details are updated successfully'));
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
        if (Auth::user()->isAbleTo('consignment compliance delete')) {
            $compliance = ConsignmentCompliance::where('id', $id)->where('workspace', getActiveWorkSpace())->first();

            event(new DestoryConsignmentCompliance($compliance));
            $compliance->delete();
            return redirect()->back()->with('success', __('The compliance has been deleted'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

}
