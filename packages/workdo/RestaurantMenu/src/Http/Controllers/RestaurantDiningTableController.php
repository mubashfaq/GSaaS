<?php

namespace Workdo\RestaurantMenu\Http\Controllers;

use App\Models\WorkSpace;
use Google\Service\Area120Tables\Resource\Workspaces;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\ProductService\Entities\Category;
use Workdo\ProductService\Entities\ProductService;
use Workdo\RestaurantMenu\DataTables\DiningtableDatatable;
use Workdo\RestaurantMenu\Entities\RestaurantCategory;
use Workdo\RestaurantMenu\Entities\RestaurantDiningTable;
use Workdo\RestaurantMenu\Events\CreateDiningTable;
use Workdo\RestaurantMenu\Events\UpdateDiningTable;
use Zxing\QrReader;

class RestaurantDiningTableController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(DiningtableDatatable $dataTable)
    {
        if (Auth::user()->isAbleTo('dining_table manage')) {

            return $dataTable->render('restaurant-menu::diningtable.index');
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
        if (Auth::user()->isAbleTo('dining_table create')) {
        return view('restaurant-menu::diningtable.create');
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
        if (Auth::user()->isAbleTo('dining_table create')) {
            $rules = [
                'name' => 'required',
                'size' => 'required',
                'status' => 'required',
            ];

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $diningTable             = new RestaurantDiningTable();
            $diningTable->name       = $request->name;
            $diningTable->status     = $request->status;
            $diningTable->size       = $request->size;
            $diningTable->created_by = creatorId();
            $diningTable->workspace  = getActiveWorkSpace();
            $diningTable->save();
            event(new CreateDiningTable($request,$diningTable));
            return redirect()->back()->with('success', __('The dining table has been created successfully.'));
            }else{
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
        if (Auth::user()->isAbleTo('dining_table edit')) {
            $diningTable = RestaurantDiningTable::find($id);
            $workspaceSlug = WorkSpace::find($diningTable->workspace);

        return view('restaurant-menu::diningtable.show',compact('diningTable','workspaceSlug'));
        }else{
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        if (Auth::user()->isAbleTo('dining_table edit')) {
            $ids = decrypt($id);
            $diningTable = RestaurantDiningTable::find($ids);
        return view('restaurant-menu::diningtable.edit',compact('diningTable'));
        }else{
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
        if (Auth::user()->isAbleTo('dining_table edit')) {
            $diningTable = RestaurantDiningTable::find($id);

            $diningTable->name       = $request->name;
            $diningTable->status     = $request->status;
            $diningTable->size       = $request->size;
            $diningTable->save();
            event(new UpdateDiningTable($request,$diningTable));
            return redirect()->back()->with('success', __('The dining table details are updated successfully.'));
            }else{
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
        if (Auth::user()->isAbleTo('dining_table delete')) {
            $diningTable = RestaurantDiningTable::find($id);
            if($diningTable){
                $diningTable->delete();
            return redirect()->back()->with('success', __('The dining table has been deleted.'));
            }
        }else{
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function qrReader($workspace,$tableId)
    {
        $diningTable = RestaurantDiningTable::find($tableId);
        if(!empty($diningTable))
        {
            if($diningTable->status != 'Inactive' ){
                $categories = RestaurantCategory::where('created_by', '=', $diningTable->created_by)->where('workspace_id', '=',  $diningTable->workspace)->with('items')->get();
                $workspace = WorkSpace::find($diningTable->workspace);
                $company_id = $diningTable->created_by;
                $workspace_id = $diningTable->workspace;
                return view('restaurant-menu::diningtable.qrReader',compact('diningTable','categories','workspace','company_id','workspace_id'));
            }else{
                $categories = RestaurantCategory::where('created_by', '=', $diningTable->created_by)->where('workspace_id', '=',  $diningTable->workspace)->with('items')->get();
                $workspace = WorkSpace::find($diningTable->workspace);
                $company_id = $diningTable->created_by;
                $workspace_id = $diningTable->workspace;
                return view('restaurant-menu::diningtable.notFound',compact('diningTable','categories','workspace','company_id','workspace_id'));

            }
        }
        else{
            return redirect()->back()->with('error', __('Dining Table Not Found.'));
        }
    }
}
