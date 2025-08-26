<?php

namespace Workdo\RestaurantMenu\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Workdo\ProductService\Entities\ProductService;
use Illuminate\Support\Facades\Auth;
use Workdo\RestaurantMenu\DataTables\ItemsDatatable;

class RestaurantMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(ItemsDatatable $dataTable)
    {
        if (Auth::user()->isAbleTo('restaurant_customer manage')) {

            return $dataTable->render('restaurant-menu::items.index');
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
        return view('restaurant-menu::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $item = ProductService::find($id);
        return view('restaurant-menu::item.show', compact('item'));
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
        //
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

    public function dashboard(){

    }
}
