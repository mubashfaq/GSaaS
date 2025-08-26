<?php

namespace Workdo\RestaurantMenu\Http\Controllers;

use App\Models\WorkSpace;
use Google\Service\Dataproc\Session;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Workdo\ProductService\Entities\ProductService;
use Workdo\RestaurantMenu\Entities\RestaurantDiningTable;
use Workdo\RestaurantMenu\Entities\RestaurantOffer;
use Workdo\RestaurantMenu\Entities\RestaurantPlaceOrder;
use Workdo\RestaurantMenu\Entities\RestaurantSystemSet;
use Workdo\RestaurantMenu\Entities\RestaurantVarient;

class RestaurantPlaceOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($itemId,$tableId)
    {
        $diningTable = RestaurantDiningTable::find($tableId);
        $ItemType = ProductService::find($itemId);        
        $currentDate = now();
        $offers = RestaurantOffer::where('items',$ItemType->id)->where('status','active')->whereDate('start_date', '<=', $currentDate)  
        ->whereDate('end_date', '>=', $currentDate)->first();

        $discountedPrice = '';
        if($offers){
            $discountedPrice = $offers ? $ItemType->sale_price - ($ItemType->sale_price * $offers->discount / 100) : $ItemType->sale_price;
        }
        $varient = RestaurantVarient::where('item_id', $itemId)->first();
        $workspace = WorkSpace::find($ItemType->workspace_id);
        $company_id = $diningTable->created_by;
        $workspace_id = $diningTable->workspace;
        return view('restaurant-menu::placeorder.index', compact('discountedPrice','ItemType', 'varient', 'workspace','diningTable','company_id','workspace_id'));
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
    public function placeOrderStore(Request $request, $itemId,$tableId)
    {
        $item = ProductService::find($itemId);
        $currentDate = now();
        $offers = RestaurantOffer::where('items',$item->id)->where('status','active')->whereDate('start_date', '<=', $currentDate)  
        ->whereDate('end_date', '>=', $currentDate)->first();
        $discountedPrice = '';
        if($offers){
            $discountedPrice = $offers ? $item->sale_price - ($item->sale_price * $offers->discount / 100) : $item->sale_price;
        }
        $varient = RestaurantVarient::where('item_id',$itemId)->first();
        $itemAttri = RestaurantSystemSet::where('id',$varient->item_attribute)->first();
        $placeOrder = new RestaurantPlaceOrder();
        $placeOrder->quantity = $request->quantity;
        $placeOrder->varient = $request->varient;
        $placeOrder->description = $request->description;
        $placeOrder->item_id = $itemId;
        $placeOrder->total_price = isset($request->discount_price) ? $request->discount_price : $request->total_price;
        $placeOrder->created_by = $item->created_by;
        $placeOrder->workspace = $item->workspace_id;

            $placeOrder->save();
            $orderId = $placeOrder->id;

            $workspace = WorkSpace::find($item->workspace_id);
            $cart    = session()->get($workspace->slug);
            $time = time();

            $cart['products'][$time] = [
                "id" => $orderId,
                "quantity" => $request->quantity,
                "varient" => $request->varient,
                "description" => $request->description,
                "item_id" => $itemId,
                "total_price" => isset($request->discount_price) ? $request->discount_price : $request->total_price,
                "item_name" => $item->name,
                "item_image" => $item->image,
                "item_attribute" => isset($itemAttri->name) ? $itemAttri->name : '',
                "sales_price" => isset($item->sale_price) ? $item->sale_price : $discountedPrice ,
                "table_id" => $tableId,
                "tax" => $item->tax_id,
            ];
            session()->put($workspace->slug, $cart);
            return redirect()->back()->with('success', $item->name . ' ' . __('add to Cart Successfully.'));
    }


    public function storeCart($workspace,$tableId)
    {
        $workspace = WorkSpace::find($workspace);
        $company_settings = getCompanyAllSetting($workspace->created_by);

        $cart = session()->get($workspace->slug);
        $products = $cart;

        $diningTable = RestaurantDiningTable::find($tableId);
        $company_id = $diningTable->created_by;
        $workspace_id = $diningTable->workspace;
        return view('restaurant-menu::addToCart.index', compact('workspace', 'cart','products','diningTable','company_settings','company_id','workspace_id'));
    }
    public function delete_cart_item($slug, $id)
    {
        $cart = session()->get($slug);

        $index = null;
        foreach ($cart['products'] as $key => $product) {
            if ($product['id'] == $id) {
                $index = $key;
                break;
            }
        }

        if ($index !== null) {
            unset($cart['products'][$index]);
            $cart['products'] = array_values($cart['products']);
            session()->put($slug, $cart);
            return redirect()->back()->with('success', __('The item has been deleted.'));
        }

        return redirect()->back()->with('error', __('Item not found in the cart.'));
    }

}
