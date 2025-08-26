<?php

namespace Workdo\RestaurantMenu\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\RestaurantMenu\DataTables\CustomerDatatable;
use Workdo\RestaurantMenu\Entities\RestaurantCustomer;
use Workdo\RestaurantMenu\Events\CreateRestaurantCustomer;
use Workdo\RestaurantMenu\Events\UpdateRestaurantCustomer;

class RestaurantCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(CustomerDatatable $dataTable)
    {
        if (Auth::user()->isAbleTo('restaurant_customer manage')) {

            return $dataTable->render('restaurant-menu::customer.index');
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
        if (Auth::user()->isAbleTo('restaurant_customer create')) {
            return view('restaurant-menu::customer.create');
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
        if (Auth::user()->isAbleTo('restaurant_customer create')) {
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'mobile_no' => 'required',
            ];

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $customer             = new RestaurantCustomer();
            $customer->first_name = $request->first_name;
            $customer->last_name  = $request->last_name;
            $customer->email      = $request->email;
            $customer->mobile_no  = $request->mobile_no;
            $customer->created_by = creatorId();
            $customer->workspace  = getActiveWorkSpace();
            $customer->save();

            event(new CreateRestaurantCustomer($request,$customer));
            return redirect()->back()->with('success', __('The customer has been created successfully.'));
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
        return view('restaurant-menu::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        if (Auth::user()->isAbleTo('restaurant_customer edit')) {
            $ids = decrypt($id);
            $customer = RestaurantCustomer::find($ids);
            return view('restaurant-menu::customer.edit',compact('customer'));
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
        if (Auth::user()->isAbleTo('restaurant_customer edit')) {
            $customer = RestaurantCustomer::find($id);
            $customer->first_name = $request->first_name;
            $customer->last_name  = $request->last_name;
            $customer->email      = $request->email;
            $customer->mobile_no  = $request->mobile_no;
            $customer->save();
            event(new UpdateRestaurantCustomer($request,$customer));
            return redirect()->back()->with('success', __('The customer details are updated successfully.'));

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
        if (Auth::user()->isAbleTo('restaurant_customer delete')) {
            $customer = RestaurantCustomer::find($id);
            if($customer){
                $customer->delete();
                return redirect()->back()->with('success', __('The customer has been deleted.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
