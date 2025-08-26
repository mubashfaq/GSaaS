<?php

namespace Workdo\ProductService\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\ProductService\Entities\ProductService;
use Workdo\ProductService\Entities\Unit;
use Workdo\ProductService\Entities\Discount;
use Workdo\ProductService\Events\CreateUnit;
use Workdo\ProductService\Events\DestroyUnit;
use Workdo\ProductService\Events\UpdateUnit;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if(Auth::user()->isAbleTo('unit cerate'))
        {
            return view('product-service::discount.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
       
        
          $validated_data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
           
            'discount_for' => 'required|integer', 
            'discount_type' => 'required|integer',
            'discount_value' => 'required|string',
            'from_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:from_date',
    ]);
   
    $logged_in_user = Auth::user();
    $validated_data['created_by'] = $logged_in_user->id;
     $validated_data['active'] = 1;
    $validated_data['workspace_id'] = getActiveWorkSpace();

    

    $discount = Discount::create($validated_data);
    
    // return redirect()->route('discounts.create')->with('success', 'Discount created successfully.');
    return redirect()->route('category.index')->with('success', __('The Discount has been created successfully.'));
        if(Auth::user()->isAbleTo('unit cerate'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|max:20',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $category             = new Unit();
            $category->name       = $request->name;
            $category->created_by = creatorId();
            $category->workspace_id = getActiveWorkSpace();
            $category->save();

            event(new CreateUnit($request,$category));

            return redirect()->route('category.index')->with('success', __('The unit has been created successfully.'));
        }
        else
        {
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
        return view('product-service::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        if(Auth::user()->isAbleTo('unit edit'))
        {
            $discount = Discount::find($id);
           
            return view('product-service::discount.edit',compact('discount'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
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
        if(Auth::user()->isAbleTo('unit edit'))
        {
            $discount = Discount::find($id);
            $validator = \Validator::make(
                $request->all(), [
                    'title' => 'required|string',
                    'description' => 'nullable|string',
                    'discount_for' => 'required|integer', 
                    'discount_type' => 'required|integer',
                    'discount_value' => 'required|string',
                    'from_date' => 'required|date',
                    'end_date' => 'required|date|after_or_equal:from_date',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $discount->title = $request->title;
            $discount->description = $request->description;
            $discount->active =  1 ;//$request->active;
            $discount->discount_for = $request->discount_for;
            $discount->discount_type = $request->discount_type;
            $discount->discount_value = $request->discount_value;
            $discount->from_date = $request->from_date;
            $discount->end_date = $request->end_date;
            $discount->save();

            // event(new UpdateUnit($request,$unit));

            return redirect()->route('category.index')->with('success', __('The Discount details are updated successfully.'));
        }
        else
        {
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
        if(Auth::user()->isAbleTo('unit delete'))
        {
            $discount = Discount::find($id);
            // $discount = ProductService::where('discount_id', $id)->first();
            // if(!empty($discount))
            // {
            //     return redirect()->back()->with('error', __('this discount is already assign so please move or remove this unit related data.'));
            // }
          
            $discount->delete();
            return redirect()->route('category.index')->with('success', __('The discount has been deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
