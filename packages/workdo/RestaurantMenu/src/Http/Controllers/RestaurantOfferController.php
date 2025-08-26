<?php

namespace Workdo\RestaurantMenu\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Workdo\ProductService\Entities\ProductService;
use Illuminate\Support\Facades\Auth;
use Workdo\RestaurantMenu\DataTables\OfferDatatable;
use Workdo\RestaurantMenu\Entities\RestaurantOffer;

class RestaurantOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(OfferDatatable $dataTable)
    {
        if (Auth::user()->isAbleTo('offers manage')) {
            return $dataTable->render('restaurant-menu::offers.index');          
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
        if (Auth::user()->isAbleTo('offers create')) {
            $items = ProductService::where('type', 'restaurants')->where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->pluck('name', 'id');            
            return view('restaurant-menu::offers.create', compact('items'));
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
        if (Auth::user()->isAbleTo('offers create')) {
            $rules = [
                'name' => 'required',
                'discount' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'status' => 'required',
                'items' => 'required',
            ];

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $offer             = new RestaurantOffer();
            $offer->name       = $request->name;
            $offer->discount   = $request->discount;
            $offer->start_date = $request->start_date;
            $offer->end_date   = $request->end_date;
            $offer->status     = $request->status;
            $offer->items      = isset($request->items) ? $request->items : '';
            $offer->created_by = creatorId();
            $offer->workspace  = getActiveWorkSpace();
            $offer->save();
            return redirect()->back()->with('success', __('The Offers has been created successfully.'));
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
        if (Auth::user()->isAbleTo('offers edit')) {
            $ids = decrypt($id);
            $offers = RestaurantOffer::find($ids);            
            $items = ProductService::where('type', 'restaurants')->where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->pluck('name', 'id');            
            return view('restaurant-menu::offers.edit', compact('offers', 'items'));
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
        if (Auth::user()->isAbleTo('offers edit')) {
            $offer = RestaurantOffer::find($id);

            $offer->name       = $request->name;
            $offer->discount   = $request->discount;
            $offer->start_date = $request->start_date;
            $offer->end_date   = $request->end_date;
            $offer->status     = $request->status;
            $offer->items      = isset($request->items) ? $request->items : '';
            $offer->save();
            return redirect()->back()->with('success', __('The Offers details are updated successfully.'));
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
        if (Auth::user()->isAbleTo('offers edit')) {
            $offer = RestaurantOffer::find($id);
            if ($offer) {
                $offer->delete();
                return redirect()->back()->with('success', __('The Offers has been deleted.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
