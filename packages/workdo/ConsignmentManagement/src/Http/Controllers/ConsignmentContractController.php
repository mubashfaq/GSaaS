<?php

namespace Workdo\ConsignmentManagement\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Workdo\Account\Entities\Customer;
use Workdo\ConsignmentManagement\DataTables\ConsignmentContractDataTable;
use Workdo\ConsignmentManagement\Entities\ConsignmentContract;
use Workdo\ConsignmentManagement\Events\CreateConsignmentContract;
use Workdo\ConsignmentManagement\Events\DestoryConsignmentContract;
use Workdo\ConsignmentManagement\Events\UpdateConsignmentContract;

class ConsignmentContractController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(ConsignmentContractDataTable $dataTable)
    {
        if (Auth::user()->isAbleTo('consignment contract manage')) {

            return $dataTable->render('consignment-management::contract.index');
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
        if (Auth::user()->isAbleTo('consignment contract create')) {

            $customers    = Customer::where('created_by', creatorId())->where('workspace' , getActiveWorkSpace())->pluck('name', 'id');
            $company      = User::find(creatorId());
            $contractType = ConsignmentContract::$contractType;

            return view('consignment-management::contract.create' , compact('customers' , 'company' , 'contractType'));
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
        if (Auth::user()->isAbleTo('consignment contract create')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'party_a'       => 'required',
                    'party_b'       => 'required',
                    'contract_type' => 'required',
                    'start_date'    => 'required',
                    'end_date'      => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $contract                       = new ConsignmentContract();
            $contract->party_a              = $request->party_a;
            $contract->party_b              = creatorId();
            $contract->contract_type        = $request->contract_type;
            $contract->start_date           = $request->start_date;
            $contract->end_date             = $request->end_date;
            $contract->terms_and_conditions = $request->terms_and_conditions;
            $contract->created_by           = creatorId();
            $contract->workspace            = getActiveWorkSpace();
            $contract->save();
            event(new CreateConsignmentContract($request, $contract));

            return redirect()->back()->with('success', __('The contract has been created successfully'));
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
        if (Auth::user()->isAbleTo('consignment contract edit')) {
            $id = Crypt::decrypt($id);
            $customers    = Customer::where('created_by', creatorId())->where('workspace' , getActiveWorkSpace())->pluck('name', 'id');
            $company      = User::find(creatorId());
            $contractType = ConsignmentContract::$contractType;
            $contract = ConsignmentContract::find($id);

            return view('consignment-management::contract.edit', compact('contract' , 'customers' , 'company' , 'contractType'));
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
        if (Auth::user()->isAbleTo('consignment contract edit')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'party_a'       => 'required',
                    'party_b'       => 'required',
                    'contract_type' => 'required',
                    'start_date'    => 'required',
                    'end_date'      => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $contract                       = ConsignmentContract::find($id);
            $contract->party_a              = $request->party_a;
            $contract->party_b              = creatorId();
            $contract->contract_type        = $request->contract_type;
            $contract->start_date           = $request->start_date;
            $contract->end_date             = $request->end_date;
            $contract->terms_and_conditions = $request->terms_and_conditions;
            $contract->created_by           = creatorId();
            $contract->update();
            event(new UpdateConsignmentContract($request, $contract));

            return redirect()->back()->with('success', __('The contract details are updated successfully'));
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
        if (Auth::user()->isAbleTo('consignment contract delete')) {
            $contract = ConsignmentContract::where('id', $id)->where('workspace', getActiveWorkSpace())->first();

            event(new DestoryConsignmentContract($contract));
            $contract->delete();
            return redirect()->back()->with('success', __('The contract has been deleted'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

}
