<?php

namespace Workdo\RestaurantMenu\Http\Controllers;

use App\Models\WorkSpace;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Workdo\RestaurantMenu\Entities\RestaurantCustomer;
use Workdo\RestaurantMenu\Entities\RestaurantDiningTable;
use Workdo\RestaurantMenu\Entities\RestaurantOrder;
use Workdo\RestaurantMenu\Entities\RestaurantPlaceOrder;

class RestaurantCartController extends Controller
{
    public function productQty(Request $request, $itemId, $workspace, $table, $key = 0)
    {
        $cart = session()->get($workspace);
        if (isset($cart['products'][$key])) {
            $cart['products'][$key]['quantity'] = $request->product_qty;
            $cart['products'][$key]['id'] = $itemId;
            foreach ($cart['products'] as $key => $value) {
                $subtotal = $cart['products'][$key]["sales_price"] * $cart['products'][$key]["quantity"];
                $cart['products'][$key]["subtotal"] = $subtotal;
            }
            session()->put($workspace, $cart);

            return response()->json(
                [
                    'code' => 200,
                    'status' => 'success',
                    'success' => $cart['products'][$key]["item_name"] . __('added to cart successfully!'),
                    'product' => $cart['products'],
                    'carttotal' => $cart['products'],
                ]
            );
        }
    }
    public function checkoutCart($workspace, $tableId, $total)
    {
        $workspace = WorkSpace::find($workspace);
        $diningTable = RestaurantDiningTable::find($tableId);
        $company_id = $diningTable->created_by;
        $workspace_id = $diningTable->workspace;
        return view('restaurant-menu::checkout.index', compact('workspace', 'diningTable', 'total', 'company_id', 'workspace_id'));
    }
    public function destroy($workspace, $tableId, $id)
    {
        $workspace = WorkSpace::find($workspace);
        $cart = session()->get($workspace->slug);

        foreach ($cart['products'] as $key => $product) {
            if ($product['id'] == $id) {
                unset($cart['products'][$key]);
                break;
            }
        }

        $cart['products'] = array_values($cart['products']);

        session()->put($workspace->slug, $cart);

        return redirect()->back()->with('success', __('The product has been deleted.'));
    }

}
