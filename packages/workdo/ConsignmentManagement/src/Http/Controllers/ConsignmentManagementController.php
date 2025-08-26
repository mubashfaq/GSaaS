<?php

namespace Workdo\ConsignmentManagement\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Workdo\ConsignmentManagement\DataTables\ConsignmentDatatable;
use Workdo\ConsignmentManagement\Entities\Consignment;
use Workdo\ConsignmentManagement\Entities\ConsignmentItem;
use Workdo\ConsignmentManagement\Events\CreateConsignment;
use Workdo\ConsignmentManagement\Events\DestroyConsignment;
use Workdo\ConsignmentManagement\Events\DestroyConsignmentItem;
use Workdo\ConsignmentManagement\Events\UpdateConsignment;
use Workdo\ProductService\Entities\ProductService;

class ConsignmentManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(ConsignmentDatatable $dataTable)
    {
        if (Auth::check() && Auth::user()->isAbleTo('consignment manage')) {
            return $dataTable->render('consignment-management::consignment.index');
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
        if (Auth::check() && Auth::user()->isAbleTo('consignment create')) {

            $products = ProductService::where([['type', 'consignment'], ['created_by', creatorId()], ['workspace_id', getActiveWorkSpace()]])->pluck('name', 'id');

            $company_settings = getCompanyAllSetting();

            return view('consignment-management::consignment.create', ['products' => $products, 'company_settings' => $company_settings]);
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
        if (Auth::check() && Auth::user()->isAbleTo('consignment create')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'commission' => 'required|numeric',
                    'date' => 'required',
                    'subtotal' => 'required|numeric',
                    'totalamount' => 'required|numeric',
                    'totalTax' => 'required|numeric',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $consignment = Consignment::create([
                'title' => $request->title,
                'commission' => $request->commission,
                'date' => $request->date,
                'subtotal' => $request->subtotal,
                'totalamount' => $request->totalamount,
                'taxamount' => $request->totalTax,
                'created_by' => creatorId(),
                'workspace_id' => getActiveWorkSpace(),
            ]);

            foreach ($request->items as $item) {
                ConsignmentItem::create([
                    'consignment_id' => $consignment->id,
                    'product_id' => $item['product'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'tax' => $item['tax'],
                ]);
            }

            event(new CreateConsignment($request, $consignment));

            return redirect()->route('consignment.index')->with('success', __('The consignment has been created successfully.'));
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
        if (Auth::check() && Auth::user()->isAbleTo('consignment show')) {
            $consignment = Consignment::findOrFail($id);

            $company_settings = getCompanyAllSetting();

            $consignmentItems = ConsignmentItem::with('product')->where('consignment_id', $consignment->id)->get();

            return view('consignment-management::consignment.view', ['company_settings' => $company_settings, 'consignment' => $consignment, 'consignmentItems' => $consignmentItems]);
        } else {
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
        if (Auth::check() && Auth::user()->isAbleTo('consignment edit')) {
            $consignment = Consignment::findOrFail($id);

            $products = ProductService::where([['type', 'consignment'], ['created_by', creatorId()], ['workspace_id', getActiveWorkSpace()]])->pluck('name', 'id');

            $company_settings = getCompanyAllSetting();

            $consignmentItems = ConsignmentItem::where('consignment_id', $consignment->id)->select(['id', 'product_id as product', 'quantity', 'price', 'tax'])->get()->toArray();

            return view('consignment-management::consignment.edit', [
                'products' => $products, 'company_settings' => $company_settings, 'consignment' => $consignment, 'consignmentItems' => $consignmentItems,
            ]);
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
        if (Auth::check() && Auth::user()->isAbleTo('consignment edit')) {
            $consignment = Consignment::findOrFail($id);

            $validator = \Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'commission' => 'required|numeric',
                    'date' => 'required',
                    'subtotal' => 'required|numeric',
                    'totalamount' => 'required|numeric',
                    'totalTax' => 'required|numeric',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            try {
                DB::beginTransaction();

                $consignment->update([
                    'title' => $request->title,
                    'commission' => $request->commission,
                    'date' => $request->date,
                    'subtotal' => $request->subtotal,
                    'totalamount' => $request->totalamount,
                    'taxamount' => $request->totalTax,
                ]);

                foreach ($request->items as $item) {
                    $consignmentItem = ConsignmentItem::find($item['id']);
                    if ($consignmentItem == null) {
                        $consignmentItem = new ConsignmentItem();
                        $consignmentItem->consignment_id = $consignment->id;
                    }
                    $consignmentItem->product_id = $item['product'];
                    $consignmentItem->quantity = $item['quantity'];
                    $consignmentItem->price = $item['price'];
                    $consignmentItem->tax = $item['tax'];
                    $consignmentItem->save();
                }

                DB::commit();

                event(new UpdateConsignment($request, $consignment));

                return redirect()->route('consignment.index')->with('success', __('The consignment has been updated successfully.'));

            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->back()->with('error', $th->getMessage());

            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */

    public function ConsignmentItemDestroy(Request $request)
    {
        $consignmentitem = ConsignmentItem::where('id', '=', $request->id)->first();

        event(new DestroyConsignmentItem($request, $consignmentitem));

        $consignmentitem->delete();

        return response()->json(['success' => __('The consignment has been deleted successfully.')]);
    }

    public function destroy($id)
    {
        $consignment = Consignment::findOrFail($id);
        event(new DestroyConsignment($consignment));

        $consignment->delete();
        return redirect()->back()->with('success', __('The consignment has been deleted successfully.'));

    }

    public function getProduct(Request $request)
    {
        $consignmentProduct = ProductService::findOrFail($request->product_id);
        return response()->json(
            [
                'data' => $consignmentProduct,
            ]
        );
    }

}
