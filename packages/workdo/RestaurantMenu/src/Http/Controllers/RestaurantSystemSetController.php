<?php

namespace Workdo\RestaurantMenu\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\RestaurantMenu\Entities\RestaurantSystemSet;

class RestaurantSystemSetController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (Auth::user()->isAbleTo('restaurant_items_attributes manage')) {
            $itemAttributes = RestaurantSystemSet::where('created_by', '=', creatorId())->where('workspace', getActiveWorkSpace())->get();
            return view('restaurant-menu::system_setup.index',compact('itemAttributes'));
        }else{
            return redirect()->back()->with('error', __('Permission denied.'));

        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (Auth::user()->isAbleTo('restaurant_items_attributes create')) {
        return view('restaurant-menu::system_setup.create');
        }else{
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
        if (Auth::user()->isAbleTo('restaurant_items_attributes create')) {
            $rules = [
                'name' => 'required',
            ];

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $itemAttribute             = new RestaurantSystemSet();
            $itemAttribute->name       = $request->name;
            $itemAttribute->status     = $request->status;
            $itemAttribute->created_by = creatorId();
            $itemAttribute->workspace  = getActiveWorkSpace();
            $itemAttribute->save();
            return redirect()->back()->with('success', __('The item attribute has been created successfully.'));
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
        $itemAttribute = RestaurantSystemSet::find($id);
        return view('restaurant-menu::system_setup.edit',compact('itemAttribute'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->isAbleTo('restaurant_items_attributes edit')) {
            $rules = [
                'name' => 'required',
            ];

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $itemAttribute = RestaurantSystemSet::find($id);
            $itemAttribute->name       = $request->name;
            $itemAttribute->status     = $request->status;
            $itemAttribute->save();
            return redirect()->back()->with('success', __('The item attribute details are updated successfully.'));
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
        if (Auth::user()->isAbleTo('restaurant_items_attributes delete')) {
            $itemAttribute = RestaurantSystemSet::find($id);
            if($itemAttribute){
                $itemAttribute->delete();
                return redirect()->back()->with('success', __('The item attribute has been deleted.'));
            }
        }else{
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
