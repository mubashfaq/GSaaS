<?php

namespace Workdo\Pos\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Rawilk\Settings\Support\Context;
use App\Models\Purchase;
use App\Models\RegisterLog;
use App\Models\Warehouse;
use Workdo\Pos\Entities\Pos;
use App\Models\WarehouseProduct;
use Workdo\Pos\Entities\PosProduct;
use Workdo\Pos\Entities\PosPayment;
use Workdo\Pos\Entities\PosUtility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\Setting;
use App\Models\WorkSpace;
use Workdo\Pos\DataTables\PosOrderDataTable;
use Workdo\ProductService\Entities\ProductService;
use DB;
use Workdo\Pos\Events\CreatePaymentPos;
use Stripe\Product;
use Workdo\Pos\DataTables\BarcodeDataTable;
use Workdo\Quotation\Entities\Quotation;
use Workdo\Quotation\Entities\QuotationProduct;
use Workdo\Account\Entities\Customer;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Workdo\Pos\Http\Controllers\JsonResponse;
use Session ;
class PosController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
   
    public function __construct()
    {
        if(module_is_active('GoogleAuthentication'))
        {
            $this->middleware('2fa');
        }
    }
    
    public function index(Request $request)
    {
       
        if (\Auth::user()->isAbleTo('pos add manage'))
        {
            $currentRegister = RegisterLog::whereNull('closed_at')->where('created_by', creatorId())->where('workspace',getActiveWorkSpace())->first();
            if(!$currentRegister)
            {
               return redirect()->route('register.index')
            ->with('success', 'Opening cash is required. Please open your register before starting the POS');
            }
            session()->forget('pos');
            $customers=[];
            $customers      = User::where('type','client')->where('created_by', creatorId())->where('workspace_id',getActiveWorkSpace())->get()->pluck('name', 'name');
            $customers->prepend('Walk-in-customer', 'Walk-in-customer');
            $user = \Auth::user();

            $details = [
                'pos_id' =>Pos::posNumberFormat($this->invoicePosNumber()),
                'customer' => $customers != null ? $customers->toArray() : [],
                'user' => $user != null ? $user->toArray() : [],
                'date' => date('Y-m-d'),
                'pay' => 'show',
            ];
            $warehouses = warehouse::select('*', \DB::raw("CONCAT(name) AS name"))->where('created_by', creatorId())->where('workspace',getActiveWorkSpace())->get()->pluck('name', 'id');

            $cart = session()->get('pos');
            if (isset($cart) && count($cart) > 0)
            {
                if(module_is_active('ProductService'))
                {
                     $product = \Workdo\ProductService\Entities\ProductService::where('created_by', creatorId())->where('workspace_id',getActiveWorkSpace())->whereIn('id',array_keys($cart))->get();
                    if(count($product) == 0)
                    {
                        session()->forget('pos');
                    }
                }
            }

            if (isset($request->quotation_id)) {
                $quotation = Quotation::find($request->quotation_id);
                $customer = '';
                $warehouseId = '';
                if($quotation)
                {
                    $customer= Customer::where('user_id',$quotation->customer_id)->first();
                    if(empty($customer))
                    {
                        $customer = User::find($quotation->customer_id);
                    }
                    $customer = $customer->name;

                    $warehouseId = $quotation->warehouse_id;

                    $quotationProduct = QuotationProduct::where('quotation_id', $request->quotation_id)->get();

                    foreach ($quotationProduct as $value) {
                        $products = Quotation::quotationProduct($value);
                    }
                }
            } else {
                $customer = '';
                $warehouseId = '';
            }

            $id = !empty($request->quotation_id) ? $request->quotation_id : '0';

            return view('pos::pos.index',compact('customers','warehouses','details','customer', 'warehouseId', 'id'));        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        // Initialize cart session and get current workspace
        $this->initCartSession();
        $workspaceId = $this->getCurrentWorkspaceId();
        
        // Get the specific cart ID from request or use active cart
        $cartId = $request->input('cart_id');
        if (!$cartId) {
            $cartId = Session::get("active_pos_cart_{$workspaceId}");
            if (!$cartId) {
                $cartId = $this->getDefaultCartId($workspaceId);
            }
        }
        
        // Get all carts and the specific cart items
        $allCarts = Session::get('pos_carts');
        $sess = null;
        
        if (isset($allCarts[$workspaceId][$cartId]['items'])) {
            $sess = $allCarts[$workspaceId][$cartId]['items'];
        }
        
        if (Auth::user()->isAbleTo('pos manage') && isset($sess) && !empty($sess) && count($sess) > 0) {
            $user = Auth::user();
    
            if(module_is_active('Account'))
            {
                $user =  User::where('name', '=', $request->vc_name)->where('type','client')->where('created_by', creatorId())->where('workspace_id',getActiveWorkSpace())->first();
                if(!empty($user->id))
                {
                    $customer = \Workdo\Account\Entities\Customer::where('user_id',$user->id)->where('name', '=', $request->vc_name)->where('created_by', creatorId())->where('workspace',getActiveWorkSpace())->first();
                    if(!empty($customer)){
                        $customer = $customer;
                    }
                    else{
                        $customer = $user;
                    }
                }
                else{
                    $customer = NULL;
                    $user = Auth::user();
                }
            }
            else
            {
                $customer = User::where('name', '=', $request->vc_name)->where('type','client')->where('created_by', creatorId())->where('workspace_id',getActiveWorkSpace())->first();
            }
            
            $user = \Auth::user();
            $warehouse = warehouse::where('id', '=', $request->warehouse_name)->where('created_by', creatorId())->where('created_by', creatorId())->where('workspace',getActiveWorkSpace())->first();
    
            $details = [
                'pos_id' => Pos::posNumberFormat($this->invoicePosNumber()),
                'customer' => $customer != null ? $customer->toArray() : [],
                'warehouse' => $warehouse != null ? $warehouse->toArray() : [],
                'user' => $user != null ? $user->toArray() : [],
                'date' => date('Y-m-d'),
                'pay' => 'show',
                'cart_id' => $cartId, // Add cart ID to details
                'payment_types' => [
                    'cash' => __('Cash'),
                    'bank' => __('Bank Transfer'),
                    'card' => __('Card'),
                    'jazzcash' => __('JazzCash'),
                    'easypaisa' => __('Easy Paisa'),
                    'other' => __('Other'),
                ],
            ];
            
            if (!empty($details['customer']['billing_state']))
            {
                $warehousedetails = '<h7 class="text-dark">' . ucfirst($details['warehouse']['name'])  . '</p></h7>';
                $details['customer']['billing_state'] = $details['customer']['billing_state'] != '' ? ", " . $details['customer']['billing_state'] : '';
                $details['customer']['shipping_state'] = $details['customer']['shipping_state'] != '' ? ", " . $details['customer']['shipping_state'] : '';
    
                $customerdetails = '<h6 class="text-dark">' . ucfirst($details['customer']['name']) . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['billing_phone'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['billing_address'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['billing_city'] . $details['customer']['billing_state'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['billing_country'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['billing_zip'] . '</p></h6>';
    
                $shippdetails = '<h6 class="text-dark"><b>' . ucfirst($details['customer']['name']) . '</b>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['shipping_phone'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['shipping_address'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['shipping_city'] . $details['customer']['shipping_state'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['shipping_country'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['shipping_zip'] . '</p></h6>';
            }
            else {
                if (!empty($details['customer']))
                {
                    $customerdetails = '<h6 class="text-dark">' . ucfirst($details['customer']['name']) .  '</p></h6>';
                }
                else{
                    $customerdetails = '<h2 class="h6"><b>' . __('Walk-in Customer') . '</b><h2>';
                }
                $warehousedetails = '<h7 class="text-dark">' . ucfirst($details['warehouse']['name'])  . '</p></h7>';
                $shippdetails = '-';
            }
    
            $settings['company_telephone'] = company_setting('company_telephone') != '' ? ", " . company_setting('company_telephone') : '';
            $settings['company_state']     = company_setting('company_state') != '' ? ", " . company_setting('company_state') : '';
    
            $userdetails = '<h6 class="text-dark"><b>' . ucfirst($details['user']['name']) . ' </b> <h2  class="font-weight-normal">' . '<p class="m-0 font-weight-normal">' . company_setting('company_name') . '</p>' . '<p class="m-0 font-weight-normal">' . company_setting('company_telephone') . '</p>' . '<p class="m-0 font-weight-normal">' . company_setting('company_address') . '</p>' . '<p class="m-0 h6 font-weight-normal">' . company_setting('company_city') . ', ' . company_setting('company_state') . '</p>' . '<p class="m-0 font-weight-normal">' . company_setting('company_country') . '</p>' . '<p class="m-0 font-weight-normal">' . company_setting('company_zipcode') . '</p></h2>';
    
            $details['customer']['details'] = $customerdetails;
            $details['warehouse']['details'] = $warehousedetails;
            $details['customer']['shippdetails'] = $shippdetails;
            $details['user']['details'] = $userdetails;
    
            $mainsubtotal = 0;
            $tdiscount   = 0;
            $sales        = [];
            
            foreach ($sess as $key => $value) {
                $subtotal = $value['price'] * $value['quantity'];
                $tax      = ($subtotal * $value['tax']) / 100;
                $sales['data'][$key]['name']       = $value['name'];
                $sales['data'][$key]['quantity']   = $value['quantity'];
                $sales['data'][$key]['price'] = currency_format_with_sym(!empty($value['original_price']) ? $value['original_price'] : $value['price']);
                $sales['data'][$key]['tax']        = $value['tax'] . '%';
                $sales['data'][$key]['product_tax'] = $value['product_tax'];
                $sales['data'][$key]['tax_amount'] = currency_format_with_sym($tax);
                $sales['data'][$key]['subtotal']   = currency_format_with_sym($value['subtotal']);
                $sales['data'][$key]['discount']   = currency_format_with_sym($value['total_discount']);
                $mainsubtotal                      += $value['subtotal'];
                $tdiscount                        += $value['total_discount'];
            }
    
            if($request->discount <= $mainsubtotal){
                $discount=!empty($request->discount)?$request->discount:0;
            }
            else{
                $discount=$mainsubtotal;
            }
    
            $sales['discount'] = currency_format_with_sym($tdiscount);
            $total= $mainsubtotal-$discount;
            $sales['sub_total'] = currency_format_with_sym($mainsubtotal);
            $sales['total'] = currency_format_with_sym($total);
            
            return view('pos::pos.show', compact('sales', 'details'));
        } else {
            return response()->json(
                [
                    'error' => __('Add some products to cart!'),
                ],
                '404'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $discount = (!empty($request->discount) && $request->discount > 0) ? $request->discount : 0;
        
        if (Auth::user()->isAbleTo('pos manage')) {
            
            if ($request->quotation_id != 0) {
                $quotation = Quotation::where('id', $request->quotation_id)->first();
                $quotation->is_converted = 1;
                $quotation->save();
            }
            
            $user_id = creatorId();
            $customer_id = Pos::customer_id($request->vc_name);
            $warehouse_id = warehouse::warehouse_id($request->warehouse_name);
            $pos_id = $this->invoicePosNumber();
            
            // Get cart data from multi-cart system
            $this->initCartSession();
            $workspaceId = $this->getCurrentWorkspaceId();
            
            // Get the specific cart ID from request or use active cart
            $cartId = $request->input('cart_id');
            if (!$cartId) {
                $cartId = Session::get("active_pos_cart_{$workspaceId}");
                if (!$cartId) {
                    $cartId = $this->getDefaultCartId($workspaceId);
                }
            }
            
            // Get all carts and the specific cart items
            $allCarts = Session::get('pos_carts');
            $sales = null;
            
            if (isset($allCarts[$workspaceId][$cartId]['items'])) {
                $sales = $allCarts[$workspaceId][$cartId]['items'];
            }
            
            if (isset($sales) && !empty($sales) && count($sales) > 0) {
                $result = DB::table('pos')->where('pos_id', $pos_id)->where('created_by', $user_id)->where('workspace', getActiveWorkSpace())->get();
                
                if (count($result) > 0) {
                    return response()->json([
                        'code' => 200,
                        'success' => __('Payment is already completed!'),
                    ]);
                } else {
                    $pos = new Pos();
                    $pos->pos_id = $pos_id;
                    $pos->customer_id = $customer_id;
                    $pos->warehouse_id = $request->warehouse_name;
                    $pos->workspace = getActiveWorkSpace();
                    $pos->pos_date = date('Y-m-d');
                    $pos->created_by = $user_id;
                    $pos->payment_type = $request->payment_type ?? 'cash';
                    $pos->save();
    
                    if ($request->quotation_id != 0) {
                        $quotation->converted_pos_id = $pos->id;
                        $quotation->save();
                    }
    
                    foreach ($sales as $key => $value) {
                        $product_id = $value['id'];
                        $product = \Workdo\ProductService\Entities\ProductService::whereId($product_id)->where('created_by', $user_id)->where('workspace_id', getActiveWorkSpace())->first();
                        $original_quantity = ($product == null) ? 0 : (int)$product->quantity;
                        $product_quantity = $original_quantity - $value['quantity'];
                        
                        if ($product != null && !empty($product)) {
                            \Workdo\ProductService\Entities\ProductService::where('id', $product_id)->update(['quantity' => $product_quantity]);
                        }
                        
                        // FIFO
                        $remaining = $value['quantity'];
                        $batches = DB::table('purchase_product_batches')
                            ->where('product_id', $product_id)
                            ->where('rem_quantity', '>', 0)
                            ->where('workspace', getActiveWorkSpace())
                            ->orderBy('created_at', 'asc')
                            ->get();
    
                        foreach ($batches as $batch) {
                            if ($remaining <= 0) break;
    
                            $deduct = min($remaining, $batch->rem_quantity);
                            DB::table('purchase_product_batches')
                                ->where('id', $batch->id)
                                ->update(['rem_quantity' => DB::raw("rem_quantity - $deduct")]);
    
                            // Save separate PosProduct entry for each batch used
                            $tax_id = Pos::tax_id($product_id);
                            $positems = new PosProduct();
                            $positems->pos_id = $pos->id;
                            $positems->product_id = $product_id;
                            $positems->original_price = !empty($value['original_price']) ? $value['original_price'] : $value['price'];
                            $positems->price = $value['price']; // Optional: override if batch-specific price exists
                            $positems->quantity = $deduct;
                            $positems->tax = $tax_id;
                            $positems->tex_price = !empty($value['tax_price']) ? $value['tax_price'] : 0;
                            $positems->discount = $value['total_discount'];
                            $positems->batch_no = $batch->batch_no ?? 'BATCH-' . Str::random(6); // Make sure your PosProduct table has this column
                            $positems->workspace = getActiveWorkSpace();
                            $positems->save();
                            
                            Pos::warehouse_quantity('minus', $positems->quantity, $positems->product_id, $request->warehouse_name);
                            $remaining -= $deduct;
                        }
    
                        if (module_is_active('Account')) {
                            $type = 'Pos';
                            $type_id = $pos->id;
                            \Workdo\Account\Entities\StockReport::where('type', '=', 'pos')->where('type_id', '=', $pos->id)->delete();
                            $description = $positems->quantity . '  ' . __(' quantity sold in pos') . ' ' . Pos::posNumberFormat($pos->pos_id);
                            Pos::addProductStock($positems->product_id, $positems->quantity, $type, $description, $type_id);
                        }
                    }
    
                    $posPayment = new PosPayment();
                    $posPayment->pos_id = $pos->id;
                    $posPayment->date = $request->date;
                    $posPayment->payment_type = $request->payment_type ?? 'cash';
                    
                    $mainsubtotal = 0;
                    $salesData = [];
                    
                    // Use the cart items we already retrieved
                    if (isset($sales) && !empty($sales) && count($sales) > 0) {
                        foreach ($sales as $key => $value) {
                            $subtotal = $value['price'] * $value['quantity'];
                            $tax = ($subtotal * $value['tax']) / 100;
                            $salesData['data'][$key]['price'] = currency_format_with_sym($value['price']);
                            $salesData['data'][$key]['tax'] = $value['tax'] . '%';
                            $salesData['data'][$key]['tax_amount'] = currency_format_with_sym($tax);
                            $salesData['data'][$key]['subtotal'] = currency_format_with_sym($value['subtotal']);
                            $mainsubtotal += $value['subtotal'];
                        }
                    }
                    
                    $amount = $mainsubtotal;
                    $posPayment->amount = $amount;
                    $total = $mainsubtotal - $discount;
                    $posPayment->discount = $discount;
                    $posPayment->discount_amount = $total;
                    $posPayment->workspace = getActiveWorkSpace();
                    $posPayment->created_by = creatorId();
                    $posPayment->save();
                    
                    event(new CreatePaymentPos($request, $posPayment, $pos));
                    
                    // Clear the specific cart after successful payment
                    $this->clearCart($workspaceId, $cartId);
                    
                    return response()->json([
                        'code' => 200,
                        'success' => __('Payment completed successfully!'),
                    ]);
                }
            } else {
                return response()->json([
                    'code' => 404,
                    'success' => __('Items not found!'),
                ]);
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Helper method to clear a specific cart after successful payment
     */
    private function clearCart($workspaceId, $cartId)
    {
        $allCarts = Session::get('pos_carts');
        
        if (isset($allCarts[$workspaceId][$cartId])) {
            $cartData = $allCarts[$workspaceId][$cartId];
            $isDefaultCart = isset($cartData['is_default']) && $cartData['is_default'] === true;
            
            if ($isDefaultCart) {
                // For default cart, just clear items but keep the cart
                $allCarts[$workspaceId][$cartId]['items'] = [];
                $allCarts[$workspaceId][$cartId]['updated_at'] = now();
                Session::put('pos_carts', $allCarts);
                
                // Keep default cart as active
                Session::put("active_pos_cart_{$workspaceId}", $cartId);
            } else {
                // For non-default cart, delete the entire cart
                unset($allCarts[$workspaceId][$cartId]);
                Session::put('pos_carts', $allCarts);
                
                // Handle active cart switching
                $activeCartId = Session::get("active_pos_cart_{$workspaceId}");
                if ($activeCartId === $cartId) {
                    // Find default cart first
                    $defaultCartId = $this->findDefaultCart($workspaceId);
                    
                    if ($defaultCartId) {
                        // Switch to default cart
                        Session::put("active_pos_cart_{$workspaceId}", $defaultCartId);
                    } else {
                        // No default cart found, create one
                        $newDefaultCartId = $this->createDefaultCart($workspaceId);
                        Session::put("active_pos_cart_{$workspaceId}", $newDefaultCartId);
                    }
                }
            }
        }
    }
    
    private function findDefaultCart($workspaceId)
    {
        $allCarts = Session::get('pos_carts');
        
        if (isset($allCarts[$workspaceId])) {
            foreach ($allCarts[$workspaceId] as $cartId => $cartData) {
                if (isset($cartData['is_default']) && $cartData['is_default'] === true) {
                    return $cartId;
                }
            }
        }
        
        return null;
    }

    function invoicePosNumber()
    {
        if (\Auth::user()->isAbleTo('pos add manage')) {
            $latest = Pos::where('created_by', creatorId())->latest()->first();


            return $latest ? $latest->pos_id + 1 : 1;
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    function report(PosOrderDataTable $dataTable)
    {
        if(\Auth::user()->isAbleTo('pos add manage'))
        {

            // $posPayments = Pos::where('created_by', creatorId())->where('workspace',getActiveWorkSpace())->with('customer','warehouse','posPayment')->get();
            return $dataTable->render('pos::pos.report');

            // return view('pos::pos.report',compact('posPayments'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

    }
    
    public function getProductCategories()
    {
        $cat = Pos::getallCategories();


        $all_products = Pos::getallproducts()->count();
        $html = '<div class="zoom-in me-2">
                  <div class="card rounded-1 card-stats mb-0 cat-active overflow-hidden" data-id="0">
                     <div class="category-select" data-cat-id="0">
                        <button type="button" class="btn tab-btns btn-primary">'.__("All Categories").'</button>
                     </div>
                  </div>
               </div>';
        foreach ($cat as $key => $c) {
            $dcls = 'category-select';
            $html .= ' <div class="zoom-in cat-list-btn me-2">
                          <div class="card rounded-1 card-stats mb-0 overflow-hidden " data-id="'.$c->id.'">
                             <div class="'.$dcls.'" data-cat-id="'.$c->id.'">
                                <button type="button" class="btn tab-btns -backdrop-hue-rotate-15 ">'.$c->name.'</button>
                             </div>
                          </div>
                       </div>';
        }
        return Response($html);
    }
    
    public function searchProducts(Request $request)
    {
      
        $lastsegment = $request->session_key;
        if (\Auth::user()->isAbleTo('pos add manage') && $request->ajax() && isset($lastsegment) && !empty($lastsegment)) {
            // if(isset($request->cat_id) && $request->cat_id == 0)
            // {
            //     $cart = session()->get($lastsegment);
            //     if (isset($cart) && count($cart) > 0)
            //     {
            //         session()->forget($lastsegment);
            //     }
            // }
            $output = "";
            if($request->war_id == '0')
            {
                $ids = WarehouseProduct::where('warehouse_id',1)->get()->pluck('product_id')->toArray();
                if ($request->cat_id !== '' && $request->search == '')
                {
                    
                    if($request->cat_id == '0')
                    {
                        $products = Pos::getallproducts()->whereIn('product_services.id',$ids)->get();

                    }else{
                        $products = Pos::getallproducts()->where('category_id', $request->cat_id)->whereIn('product_services.id',$ids)->get();
                    }
                } else {
                    if($request->cat_id == '0'){
                      
                         $products = Pos::getallproducts()->where('product_services.name', 'LIKE', "%{$request->search}%")->get();
                        // dd($products);
                        // $products = Pos::getallproducts()->where('product_services.name', 'LIKE', "%{$request->search}%")->whereIn('product_services.id',$ids)->get();
                    }else{
                       
                        $products = Pos::getallproducts()->where('product_services.name', 'LIKE', "%{$request->search}%")->orWhere('category_id', $request->cat_id)->get();
                        // $products = Pos::getallproducts()->where('product_services.name', 'LIKE', "%{$request->search}%")->whereIn('product_services.id',$ids)->where('category_id', $request->cat_id)->get();
                    }

                }
            }else{
            //   dd($request->all());
                $ids = WarehouseProduct::where('warehouse_id',$request->war_id)->get()->pluck('product_id')->toArray();
                if($request->cat_id == '' || $request->cat_id == '0')
                {
                    //  $products = Pos::getallproducts()->where('product_services.name', 'LIKE', "%{$request->search}%")->get();
                    $products = Pos::getallproducts()->where('product_services.name', 'LIKE', "%{$request->search}%")->whereIn('product_services.id',$ids)->get();

                }else{
                    $products = Pos::getallproducts()->where('product_services.name', 'LIKE', "%{$request->search}%")->where('category_id', $request->cat_id)->whereIn('product_services.id',$ids)->get();
                }
            }
            // dd($products[1]);
            if (count($products)>0)
            {
                 foreach ($products as $key => $product) {
                    //   $quantity = 4;
                    $quantity = $product->warehouseProduct($product->id, $request->war_id != 0 ? $request->war_id : 1);
                    $unit = (!empty($product) && !empty($product->unit())) ? $product->unit()->name : '';
                    $discountTitle = (!empty($product->discount)) ? $product->discount->title : '';
                
                    $discountData = $product->discount_data;
                    $discountedPrice = $discountData['discounted_price'] ?? null;
                    $originalPrice = $discountData['original_price'] ?? null;
                    $discountType = $discountData['discount_type'] ?? null;
                    $discountValue = $discountData['discount_value'] ?? null;
                
                    $discountLabel = '';
                    if ($discountType !== null) {
                        $discountLabel = $discountType == 0 ? "{$discountValue}% Off" : currency_format_with_sym($discountValue) . ' Off';
                    }
                
                    $image_url = check_file($product->image)
                        ? $product->image
                        : asset('packages/workdo/ProductService/src/Resources/assets/image/img01.jpg');
                
                    if ($request->session_key == 'purchases') {
                        $productprice = $product->purchase_price ?? 0;
                    } elseif ($request->session_key == 'pos') {
                        $productprice = $product->sale_price ?? 0;
                    } else {
                        $productprice = $product->sale_price ?? $product->purchase_price;
                    }
                
                    $output .= '
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="tab-pane fade show active toacart w-100" data-url="' . url('add-to-cart/' . $product->id . '/' . $lastsegment . '/' . $request->war_id) . '">
                                <div class="position-relative card">
                                    <div class="card-image">
                                        <img alt="Image placeholder" src="' . get_file($image_url) . '" class="avatar shadow hover-shadow-lg">
                                        <p class="top-badge badge p-2 badge-danger mb-0">' . $quantity . ' ' . $unit .  '</p>
                                        
                                    </div>
                                    <div class="p-0 custom-card-body card-body d-flex ">
                                        <div class="card-body p-3 text-left card-bottom-content">
                                            <h6 class="mb-2 text-dark product-title-name">' . $product->name . '</h6>';
                
                    if ($discountedPrice !== null) {
                        $output .= '
                            <p class="mb-0 text-danger">
                                <del>' . currency_format_with_sym($originalPrice) . '</del>
                                <strong class="badge bg-success p-2">' . currency_format_with_sym($discountedPrice) . '</strong>
                                <span class="badge bg-warning text-dark ms-2">' . $discountLabel . '</span>
                            </p>';
                    } else {
                        $output .= '
                            <p class="badge bg-primary p-2 mb-0">' . currency_format_with_sym($productprice) . '</p>';
                    }
                
                    $output .= '
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }

                return Response($output);
            } else {
                $output='<div class="card card-body col-12 text-center">
                    <h5>'.__("No Product Available").'</h5>
                    </div>';
                return Response($output);
            }
        }
    }
    
    public function addToCart(Request $request, $id, $session_key, $war)
    {
        if (Auth::user()->isAbleTo('pos cart manage') && $request->ajax()) {
            $product = \Workdo\ProductService\Entities\ProductService::find($id);
            $cartId = $request->input('cart_id'); // Get the specific cart ID
            
            $productquantity = 0;
    
            if ($product) {
                $productquantity = $product->warehouseProduct($product->id, $war != 0 ? $war : 1);
            }
    
            if (!$product || ($session_key == 'pos' && $productquantity == 0)) {
                return response()->json(
                    [
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ],
                    404
                );
            }
    
            $productname = $product->name;
    
            // Get discount data similar to search product function
            $discountData = $product->discount_data;
            $discountedPrice = $discountData['discounted_price'] ?? null;
            $originalPrice = $discountData['original_price'] ?? null;
            $discountType = $discountData['discount_type'] ?? null;
            $discountValue = $discountData['discount_value'] ?? null;
          
            // Set the price based on session key
            if ($session_key == 'purchases') {
                $productprice = $product->purchase_price != 0 ? $product->purchase_price : 0;
            } else if ($session_key == 'pos') {
                // For POS, apply discount if available
                if ($discountedPrice !== null) {
                    $productprice = $discountedPrice;
                } else {
                    $productprice = $product->sale_price != 0 ? $product->sale_price : 0;
                }
            } else {
                // For other cases, apply discount if available
                if ($discountedPrice !== null) {
                    $productprice = $discountedPrice;
                } else {
                    $productprice = $product->sale_price != 0 ? $product->sale_price : $product->purchase_price;
                }
            }
    
            $originalquantity = (int)$productquantity;
            $taxes = \Workdo\Pos\Entities\Pos::tax($product->tax_id);
            $totalTaxRate = \Workdo\Pos\Entities\Pos::totalTaxRate($product->tax_id);
            $product_tax = '';
            $product_tax_id = [];
            
            foreach($taxes as $tax) {
                $product_tax .= !empty($tax) ? "<span class='badge badge-primary'>". $tax->name.' ('.$tax->rate.'%)'."</span><br>" : '';
                $product_tax_id[] = $tax->id;
            }
    
            if(empty($product_tax)) {
                $product_tax = "-";
            }
    
            $producttax = $totalTaxRate;
            $tax = ($productprice * $producttax) / 100;
            $subtotal = $productprice + $tax;
            
            // Calculate and store image URL
            $image_url = (check_file($product->image) && get_file($product->image)) ? $product->image : asset('packages/workdo/ProductService/src/Resources/assets/image/img01.jpg');
            
            // Handle multi-cart system
            if ($session_key == 'pos') {
                $this->initCartSession();
                $workspaceId = $this->getCurrentWorkspaceId();
                $allCarts = Session::get('pos_carts');
                
                // If no specific cart ID provided, use active cart
                if (!$cartId) {
                    $cartId = Session::get("active_pos_cart_{$workspaceId}");
                    if (!$cartId) {
                        $cartId = $this->getDefaultCartId($workspaceId);
                    }
                }
                
                // Validate cart exists
                if (!isset($allCarts[$workspaceId][$cartId])) {
                    return response()->json([
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('Cart not found!'),
                    ], 404);
                }
                
                $cart = $allCarts[$workspaceId][$cartId]['items'];
            } else {
                // For non-POS sessions, use the old system
                $cart = session()->get($session_key);
            }
    
            $model_delete_id = 'delete-form-' . $id;
    
            // Create discount display HTML
            $priceHtml = '';
            $discountLabel = '';
            
            if ($discountedPrice !== null && $originalPrice !== null) {
                if ($discountType == 0) {
                    $discountLabel = "<span class='badge bg-warning text-dark'>{$discountValue}% Off</span>";
                } else {
                    $discountLabel = "<span class='badge bg-warning text-dark'>" . currency_format_with_sym($discountValue) . " Off</span>";
                }
                
                $priceHtml = '<span><del>' . currency_format_with_sym($originalPrice) . '</del> ' . 
                              currency_format_with_sym($productprice) . ' ' . $discountLabel . '</span>';
                            
            } else {
                $priceHtml = currency_format_with_sym($productprice);
            }
    
            // Generate cart HTML
            $carthtml = $this->generateCartItemHtml($id, $productname, $image_url, $productquantity, $product_tax, $priceHtml, $subtotal, $model_delete_id, $session_key, $cartId);
    
            // Create cart item data structure
            $cartItemData = [
                "name" => $productname,
                "quantity" => 1,
                "price" => $productprice,
                "id" => $id,
                "image" => $image_url, // Store image in session
                "tax_price" => $tax,
                "tax" => $producttax,
                "subtotal" => $subtotal,
                "originalquantity" => $originalquantity,
                "product_tax" => $product_tax,
                "product_tax_id" => !empty($product_tax_id) ? implode(',', $product_tax_id) : 0,
                "discount_type" => $discountType,
                "discount_value" => $discountValue,
                "original_price" => $originalPrice,
                "total_discount" => $originalPrice && $discountedPrice ? ($originalPrice - $discountedPrice) : 0,
            ];
    
            // Handle cart logic
            if (!$cart) {
                // Create new cart
                $cart = [$id => $cartItemData];
                
                if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'pos') {
                    return response()->json([
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ], 404);
                }
                if ($session_key == 'pos' && $allCarts && $workspaceId) {
                $totalQuantityInAllCarts = $this->getTotalQuantityAcrossAllCarts($id, $allCarts, $workspaceId);
                if ($originalquantity <= $totalQuantityInAllCarts) {
                    return response()->json([
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock. All available units are already in other carts.'),
                    ], 404);
                    // 'error' => __('This product is out of stock! Total available: ' . $originalquantity . ', Total in all carts: ' . $totalQuantityInAllCarts),
                }
            } else if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'pos') {
                return response()->json([
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This product is out of stock!'),
                ], 404);
            }
    
                $this->saveCart($session_key, $cart, $allCarts, $workspaceId, $cartId);
                
                $totalWithoutDiscount = $this->calculateTotalWithoutDiscount($cart);
                return response()->json([
                    'code' => 200,
                    'status' => 'Success',
                    'success' => $productname . __(' added to cart successfully!'),
                    'product' => $cart[$id],
                    'carthtml' => $carthtml,
                    'totalWithoutDiscount' => currency_format_with_sym($totalWithoutDiscount),
                    'cart_id' => $cartId ?? null,
                ]);
            }
    
            // If cart not empty then check if this product exists then increment quantity
            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
                $cart[$id]['id'] = $id;
                $cart[$id]['image'] = $image_url; // Update image in session
                
                // Recalculate totals based on new quantity
                $subtotal = $cart[$id]["price"] * $cart[$id]["quantity"];
                $tax = ($subtotal * $cart[$id]["tax"]) / 100;
    
                $cart[$id]["subtotal"] = $subtotal + $tax;
                $cart[$id]["tax_price"] = $tax;
                $cart[$id]["originalquantity"] = $originalquantity;
                $cart[$id]["total_discount"] = $originalPrice && $discountedPrice ? ($originalPrice - $discountedPrice) * $cart[$id]['quantity'] : 0;
                
                if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'pos') {
                    return response()->json([
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ], 404);
                }
                if ($session_key == 'pos' && $allCarts && $workspaceId) {
            $totalQuantityInAllCarts = $this->getTotalQuantityAcrossAllCarts($id, $allCarts, $workspaceId);
            if ($originalquantity <= $totalQuantityInAllCarts) {
                return response()->json([
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This product is out of stock. All available units are already in other carts.'),
                ], 404);
            }
                } else if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'pos') {
                    return response()->json([
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ], 404);
                }
    
                $this->saveCart($session_key, $cart, $allCarts, $workspaceId, $cartId);
                
                $totalWithoutDiscount = $this->calculateTotalWithoutDiscount($cart);
                return response()->json([
                    'code' => 200,
                    'status' => 'Success',
                    'success' => $productname . __(' added to cart successfully!'),
                    'product' => $cart[$id],
                    'carttotal' => $cart,
                    'totalWithoutDiscount' => currency_format_with_sym($totalWithoutDiscount),
                    'cart_id' => $cartId ?? null,
                ]);
            }
    
            // If item doesn't exist in cart then add to cart with quantity = 1
            $cart[$id] = $cartItemData;
    
            if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'pos') {
                return response()->json([
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This product is out of stock!'),
                ], 404);
            }
    
            $this->saveCart($session_key, $cart, $allCarts, $workspaceId, $cartId);
            
            $totalWithoutDiscount = $this->calculateTotalWithoutDiscount($cart);
            return response()->json([
                'code' => 200,
                'status' => 'Success',
                'success' => $productname . __(' added to cart successfully!'),
                'product' => $cart[$id],
                'carthtml' => $carthtml,
                'carttotal' => $cart,
                'totalWithoutDiscount' => currency_format_with_sym($totalWithoutDiscount),
                'cart_id' => $cartId ?? null,
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'status' => 'Error',
                'error' => __('This Product is not found!'),
            ], 404);
        }
    }

    /**
     * Helper method to generate cart item HTML
     */
    private function generateCartItemHtml($id, $productname, $image_url, $productquantity, $product_tax, $priceHtml, $subtotal, $model_delete_id, $session_key, $cartId = null)
    {
        return '<tr data-product-id="' . $id . '" id="product-id-' . $id . '">
                    <td class="cart-images">
                        <img alt="Image placeholder" src="' . get_file($image_url) . '" class="card-image avatar shadow hover-shadow-lg">
                    </td>
                    <td class="name">' . $productname . '</td>
                    <td class="">
                        <span class="quantity buttons_added">
                            <button class="minus">
                                <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                        <g id="Icon-Set-Filled" sketch:type="MSLayerGroup" transform="translate(-518.000000, -1089.000000)" fill="#000000">
                                            <path d="M540,1106 L528,1106 C527.447,1106 527,1105.55 527,1105 C527,1104.45 527.447,1104 528,1104 L540,1104 C540.553,1104 541,1104.45 541,1105 C541,1105.55 540.553,1106 540,1106 L540,1106 Z M534,1089 C525.163,1089 518,1096.16 518,1105 C518,1113.84 525.163,1121 534,1121 C542.837,1121 550,1113.84 550,1105 C550,1096.16 542.837,1089 534,1089 L534,1089 Z" id="minus-circle" sketch:type="MSShapeGroup">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                            </button>
                            <input type="number" step="1" min="1" max="' . $productquantity . '" name="quantity" title="' . __('Quantity') . '" class="input-number" size="4" data-url="' . url('update-cart/') . '" data-id="' . $id . '" data-cart-id="' . ($cartId ?? '') . '">
                            <button class="plus">
                                <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                        <g id="Icon-Set-Filled" sketch:type="MSLayerGroup" transform="translate(-466.000000, -1089.000000)" fill="#000000">
                                            <path d="M488,1106 L483,1106 L483,1111 C483,1111.55 482.553,1112 482,1112 C481.447,1112 481,1111.55 481,1111 L481,1106 L476,1106 C475.447,1106 475,1105.55 475,1105 C475,1104.45 475.447,1104 476,1104 L481,1104 L481,1099 C481,1098.45 481.447,1098 482,1098 C482.553,1098 483,1098.45 483,1099 L483,1104 L488,1104 C488.553,1104 489,1104.45 489,1105 C489,1105.55 488.553,1106 488,1106 L488,1106 Z M482,1089 C473.163,1089 466,1096.16 466,1105 C466,1113.84 473.163,1121 482,1121 C490.837,1121 498,1113.84 498,1105 C498,1096.16 490.837,1089 482,1089 L482,1089 Z" id="plus-circle" sketch:type="MSShapeGroup">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                            </button>
                        </span>
                    </td>
                    <td class="tax">' . $product_tax . '</td>
                    <td class="price">' . $priceHtml . '</td>
                    <td class="subtotal">' . currency_format_with_sym($subtotal) . '</td>
                    <td class="text-center">
                        <a href="#" class="action-btn show_confirm-pos" 
                           data-confirm="Are You Sure?" 
                           data-text="This action cannot be undone. Do you want to continue?" 
                           data-confirm-yes="' . $model_delete_id . '" >
                            <i class="ti ti-trash bg-danger btn btn-sm text-white"></i>
                        </a>
                         <form method="POST" action="' . url("/pos/carts/{$cartId}/items/{$model_delete_id}") . '" accept-charset="UTF-8" id="delete-form-' . $model_delete_id . '" style="display: none;">
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="_token" type="hidden" value="' . csrf_token() . '">
                            <input type="hidden" name="session_key" value="' . $session_key . '">
                            <input type="hidden" name="id" value="' . $model_delete_id . '">
                            <input type="hidden" name="cart_id" value="' . ($cartId ?? '') . '">
                        </form>
                    </td>
                </tr>';
    }

    /**
     * Helper method to save cart data
     */
    private function saveCart($session_key, $cart, $allCarts = null, $workspaceId = null, $cartId = null)
    {
        if ($session_key == 'pos' && $allCarts && $workspaceId && $cartId) {
            $allCarts[$workspaceId][$cartId]['items'] = $cart;
            $allCarts[$workspaceId][$cartId]['updated_at'] = now();
            Session::put('pos_carts', $allCarts);
        } else {
            session()->put($session_key, $cart);
        }
    }


    private function createDefaultCart($workspaceId)
    {
        $allCarts = Session::get('pos_carts');
        if (!isset($allCarts[$workspaceId])) {
            $allCarts[$workspaceId] = [];
        }
        $cartId = "cart_{$workspaceId}_" . uniqid();
        $allCarts[$workspaceId][$cartId] = [
            'name' => 'Default Cart',
            'items' => [],
            'customer_id' => null,
            'warehouse_id' => null,
            'discount' => 0,
            'is_default' => true,
            'workspace_id' => $workspaceId,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        Session::put('pos_carts', $allCarts);
        return $cartId;
    }

    public function calculateTotalWithoutDiscount($cart)
    {
        $total = 0;
        
        foreach ($cart as $item) {
            $price = $item['original_price'] ?? $item['price'];
            $quantity = $item['quantity'];
            $tax_rate = $item['tax'];
            
            $item_price = $price * $quantity;
            $item_tax = ($item_price * $tax_rate) / 100;
            
            $total += $item_price + $item_tax;
        }
        
        return $total;
    }
       
    public function removeFromCart(Request $request, $cartId, $itemId)
    {
        $id = $itemId; // Get item ID from URL parameter
        $session_key = $request->input('session_key', 'pos'); // Default to 'pos' or get from request
        // $cartId is already available from URL parameter
        
        if (Auth::user()->isAbleTo('pos cart manage') && isset($id) && !empty($id) && isset($session_key) && !empty($session_key)) {
            $cart = null;
            $productName = '';
            
            // Handle multi-cart system for POS
            if ($session_key == 'pos') {
                $this->initCartSession();
                $workspaceId = $this->getCurrentWorkspaceId();
                $allCarts = Session::get('pos_carts');
                
                // If no specific cart ID provided from URL, use active cart
                if (!$cartId || $cartId === 'active') {
                    $cartId = Session::get("active_pos_cart_{$workspaceId}");
                    if (!$cartId) {
                        $cartId = $this->getDefaultCartId($workspaceId);
                    }
                }
                
                // Validate cart exists
                if (!isset($allCarts[$workspaceId][$cartId])) {
                    if ($request->ajax()) {
                        return response()->json([
                            'code' => 404,
                            'status' => 'Error',
                            'error' => __('Cart not found!')
                        ], 404);
                    }
                    return redirect()->back()->with('error', __('Cart not found!'));
                }
                
                $cart = $allCarts[$workspaceId][$cartId]['items'];
            } else {
                // For non-POS sessions, use the old system
                $cart = session()->get($session_key);
            }
            
            if (isset($cart[$id])) {
                $productName = $cart[$id]['name'] ?? 'Product';
                unset($cart[$id]);
                
                // Save the updated cart
                $this->saveCart($session_key, $cart, $allCarts ?? null, $workspaceId ?? null, $cartId);
                
                // Calculate all totals
                $totals = $this->calculateAllTotals($cart);
                
                // Check if this is an AJAX request
                if ($request->ajax()) {
                    return response()->json([
                        'code' => 200,
                        'status' => 'Success',
                        'success' => $productName . __(' removed from cart successfully!'),
                        'carttotal' => $cart,
                        'cartCount' => count($cart),
                        'totals' => $totals,
                        'cart_id' => $cartId ?? null,
                    ]);
                }
                
                return redirect()->back()->with('success', __('Product removed from cart successfully!'));
            } else {
                if ($request->ajax()) {
                    return response()->json([
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('Product not found in cart!')
                    ], 404);
                }
                
                return redirect()->back()->with('error', __('Product not found in cart!'));
            }
        } else {
            if ($request->ajax()) {
                return response()->json([
                    'code' => 403,
                    'status' => 'Error',
                    'error' => __('Unauthorized or invalid request!')
                ], 403);
            }
            
            return redirect()->back()->with('error', __('Unauthorized or invalid request!'));
        }
    }
     
    public function calculateAllTotals($cart)
    {
        $subtotal = 0;
        $totalTax = 0;
        $grandTotal = 0;
        $totalDiscount = 0;
        $totalWithoutDiscount = 0;
        
        foreach ($cart as $item) {
            $price = $item['price'];
            $quantity = $item['quantity'];
            $tax_rate = $item['tax'];
            $original_price = $item['original_price'] ?? $price;
            
            // Calculate subtotal (discounted price * quantity)
            $item_subtotal = $price * $quantity;
            $subtotal += $item_subtotal;
            
            // Calculate tax on subtotal
            $item_tax = ($item_subtotal * $tax_rate) / 100;
            $totalTax += $item_tax;
            
            // Calculate grand total (subtotal + tax)
            $grandTotal += $item_subtotal + $item_tax;
            
            // Calculate discount amount
            $item_discount = $item['total_discount'] ?? 0;
            $totalDiscount += $item_discount;
            
            // Calculate total without discount (original price * quantity + tax)
            $item_original_total = $original_price * $quantity;
            $item_original_tax = ($item_original_total * $tax_rate) / 100;
            $totalWithoutDiscount += $item_original_total + $item_original_tax;
        }
        
        return [
            'subtotal' => currency_format_with_sym($subtotal),
            'tax' => currency_format_with_sym($totalTax),
            'total' => currency_format_with_sym($grandTotal),
            'discount' => currency_format_with_sym($totalDiscount),
            'totalWithoutDiscount' => currency_format_with_sym($totalWithoutDiscount),
            'raw' => [
                'subtotal' => $subtotal,
                'tax' => $totalTax,
                'total' => $grandTotal,
                'discount' => $totalDiscount,
                'totalWithoutDiscount' => $totalWithoutDiscount
            ]
        ];
    }
    
    public function updateCart(Request $request)
    {
        $id = $request->id;
        $quantity = $request->quantity;
        $discount = $request->discount;
        $session_key = $request->session_key ?? 'pos';
        $cartId = $request->input('cart_id'); // Get the specific cart ID
        
        if (Auth::user()->isAbleTo('pos cart manage') && $request->ajax() && isset($id) && !empty($id) && isset($session_key) && !empty($session_key))
        {
            $cart = null;
            $allCarts = null;
            $workspaceId = null;
            
            // Handle multi-cart system for POS
            if ($session_key == 'pos') {
                $this->initCartSession();
                $workspaceId = $this->getCurrentWorkspaceId();
                $allCarts = Session::get('pos_carts');
                
                // If no specific cart ID provided, use active cart
                if (!$cartId) {
                    $cartId = Session::get("active_pos_cart_{$workspaceId}");
                    if (!$cartId) {
                        $cartId = $this->getDefaultCartId($workspaceId);
                    }
                }
                
                // Validate cart exists
                if (!isset($allCarts[$workspaceId][$cartId])) {
                    return response()->json([
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('Cart not found!'),
                    ], 404);
                }
                
                $cart = $allCarts[$workspaceId][$cartId]['items'];
            } else {
                // For non-POS sessions, use the old system
                $cart = session()->get($session_key);
            }
            
            // If quantity is 0, remove item from cart
            if (isset($cart[$id]) && $quantity == 0) {
                unset($cart[$id]);
                $this->saveCart($session_key, $cart, $allCarts, $workspaceId, $cartId);
                
                // Calculate totals without the removed item
                $subtotal = !empty($cart) ? array_sum(array_column($cart, 'subtotal')) : 0;
                $totalWithoutDiscount = 0;
                
                // Calculate total without applying product discounts
                if (!empty($cart)) {
                    foreach ($cart as $item) {
                        $originalPrice = $item['original_price'] ?? $item['price'];
                        $itemQuantity = $item['quantity'];
                        $taxRate = $item['tax'];
                        
                        $itemPrice = $originalPrice * $itemQuantity;
                        $itemTax = ($itemPrice * $taxRate) / 100;
                        
                        $totalWithoutDiscount += $itemPrice + $itemTax;
                    }
                }
                
                $discountAmount = (!empty($discount) && $discount > 0) ? $discount : 0;
                $total = $subtotal - $discountAmount;
                
                return response()->json([
                    'code' => 200,
                    'success' => __('Item removed from cart successfully!'),
                    'product' => $cart,
                    'subtotal' => currency_format_with_sym($subtotal),
                    'total' => currency_format_with_sym($total),
                    'totalWithoutDiscount' => currency_format_with_sym($totalWithoutDiscount),
                    'discount' => currency_format_with_sym($discountAmount),
                    'cart_id' => $cartId ?? null,
                ]);
            }
            
            // Update quantity and recalculate
            if ($quantity) {
                $cart[$id]["quantity"] = $quantity;
                $productprice = (array_key_exists("price", $cart[$id])) ? $cart[$id]["price"] : 0;
                $originalPrice = (array_key_exists("original_price", $cart[$id])) ? $cart[$id]["original_price"] : $productprice;
                
                // Calculate subtotal based on discounted price
                $subtotal = $productprice * $quantity;
                
                // Calculate tax
                $tax = 0;
                $tax_price = 0;
                if (array_key_exists('tax', $cart[$id])) {
                    $producttax = $cart[$id]["tax"];
                    $tax_price = ($subtotal * $producttax) / 100;
                    $tax = $tax_price; // For backward compatibility
                }
                
                // Update subtotal with tax and store tax_price
                $cart[$id]["subtotal"] = $subtotal + $tax_price;
                $cart[$id]["tax_price"] = $tax_price; // Store the calculated tax amount
                
                // Update total discount for this item
                if (isset($cart[$id]["original_price"]) && isset($cart[$id]["price"])) {
                    $singleItemDiscount = $originalPrice - $productprice;
                    $cart[$id]["total_discount"] = $singleItemDiscount * $quantity;
                }
            }
            
            // Check if product is out of stock
            if (isset($cart[$id]["originalquantity"]) && $cart[$id]["originalquantity"] < $cart[$id]['quantity'] && $session_key == 'pos') {
                return response()->json([
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This product is out of stock!'),
                ], 404);
            }
            
            // Calculate cart totals
            $subtotal = array_sum(array_column($cart, 'subtotal'));
            $cartDiscount = array_sum(array_column($cart, 'total_discount', 0));
            $additionalDiscount = (!empty($request->discount) && $request->discount > 0) ? $request->discount : 0;
            $total = $subtotal - $additionalDiscount;
            
            // Calculate total without any discounts
            $totalWithoutDiscount = 0;
            $totalTaxPrice = 0; // New variable to track total tax
            
            foreach ($cart as $item) {
                $originalItemPrice = $item['original_price'] ?? $item['price'];
                $itemQuantity = $item['quantity'];
                $taxRate = $item['tax'];
                
                $itemPrice = $originalItemPrice * $itemQuantity;
                $itemTax = ($itemPrice * $taxRate) / 100;
                
                $totalWithoutDiscount += $itemPrice + $itemTax;
                $totalTaxPrice += $item['tax_price'] ?? $itemTax; // Use stored tax_price if available
            }
            
            $this->saveCart($session_key, $cart, $allCarts, $workspaceId, $cartId);
            
            return response()->json([
                'code' => 200,
                'success' => __('The cart has been updated successfully!'),
                'product' => $cart,
                'subtotal' => currency_format_with_sym($subtotal),
                'total' => currency_format_with_sym($total),
                'totalWithoutDiscount' => currency_format_with_sym($totalWithoutDiscount),
                'discount' => currency_format_with_sym($additionalDiscount),
                'productDiscountTotal' => $cartDiscount,
                'totalWithAllDiscounts' => currency_format_with_sym($total),
                'totalTaxPrice' => currency_format_with_sym($totalTaxPrice), // Add total tax information to response
                'cart_id' => $cartId ?? null,
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'status' => 'Error',
                'error' => __('This Product is not found!'),
            ], 404);
        }
    }    

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($ids)
    {
       
        if(\Auth::user()->isAbleTo('pos show') )
        {
            try {
                $id       = Crypt::decrypt($ids);
               
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', __('POS Not Found.'));
            }
            $pos = Pos::find($id);
            if(isset($pos) && !empty($pos)){

                $company_setting = getCompanyAllSetting();

                if($pos->created_by == creatorId())
                {
                    $posPayment = PosPayment::where('pos_id', $pos->id)->first();
                    $customer=[];
                    if(module_is_active('Account'))
                    {
                        $customer             = $pos->customer;
                    }
                    $iteams               = $pos->itemswithproduct;  //items;
                   
                    return view('pos::pos.view', compact('pos', 'customer','iteams','posPayment','company_setting'));
                }
                else
                {
                    return redirect()->back()->with('error', __('Permission denied.'));
                }
            }
            else
            {
                return redirect()->back()->with('error', __('POS Not Found.'));
            }
        }
        else
        {
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
        return view('pos::edit');
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
    
    public function setting(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            // 'purchase_prefix' => 'required',
            // 'pos_prefix' => 'required',
            'low_product_stock_threshold'=>'required'
        ]);
        if($validator->fails()){
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        else
        {
            $post = $request->all();
            unset($post['_token']);
            foreach ($post as $key => $value) {
                // Define the data to be updated or inserted
                $data = [
                    'key' => $key,
                    'workspace' => getActiveWorkSpace(),
                    'created_by' =>\Auth::user()->id,
                ];
                // Check if the record exists, and update or insert accordingly
                Setting::updateOrInsert($data, ['value' => $value]);
            }
            // Settings Cache forget
            comapnySettingCacheForget();


            return redirect()->back()->with('success',__('The POS setting has been saved successfully.'));
        }
    }
    
    public function emptyCart(Request $request)
    {
        $session_key = $request->session_key;
                $cart = session()->get($session_key);
                if (isset($cart) && count($cart) > 0)
                {
                    session()->forget($session_key);
                }
    
            return redirect()->back()->with('success', __('Cart has been emptied successfully.'));
        
    }
    
    public function warehouseemptyCart(Request $request)
    {
        $session_key = $request->session_key;
            $cart = session()->get($session_key);
            if (isset($cart) && count($cart) > 0)
            {
                session()->forget($session_key);
            }

        return response()->json();

    }

    public function dashboard(Request $request)
    {
        if (\Auth::user()->isAbleTo('pos dashboard manage'))
        {
            $low_stock = company_setting('low_product_stock_threshold');
            $productscount=[];
            $lowstockproducts = [];


            if(module_is_active('ProductService'))
            {
                    $productObj = Pos::getallproducts();
                    $productscount = $productObj->count();

                if ($productscount > 0) {

                    foreach ($productObj as $key => $product) { //->get()

                        $productquantity = $product->getTotalProductQuantity();
                        if ($productquantity <= $low_stock) {
                            $lowstockproducts[] = [
                                'name' => $product->name,
                                'quantity' => $productquantity
                            ];
                        }
                    }
                }
            }
            $customers=[];
            $vendors=[];
            if(module_is_active('Account'))
            {
                $customers = \Workdo\Account\Entities\Customer::select('id')->where('created_by', creatorId())->where('workspace',getActiveWorkSpace())->count();

                $vendors = \Workdo\Account\Entities\Vender::select('id')->where('created_by', creatorId())->where('workspace',getActiveWorkSpace())->count();
            }
            $monthlySelledAmount = Pos::totalSelledAmount(true);
            $totalSelledAmount   = Pos::totalSelledAmount();

            // $monthlyPurchasedAmount = Purchase::totalPurchasedAmount(true);
            // $totalPurchasedAmount   = Purchase::totalPurchasedAmount();

            // $purchasesArray = Purchase::getPurchaseReportChart();
            $lowStockLimitProducts = ProductService::whereColumn('quantity', '<=', 'low_stock_limit')->where('created_by', creatorId())->where('workspace_id', getActiveWorkSpace())->latest()->take(10)->get();
           
            $salesArray = Pos::getSalesReportChart();
            $ActiveWorkspaceName = WorkSpace::where('id', getActiveWorkSpace())->pluck('name')->first();
            $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
            $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
                $purchaseProducts = DB::table('purchases as p')
                ->join('purchase_product_batches as pp', 'p.id', '=', 'pp.purchase_id')
                ->join('product_services as ps', 'pp.product_id', '=', 'ps.id')
                ->select(
                    'ps.name as product_name',
                    'pp.rem_quantity as remaing_quantity',
                    'p.created_at as created_at',
                    'pp.expire_at as expire_at', 
                    'pp.quantity as Purchase_quantity',
                    'pp.product_id as id',
                    'pp.batch_no as batch_no',
                    'p.account_type as account_type'
                )
                ->where('p.workspace', getActiveWorkSpace())
                 ->where('pp.rem_quantity', '>', 0)
                 ->where('pp.expire_at', '<=', $endOfMonth)
                 ->latest()
                 ->take(10)
                ->get();
            $homes = [
                'productscount',
                'lowstockproducts',
                'customers',
                'vendors',
                'monthlySelledAmount',
                'totalSelledAmount',
                'salesArray',
                'ActiveWorkspaceName',
                'lowStockLimitProducts',
                'purchaseProducts',
               
                
            ];
            return view('pos::dashboard.dashboard', compact($homes));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function cartdiscount(Request $request)
    {
        $total = currency_format_with_sym(0);
        if($request->discount){
            $sess = session()->get('pos');
            if(isset($sess) && !empty($sess) && count($sess) > 0){

                $subtotal = !empty($sess)?array_sum(array_column($sess, 'subtotal')):0;
                $discount = (!empty($request->discount) && $request->discount > 0 ) ? $request->discount : 0;
                $total = $subtotal - $discount;
                $total = currency_format_with_sym($total);
            }
        }else{
            $sess = session()->get('pos');
            if(isset($sess) && !empty($sess) && count($sess) > 0){

                $subtotal = !empty($sess)?array_sum(array_column($sess, 'subtotal')):0;
                $discount = 0;
                $total = $subtotal - $discount;
                $total = currency_format_with_sym($total);
            }
        }
        return response()->json(['total' => $total], '200');

    }

    public function pos($pos_id)
    {
        $posId   = Crypt::decrypt($pos_id);
        $pos  = Pos::where('id', $posId)->first();
        $posPayment = PosPayment::where('pos_id', $pos->id)->first();

        $data  = DB::table('settings');
        $data  = $data->where('id', '=', $pos->created_by);
        $data1 = $data->get();

        $customer = $pos->customer;

        $totalTaxPrice = 0;
        $totalQuantity = 0;
        $totalRate     = 0;
        $totalDiscount = 0;
        $taxesData     = [];
        $items         = [];

        foreach($pos->itemswithproduct as $product) //->items
        {

            $item              = new \stdClass();
            $item->name        = !empty($product->product) ? $product->product->name : '';
            $item->quantity    = $product->quantity;
            $item->tax         = $product->tax;
            $item->discount    = $product->discount;
            $item->price       = $product->price;
            $item->description = $product->description;
            $totalQuantity += $item->quantity;
            $totalRate     += $item->price;
            $totalDiscount += $item->discount;
            $taxes     = Pos::tax($product->tax);
            $itemTaxes = [];
            if(!empty($item->tax))
            {
                foreach($taxes as $tax)
                {
                    $taxPrice      = Pos::taxRate($tax->rate, $item->price, $item->quantity);
                    $totalTaxPrice += $taxPrice;

                    $itemTax['name']  = $tax->name;
                    $itemTax['rate']  = $tax->rate . '%';
                    $itemTax['price'] = company_date_formate($taxPrice);
                    $itemTaxes[]      = $itemTax;


                    if(array_key_exists($tax->name, $taxesData))
                    {
                        $taxesData[$tax->name] = $taxesData[$tax->name] + $taxPrice;
                    }
                    else
                    {
                        $taxesData[$tax->name] = $taxPrice;
                    }

                }

                $item->itemTax = $itemTaxes;
            }
            else
            {
                $item->itemTax = [];
            }
            $items[] = $item;
        }

        $pos->itemData      = $items;
        $pos->totalTaxPrice = $totalTaxPrice;
        $pos->totalQuantity = $totalQuantity;
        $pos->totalRate     = $totalRate;
        $pos->totalDiscount = $totalDiscount;
        $pos->taxesData     = $taxesData;

        $company_logo = get_file(sidebar_logo());
        $pos_logo = company_setting('pos_logo');
        if(isset($pos_logo) && !empty($pos_logo))
        {
            $img = get_file($pos_logo);
        }
        else{
            $img = $company_logo;
        }

        $settings['site_rtl'] = company_setting('site_rtl');
        $settings['company_email'] = company_setting('company_email');
        $settings['company_telephone'] = company_setting('company_telephone');
        $settings['company_name'] = company_setting('company_name');
        $settings['company_address'] = company_setting('company_address');
        $settings['company_city'] = company_setting('company_city');
        $settings['company_state'] = company_setting('company_state');
        $settings['company_zipcode'] = company_setting('company_zipcode');
        $settings['company_country'] = company_setting('company_country');
        $settings['registration_number'] = company_setting('registration_number');
        $settings['tax_type'] = company_setting('tax_type');
        $settings['vat_number'] = company_setting('vat_number');
        $settings['pos_footer_title'] = company_setting('pos_footer_title');
        $settings['pos_footer_notes'] = company_setting('pos_footer_notes');
        $settings['pos_shipping_display'] = company_setting('pos_shipping_display');
        $settings['pos_template'] = company_setting('pos_template');
        $settings['pos_color'] = company_setting('pos_color');
        if($pos)
        {

            $color=company_setting('pos_color',$pos->created_by, $pos->workspace);
            if($color){
                $color=$color;
            }else{
                $color='ffffff';
            }
            $color      = '#' .$color ;
            $font_color   = PosUtility::getFontColor($color);

            return view('pos::pos.templates.' . $settings['pos_template'], compact('pos','posPayment', 'color', 'settings', 'customer', 'img', 'font_color'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function previewPos($template, $color)
    {
        $objUser  = \Auth::user();

        $pos     = new Pos();
        // $posPayment = PosPayment::where('pos_id', $pos->id)->first();
        $posPayment     = new posPayment();
        $customer                   = new \stdClass();
        $customer->email            = '<Email>';
        $customer->shipping_name    = '<Customer Name>';
        $customer->shipping_country = '<Country>';
        $customer->shipping_state   = '<State>';
        $customer->shipping_city    = '<City>';
        $customer->shipping_phone   = '<Customer Phone Number>';
        $customer->shipping_zip     = '<Zip>';
        $customer->shipping_address = '<Address>';
        $customer->billing_name     = '<Customer Name>';
        $customer->billing_country  = '<Country>';
        $customer->billing_state    = '<State>';
        $customer->billing_city     = '<City>';
        $customer->billing_phone    = '<Customer Phone Number>';
        $customer->billing_zip      = '<Zip>';
        $customer->billing_address  = '<Address>';
        $totalTaxPrice = 0;
        $taxesData     = [];
        $items         = [];
        for($i = 1; $i <= 3; $i++)
        {
            $item           = new \stdClass();
            $item->name     = 'Item ' . $i;
            $item->quantity = 1;
            $item->tax      = 5;
            $item->discount = 50;
            $item->price    = 100;
            $item->description    = 'In publishing and graphic design, Lorem ipsum is a placeholder';

            $taxes = [
                'Tax 1',
                'Tax 2',
            ];

            $itemTaxes = [];
            foreach($taxes as $k => $tax)
            {
                $taxPrice         = 10;
                $totalTaxPrice    += $taxPrice;
                $itemTax['name']  = 'Tax ' . $k;
                $itemTax['rate']  = '10 %';
                $itemTax['price'] = '$10';
                $itemTaxes[]      = $itemTax;
                if(array_key_exists('Tax ' . $k, $taxesData))
                {
                    $taxesData['Tax ' . $k] = $taxesData['Tax 1'] + $taxPrice;
                }
                else
                {
                    $taxesData['Tax ' . $k] = $taxPrice;
                }
            }
            $item->itemTax = $itemTaxes;
            $items[]       = $item;
        }

        $pos->pos_id    = 1;

        $pos->issue_date = date('Y-m-d H:i:s');
        $pos->itemData   = $items;

        $pos->totalTaxPrice = 60;
        $pos->totalQuantity = 3;
        $pos->totalRate     = 300;
        $pos->totalDiscount = 10;
        $pos->taxesData     = $taxesData;
        $pos->created_by     = creatorId();

        $preview      = 1;
        $color        = '#' . $color;
        $font_color   = User::getFontColor($color);

        $company_logo = get_file(sidebar_logo());
        $pos_logo = company_setting('pos_logo');

        if(isset($pos_logo) && !empty($pos_logo))
        {
            $img = get_file($pos_logo);
        }
        else{
            $img = $company_logo;
        }

        $settings['site_rtl'] = company_setting('site_rtl');
        $settings['company_email'] = company_setting('company_email');
        $settings['company_telephone'] = company_setting('company_telephone');
        $settings['company_name'] = company_setting('company_name');
        $settings['company_address'] = company_setting('company_address');
        $settings['company_city'] = company_setting('company_city');
        $settings['company_state'] = company_setting('company_state');
        $settings['company_zipcode'] = company_setting('company_zipcode');
        $settings['company_country'] = company_setting('company_country');
        $settings['registration_number'] = company_setting('registration_number');
        $settings['tax_type'] = company_setting('tax_type');
        $settings['vat_number'] = company_setting('vat_number');
        $settings['pos_footer_title'] = company_setting('pos_footer_title');
        $settings['pos_footer_notes'] = company_setting('pos_footer_notes');
        $settings['pos_shipping_display'] = company_setting('pos_shipping_display');
        $settings['pos_template'] = company_setting('pos_template');
        $settings['pos_color'] = company_setting('pos_color');

        return view('pos::pos.templates.' . $template, compact('pos', 'preview', 'color', 'img', 'settings', 'customer', 'font_color','posPayment'));
    }

    public function savePosTemplateSettings(Request $request)
    {
        $user = \Auth::user();
        $post = $request->all();
        unset($post['_token']);

        if($request->pos_logo)
        {
            $request->validate(
                [
                    'pos_logo' => 'image|mimes:png',
                ]
            );

            $pos_logo         = $user->id.'_pos_logo.png';
            $uplaod = upload_file($request,'pos_logo',$pos_logo,'pos_logo');
            if($uplaod['flag'] == 1)
            {
                $url = $uplaod['url'];
            }
            else{
                return redirect()->back()->with('error',$uplaod['msg']);
            }
        }
        if (isset($request->pos_footer_notes) && !empty($request->pos_footer_notes)){
            $validator = Validator::make($request->all(),
                [
                    'pos_footer_notes' => 'required|string|regex:/^[^\r\n]*$/',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
        }

        if(isset($post['pos_template']) && (!isset($post['pos_color']) || empty($post['pos_color'])))
        {
            $post['pos_color'] = "ffffff";
        }
        if(isset($post['pos_logo']))
        {
            $post['pos_logo'] = $url;
        }
        if(!isset($post['pos_shipping_display']))
        {
            $post['pos_shipping_display'] = 'off';
        }
        foreach ($post as $key => $value) {
            // Define the data to be updated or inserted
            $data = [
                'key' => $key,
                'workspace' => getActiveWorkSpace(),
                'created_by' =>\Auth::user()->id,
            ];
            // Check if the record exists, and update or insert accordingly
            Setting::updateOrInsert($data, ['value' => $value]);
        }
        // Settings Cache forget
        comapnySettingCacheForget();

        return redirect()->back()->with('success', __('The POS Setting are updated successfully'));
    }

    public function grid()
    {
        if(\Auth::user()->isAbleTo('pos add manage'))
        {
            $posPayments = Pos::where('created_by', creatorId())->where('workspace',getActiveWorkSpace())->with('customer')->orderBy('id','desc');
            $posPayments = $posPayments->paginate(11);
            return view('pos::pos.grid',compact('posPayments'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

    }

    //for thermal print
    public function printView(Request $request)
    {
        $user = Auth::user();
    
        if(module_is_active('Account'))
        {
            $user = User::where('name', '=', $request->vc_name)->where('type','client')->where('created_by', creatorId())->where('workspace_id',getActiveWorkSpace())->first();
            if(!empty($user->id))
            {
                $customer = \Workdo\Account\Entities\Customer::where('user_id',$user->id)->where('name', '=', $request->vc_name)->where('created_by', creatorId())->where('workspace',getActiveWorkSpace())->first();
                if(!empty($customer)){
                    $customer = $customer;
                }
                else{
                    $customer = $user;
                }
            }
            else{
                $customer = NULL;
                $user = Auth::user();
            }
        }
        else
        {
            $customer = User::where('name', '=', $request->vc_name)->where('type','client')->where('created_by', creatorId())->where('workspace_id',getActiveWorkSpace())->first();
        }
    
        $warehouse = warehouse::where('id', '=', $request->warehouse_name)->where('created_by', creatorId())->first();
    
        $details = [
            'pos_id' => Pos::posNumberFormat($this->invoicePosNumber()),
            'customer' => $customer != null ? $customer->toArray() : [],
            'warehouse' => $warehouse != null ? $warehouse->toArray() : [],
            'user' => $user != null ? $user->toArray() : [],
            'date' => date('Y-m-d H:i:s'),
            'pay' => 'show',
        ];
    
        if (!empty($details['customer']['billing_state']))
        {
            $warehousedetails = '<h7 class="text-dark">' . ucfirst($details['warehouse']['name'])  . '</p></h7>';
            $details['customer']['billing_state'] = $details['customer']['billing_state'] != '' ? ", " . $details['customer']['billing_state'] : '';
            $details['customer']['shipping_state'] = $details['customer']['shipping_state'] != '' ? ", " . $details['customer']['shipping_state'] : '';
            $customerdetails = '<h6 class="text-dark">' . ucfirst($details['customer']['name']) . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['billing_phone'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['billing_address'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['billing_city'] . $details['customer']['billing_state'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['billing_country'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['billing_zip'] . '</p></h6>';
            $shippdetails = '<h6 class="text-dark"><b>' . ucfirst($details['customer']['name']) . '</b>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['shipping_phone'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['shipping_address'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['shipping_city'] . $details['customer']['shipping_state'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['shipping_country'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['shipping_zip'] . '</p></h6>';
        }
        else {
            $customerdetails = '<h2 class="h6"><b>' . __('Walk-in Customer') . '</b><h2>';
            $warehousedetails = '<h7 class="text-dark">' . ucfirst($details['warehouse']['name'])  . '</p></h7>';
            $shippdetails = '-';
        }
    
        $settings['company_telephone'] = company_setting('company_telephone') != '' ? ", " . company_setting('company_telephone') : '';
        $settings['company_state'] = company_setting('company_state') != '' ? ", " . company_setting('company_state') : '';
    
        $userdetails = '<h6 class="text-dark"><b>' . ucfirst($details['user']['name']) . ' </b> <h2  class="font-weight-normal">' . '<p class="m-0 font-weight-normal">' . company_setting('company_name') . company_setting('company_telephone') . '</p>' . '<p class="m-0 font-weight-normal">' . company_setting('company_address') . '</p>' . '<p class="m-0 h6 font-weight-normal">' . company_setting('company_city') . company_setting('company_state') . '</p>' . '<p class="m-0 font-weight-normal">' . company_setting('company_country') . '</p>' . '<p class="m-0 font-weight-normal">' . company_setting('company_zipcode') . '</p></h2>';
    
        $details['customer']['details'] = $customerdetails;
        $details['warehouse']['details'] = $warehousedetails;
        $details['customer']['shippdetails'] = $shippdetails;
        $details['user']['details'] = $userdetails;
    
        $totaltax = 0;
        $totalqty = 0; 
        $mainsubtotal = 0;
        $tdiscount = 0;
        $sales = [];
        
        // Multi-cart system logic
        $workspaceId = $this->getCurrentWorkspaceId();
        $cartId = $request->input('cart_id'); // Get specific cart ID from request
        
        // If no cart ID provided, get active cart
        if (!$cartId) {
            $cartId = Session::get("active_pos_cart_{$workspaceId}");
            if (!$cartId) {
                $cartId = $this->getDefaultCartId($workspaceId);
            }
        }
        
        // Get cart data from multi-cart session
        $allCarts = Session::get('pos_carts');
        $sess = null;
        
        if ($allCarts && isset($allCarts[$workspaceId][$cartId]['items'])) {
            $sess = $allCarts[$workspaceId][$cartId]['items'];
        }
        
        // Fallback to old session system if multi-cart data not found
        if (!$sess || empty($sess)) {
            $sess = session()->get('pos');
        }
       
        if(isset($sess) && !empty($sess) && count($sess) > 0){
            foreach ($sess as $key => $value) {
                $subtotal = $value['price'] * $value['quantity'];
                $tax = ($subtotal * $value['tax']) / 100;
                
                $sales['data'][$key]['name'] = $value['name'];
                $sales['data'][$key]['quantity'] = $value['quantity'];
                $sales['data'][$key]['price'] = currency_format_with_sym(!empty($value['original_price']) ? $value['original_price'] : $value['price']);
                $sales['data'][$key]['tax'] = $value['tax'] . '%';
                $sales['data'][$key]['product_tax'] = $value['product_tax'];
                $sales['data'][$key]['tax_amount'] = currency_format_with_sym($tax);
                $sales['data'][$key]['subtotal'] = currency_format_with_sym($value['subtotal']);
                $sales['data'][$key]['discount'] = currency_format_with_sym($value['total_discount'] ?? 0);
                
                $mainsubtotal += $value['subtotal'];
                $tdiscount += $value['total_discount'] ?? 0;
                $totalqty += $value['quantity'];
                $totaltax += $value['tax_price'];
            }
        }
    
        if($request->discount <= $mainsubtotal){
            $discount = !empty($request->discount) ? $request->discount : 0;
        }
        else{
            $discount = $mainsubtotal;
        }
        
        $sales['discount'] = currency_format_with_sym($tdiscount);
        $sales['total_tax'] = currency_format_with_sym($totaltax);
        $sales['total_qty'] = $totalqty;
        $total = $mainsubtotal - $discount;
        $sales['sub_total'] = currency_format_with_sym($mainsubtotal);
        $sales['total'] = currency_format_with_sym($total);
    
        return view('pos::pos.printview', compact('details', 'sales', 'customer'));
    }

    public function barcode(BarcodeDataTable $dataTable)
    {
        if (Auth::user()->isAbleTo('pos manage')) {
            if(module_is_active('ProductService'))
            {
                // $productServices = \Workdo\ProductService\Entities\ProductService::where('created_by', creatorId())->where('workspace_id',getActiveWorkSpace())->get();
                $barcode = [
                    'barcodeType' => Pos::barcodeType(),
                    'barcodeFormat' => Pos::barcodeFormat(),
                ];
               
                return $dataTable->render('pos::barcode.barcode',compact('barcode'));
            }else{
                return redirect()->back()->with('error', __('Please Enable Product & Service Module.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function barcodeSetting()
    {
        if (Auth::user()->isAbleTo('pos manage')) {
            $settings = getCompanyAllSetting();

            return view('pos::barcode.setting', compact('settings'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function BarcodesettingStore(Request $request)
    {

        $post['barcode_type'] = isset($request->barcode_type) ? $request->barcode_type : 'code128';
        $post['barcode_format'] = isset($request->barcode_format) ? $request->barcode_format : 'css';

        foreach ($post as $key => $value) {
            // Define the data to be updated or inserted
            $data = [
                'key' => $key,
                'workspace' => getActiveWorkSpace(),
                'created_by' =>\Auth::user()->id,
            ];
            // Check if the record exists, and update or insert accordingly
            Setting::updateOrInsert($data, ['value' => $value]);
        }
        // Settings Cache forget
        comapnySettingCacheForget();

        return redirect()->back()->with('success', __('The barcode setting are updated successfully.'));

    }

    public function printBarcode()
    {
        if (Auth::user()->isAbleTo('pos manage')) {
            $warehouses = warehouse::select('*', \DB::raw("CONCAT(name) AS name"))->where('created_by', creatorId())->where('workspace',getActiveWorkSpace())->get()->pluck('name', 'id');

            return view('pos::barcode.print', compact('warehouses'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function getproduct(Request $request)
    {
        if ($request->warehouse_id == 0) {
            $productServices = WarehouseProduct::where('product_id', '=', $request->warehouse_id)->where('created_by', '=', creatorId())->where('workspace',getActiveWorkSpace())->get()->pluck('name', 'id')->toArray();
        } else {
            $productServicesId = WarehouseProduct::where('created_by', '=', creatorId())->where('warehouse_id', $request->warehouse_id)->where('workspace',getActiveWorkSpace())->get()->pluck('product_id')->toArray();
            if(module_is_active('ProductService'))
            {
                $productServices = \Workdo\ProductService\Entities\ProductService::whereIn('id', $productServicesId)->where('created_by', creatorId())->where('workspace_id',getActiveWorkSpace())->get()->pluck('name', 'id')->toArray();
            }else{
                $productServices = [];
            }
        }
        return response()->json($productServices);
    }

    public function receipt(Request $request)
    {
        if (!empty($request->product_id)) {
            if(module_is_active('ProductService'))
            {
                $productServices = \Workdo\ProductService\Entities\ProductService::whereIn('id', $request->product_id)->where('created_by', creatorId())->where('workspace_id',getActiveWorkSpace())->get();
            }else{
                $productServices = [];
            }
            $quantity = $request->quantity;
            $barcode = [
                'barcodeType' => Pos::barcodeType() == '' ? 'code128' : Pos::barcodeType(),
                'barcodeFormat' => Pos::barcodeFormat() == '' ? 'css' : Pos::barcodeFormat(),
            ];
        } else {
            return redirect()->back()->with('error', __('Product is required.'));
        }
        return view('pos::barcode.receipt', compact('productServices', 'barcode', 'quantity'));
    }
    
    public function scanBarcode(Request $request)
    {
        try {
            $sku = $request->input('sku');
            $sessionKey = $request->input('session_key', 'pos');
            $warehouseId = $request->input('warehouse_id');
           
            // Validate inputs
            if (empty($sku)) {
                return response()->json([
                    'code' => '404',
                    'message' => 'Barcode/SKU is required'
                ], 400);
            }

            // Find product by SKU
            $product = ProductService::where('sku', $sku)->where('created_by', creatorId())->where('workspace_id',getActiveWorkSpace())->first();
          
            if (!$product) {
                return response()->json([
                    'code' => '404',
                    'message' => 'Product not found with SKU: ' . $sku
                ], 404);
            }

            // Check if product exists in selected warehouse
            if ($warehouseId) {
                $warehouseProduct = WarehouseProduct::where('product_id', $product->id)
                    ->where('warehouse_id', $warehouseId)
                    ->first();

                if (!$warehouseProduct || $warehouseProduct->quantity <= 0) {
                    return response()->json([
                        'code' => '404',
                        'message' => 'Product not available in selected warehouse'
                    ], 404);
                }
            }

            // Use the same logic as your existing add-to-cart functionality
            return $this->addToCartBarcode($product, $sessionKey, $warehouseId);

        } catch (\Exception $e) {
            \Log::error('Barcode scan error: ' . $e->getMessage());
            
            return response()->json([
                'code' => '500',
                'message' => 'Error processing barcode scan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    private function addToCartBarcode($product, $session_key, $war)
    {
        // if (Auth::user()->isAbleTo('pos cart manage') && $request->ajax()) {
        // $product = \Workdo\ProductService\Entities\ProductService::find($id);
        $id = $product->id;
        $productquantity = 0;
    
        if ($product) {
            $productquantity = $product->warehouseProduct($product->id, $war != 0 ? $war : 1);
        }
    
        if (!$product || ($session_key == 'pos' && $productquantity == 0)) {
            return response()->json(
                [
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This product is out of stock!'),
                ],
                404
            );
        }
    
        $productname = $product->name;
    
        // Get discount data similar to search product function
        $discountData = $product->discount_data;
        $discountedPrice = $discountData['discounted_price'] ?? null;
        $originalPrice = $discountData['original_price'] ?? null;
        $discountType = $discountData['discount_type'] ?? null;
        $discountValue = $discountData['discount_value'] ?? null;
      
        // Set the price based on session key
        if ($session_key == 'purchases') {
            $productprice = $product->purchase_price != 0 ? $product->purchase_price : 0;
        } else if ($session_key == 'pos') {
            // For POS, apply discount if available
            if ($discountedPrice !== null) {
                $productprice = $discountedPrice;
            } else {
                $productprice = $product->sale_price != 0 ? $product->sale_price : 0;
            }
        } else {
            // For other cases, apply discount if available
            if ($discountedPrice !== null) {
                $productprice = $discountedPrice;
            } else {
                $productprice = $product->sale_price != 0 ? $product->sale_price : $product->purchase_price;
            }
        }
    
        $originalquantity = (int)$productquantity;
        $taxes = \Workdo\Pos\Entities\Pos::tax($product->tax_id);
        $totalTaxRate = \Workdo\Pos\Entities\Pos::totalTaxRate($product->tax_id);
        $product_tax = '';
        $product_tax_id = [];
        
        foreach($taxes as $tax) {
            $product_tax .= !empty($tax) ? "<span class='badge badge-primary'>". $tax->name.' ('.$tax->rate.'%)'."</span><br>" : '';
            $product_tax_id[] = $tax->id;
        }
    
        if(empty($product_tax)) {
            $product_tax = "-";
        }
    
        $producttax = $totalTaxRate;
        $tax = ($productprice * $producttax) / 100;
        $subtotal = $productprice + $tax;
        
        // Calculate and store image URL
        $image_url = (check_file($product->image) && get_file($product->image)) ? $product->image : asset('packages/workdo/ProductService/src/Resources/assets/image/img01.jpg');
    
        // Handle multi-cart system
        $cartId = null;
        $allCarts = null;
        $workspaceId = null;
        
        if ($session_key == 'pos') {
            $this->initCartSession();
            $workspaceId = $this->getCurrentWorkspaceId();
            $allCarts = Session::get('pos_carts');
            
            // Use active cart for barcode scanning
            $cartId = Session::get("active_pos_cart_{$workspaceId}");
            if (!$cartId) {
                $cartId = $this->getDefaultCartId($workspaceId);
            }
            
            // Validate cart exists
            if (!isset($allCarts[$workspaceId][$cartId])) {
                return response()->json([
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('Cart not found!'),
                ], 404);
            }
            
            $cart = $allCarts[$workspaceId][$cartId]['items'];
        } else {
            // For non-POS sessions, use the old system
            $cart = session()->get($session_key);
        }
    
        $model_delete_id = 'delete-form-' . $id;
    
        // Create discount display HTML
        $priceHtml = '';
        $discountLabel = '';
        
        if ($discountedPrice !== null && $originalPrice !== null) {
            if ($discountType == 0) {
                $discountLabel = "<span class='badge bg-warning text-dark'>{$discountValue}% Off</span>";
            } else {
                $discountLabel = "<span class='badge bg-warning text-dark'>" . currency_format_with_sym($discountValue) . " Off</span>";
            }
            
            $priceHtml = '<span><del>' . currency_format_with_sym($originalPrice) . '</del> ' . 
                          currency_format_with_sym($productprice) . ' ' . $discountLabel . '</span>';
                        
        } else {
            $priceHtml = currency_format_with_sym($productprice);
        }
    
        // Generate cart HTML using the helper method
        $carthtml = $this->generateCartItemHtml($id, $productname, $image_url, $productquantity, $product_tax, $priceHtml, $subtotal, $model_delete_id, $session_key, $cartId);
    
        // Create cart item data structure
        $cartItemData = [
            "name" => $productname,
            "quantity" => 1,
            "price" => $productprice,
            "id" => $id,
            "image" => $image_url, // Store image in session
            "tax_price" => $tax,
            "tax" => $producttax,
            "subtotal" => $subtotal,
            "originalquantity" => $originalquantity,
            "product_tax" => $product_tax,
            "product_tax_id" => !empty($product_tax_id) ? implode(',', $product_tax_id) : 0,
            "discount_type" => $discountType,
            "discount_value" => $discountValue,
            "original_price" => $originalPrice,
            "total_discount" => $originalPrice && $discountedPrice ? ($originalPrice - $discountedPrice) : 0,
        ];
    
        // Handle cart logic
        if (!$cart) {
            // Create new cart
            $cart = [$id => $cartItemData];
            
            if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'pos') {
                return response()->json([
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This product is out of stock!'),
                ], 404);
            }
    
             if ($session_key == 'pos' && $allCarts && $workspaceId) {
                $totalQuantityInAllCarts = $this->getTotalQuantityAcrossAllCarts($id, $allCarts, $workspaceId);
                if ($originalquantity <= $totalQuantityInAllCarts) {
                    return response()->json([
                        'code' => 404,
                        'status' => 'Error',
                         'error' => __('This product is out of stock. All available units are already in other carts.'),
                    ], 404);
                }
            } else if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'pos') {
                return response()->json([
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This product is out of stock!'),
                ], 404);
            }
            
            $this->saveCart($session_key, $cart, $allCarts, $workspaceId, $cartId);
            
            $totalWithoutDiscount = $this->calculateTotalWithoutDiscount($cart);
            return response()->json([
                'code' => 200,
                'status' => 'Success',
                'success' => $productname . __(' added to cart successfully!'),
                'product' => $cart[$id],
                'carthtml' => $carthtml,
                'totalWithoutDiscount' => currency_format_with_sym($totalWithoutDiscount),
                'cart_id' => $cartId ?? null,
            ]);
        }
    
        // If cart not empty then check if this product exists then increment quantity
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            $cart[$id]['id'] = $id;
            $cart[$id]['image'] = $image_url; // Update image in session
    
            // Recalculate totals based on new quantity
            $subtotal = $cart[$id]["price"] * $cart[$id]["quantity"];
            $tax = ($subtotal * $cart[$id]["tax"]) / 100;
    
            $cart[$id]["subtotal"] = $subtotal + $tax;
            $cart[$id]["tax_price"] = $tax;
            $cart[$id]["originalquantity"] = $originalquantity;
            $cart[$id]["total_discount"] = $originalPrice && $discountedPrice ? ($originalPrice - $discountedPrice) * $cart[$id]['quantity'] : 0;
            
            if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'pos') {
                return response()->json([
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This product is out of stock!'),
                ], 404);
            }
            if ($session_key == 'pos' && $allCarts && $workspaceId) {
            $totalQuantityInAllCarts = $this->getTotalQuantityAcrossAllCarts($id, $allCarts, $workspaceId);
            if ($originalquantity <= $totalQuantityInAllCarts) {
                return response()->json([
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This product is out of stock. All available units are already in other carts.'),
                ], 404);
            }
                } else if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'pos') {
                    return response()->json([
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ], 404);
                }
    
            $this->saveCart($session_key, $cart, $allCarts, $workspaceId, $cartId);
            
            $totalWithoutDiscount = $this->calculateTotalWithoutDiscount($cart);
            return response()->json([
                'code' => 200,
                'status' => 'Success',
                'success' => $productname . __(' added to cart successfully!'),
                'product' => $cart[$id],
                'carttotal' => $cart,
                'totalWithoutDiscount' => currency_format_with_sym($totalWithoutDiscount),
                'cart_id' => $cartId ?? null,
            ]);
        }
    
        // If item doesn't exist in cart then add to cart with quantity = 1
        $cart[$id] = $cartItemData;
    
        if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'pos') {
            return response()->json([
                'code' => 404,
                'status' => 'Error',
                'error' => __('This product is out of stock!'),
            ], 404);
        }
    
        $this->saveCart($session_key, $cart, $allCarts, $workspaceId, $cartId);
        
        $totalWithoutDiscount = $this->calculateTotalWithoutDiscount($cart);
        return response()->json([
            'code' => 200,
            'status' => 'Success',
            'success' => $productname . __(' added to cart successfully!'),
            'product' => $cart[$id],
            'carthtml' => $carthtml,
            'carttotal' => $cart,
            'totalWithoutDiscount' => currency_format_with_sym($totalWithoutDiscount),
            'cart_id' => $cartId ?? null,
        ]);
    }
        
    private function getTotalQuantityAcrossAllCarts($productId, $allCarts, $workspaceId)
    {
        $totalQuantity = 0;
        
        if (isset($allCarts[$workspaceId])) {
            foreach ($allCarts[$workspaceId] as $cartId => $cartData) {
                if (isset($cartData['items'][$productId])) {
                    $totalQuantity += $cartData['items'][$productId]['quantity'];
                }
            }
        }
        
        return $totalQuantity;
    }    
        
    public function register(Request $request)
    {
        $currentRegister = RegisterLog::whereNull('closed_at')->where('created_by', creatorId())->where('workspace',getActiveWorkSpace())->first();
        // $closedRegisters  = RegisterLog::whereNotNull('closed_at')
        //     ->orderBy('closed_at', 'desc')
        //     ->where('created_by', creatorId())
        //     ->where('workspace',getActiveWorkSpace())
        //     ->paginate(10);
        $closedRegisters = RegisterLog::whereNotNull('closed_at')
        ->where('created_by', creatorId())
        ->where('workspace', getActiveWorkSpace())
        ->when($request->filled('from_date'), function($query) use ($request) {
            $query->whereDate('closed_at', '>=', $request->from_date);
        })
        ->when($request->filled('to_date'), function($query) use ($request) {
            $query->whereDate('closed_at', '<=', $request->to_date);
        })
        ->orderBy('closed_at', 'desc')
        ->paginate(10)
        ->appends($request->query());

        
        return view('register.index', compact('currentRegister', 'closedRegisters'));
    }
    
    public function openRegister(Request $request)
    {
        $request->validate([
            'opening_balance' => 'required|numeric|min:0',
            'opening_note' => 'nullable|string|max:500'
        ]);

        // Check if there's already an open register
        if (RegisterLog::whereNull('closed_at')->where('workspace', getActiveWorkSpace())->exists()) {
            return back()->with('error', 'There is already an open register. Please close it first.');
        }

        RegisterLog::create([

            'opening_balance' => $request->opening_balance,
            'opening_note' => $request->opening_note,
            'opened_at' => now(),
            'workspace' => getActiveWorkSpace(),
            'created_by' => creatorId()
            
        ]);

        return redirect()->route('pos.index')->with('success', 'Register opened successfully.');
    }
    
    public function showCloseForm()
    {
        $register = RegisterLog::whereNull('closed_at')->where('created_by', creatorId())->where('workspace',getActiveWorkSpace())->firstOrFail();
        return view('register.close', compact('register'));
    }
    
    public function closeregister(Request $request)
    {
        $request->validate([
            'closing_balance' => 'required|numeric|min:0',
            'closing_note' => 'nullable|string|max:500'
        ]);

        $register = RegisterLog::whereNull('closed_at')->where('created_by', creatorId())->where('workspace',getActiveWorkSpace())->firstOrFail();

        $register->update([
            'closing_balance' => $request->closing_balance,
            'closing_note' => $request->closing_note,
            'closed_at' => now()
        ]);

        return redirect()->route('register.index')->with('success', 'Register closed successfully.');
    }
    
    ////////
    private function getCurrentWorkspaceId()
    {
        // Get current workspace ID - adjust this based on your workspace implementation
        return getActiveWorkSpace() ?? 1;
    }

   private function initCartSession()
    {
        $workspaceId = $this->getCurrentWorkspaceId();
        
        if (!Session::has('pos_carts')) {
            Session::put('pos_carts', []);
        }
        
        // Initialize workspace-specific carts if not exists
        $allCarts = Session::get('pos_carts');
        if (!isset($allCarts[$workspaceId])) {
            $allCarts[$workspaceId] = [];
            Session::put('pos_carts', $allCarts);
        }
        
        // Ensure default cart exists for workspace
        $this->ensureDefaultCart($workspaceId);
        
        // Initialize active cart for workspace if not set
        if (!Session::has("active_pos_cart_{$workspaceId}")) {
            $defaultCartId = $this->getDefaultCartId($workspaceId);
            Session::put("active_pos_cart_{$workspaceId}", $defaultCartId);
        }
        
        // Maintain backward compatibility with original 'active_pos_cart' key
        $currentActiveCart = Session::get("active_pos_cart_{$workspaceId}");
        Session::put('active_pos_cart', $currentActiveCart);
    }

    private function ensureDefaultCart($workspaceId)
    {
        $allCarts = Session::get('pos_carts');
        $workspaceCarts = $allCarts[$workspaceId] ?? [];
        
        // Check if default cart exists
        $defaultCartExists = false;
        foreach ($workspaceCarts as $cartId => $cart) {
            if (isset($cart['is_default']) && $cart['is_default'] === true) {
                $defaultCartExists = true;
                break;
            }
        }
        
        // Create default cart if it doesn't exist
        if (!$defaultCartExists) {
            $defaultCartId = "cart_default_{$workspaceId}_" . uniqid();
            $allCarts[$workspaceId][$defaultCartId] = [
                'name' => 'Default Cart',
                'items' => [],
                'customer_id' => null,
                'warehouse_id' => null,
                'discount' => 0,
                'is_default' => true,
                'workspace_id' => $workspaceId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            Session::put('pos_carts', $allCarts);
        }
    }

    private function getDefaultCartId($workspaceId)
    {
        $allCarts = Session::get('pos_carts');
        $workspaceCarts = $allCarts[$workspaceId] ?? [];
        
        foreach ($workspaceCarts as $cartId => $cart) {
            if (isset($cart['is_default']) && $cart['is_default'] === true) {
                return $cartId;
            }
        }
        
        return null;
    }

    private function getWorkspaceCarts($workspaceId)
    {
        $allCarts = Session::get('pos_carts');
        return $allCarts[$workspaceId] ?? [];
    }

    private function getFormattedCarts()
    {
        $workspaceId = $this->getCurrentWorkspaceId();
        $workspaceCarts = $this->getWorkspaceCarts($workspaceId);
        
        $formatted = [];
        foreach ($workspaceCarts as $cartId => $cart) {
            $formatted[] = [
                'id' => $cartId,
                'name' => $cart['name'],
                'is_default' => $cart['is_default'] ?? false,
                'workspace_id' => $cart['workspace_id'],
                'created_at' => $cart['created_at'],
                'updated_at' => $cart['updated_at'],
            ];
        }
        
        // Sort to show default cart first
        usort($formatted, function($a, $b) {
            if ($a['is_default'] && !$b['is_default']) return -1;
            if (!$a['is_default'] && $b['is_default']) return 1;
            return strtotime($a['created_at']) - strtotime($b['created_at']);
        });
        
        return $formatted;
    }

    private function calculateCartTotal($items)
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function getCarts()
    {
        $this->initCartSession();
        $workspaceId = $this->getCurrentWorkspaceId();
        
        $response = [
            'success' => true,
            'carts' => $this->getFormattedCarts(),
            'active_cart' => Session::get("active_pos_cart_{$workspaceId}"),
            'active_pos_cart' => Session::get("active_pos_cart_{$workspaceId}"), // Backward compatibility
            'workspace_id' => $workspaceId
        ];
        
        return response()->json($response)
            ->header('Content-Type', 'application/json');
    }

    public function createCart(Request $request)
    {
        $this->initCartSession();
        $workspaceId = $this->getCurrentWorkspaceId();
        
        $cartId = "cart_{$workspaceId}_" . uniqid();
        $allCarts = Session::get('pos_carts');
        $workspaceCarts = $allCarts[$workspaceId];
        
        $workspaceCarts[$cartId] = [
            'name' => $request->input('name', 'Cart ' . (count($workspaceCarts) + 1)),
            'items' => [],
            'customer_id' => null,
            'warehouse_id' => null,
            'discount' => 0,
            'is_default' => false, // New carts are never default
            'workspace_id' => $workspaceId,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        $allCarts[$workspaceId] = $workspaceCarts;
        Session::put('pos_carts', $allCarts);
        
        return response()->json([
            'success' => true,
            'cartId' => $cartId,
            'carts' => $this->getFormattedCarts(),
            'workspace_id' => $workspaceId
        ]);
    }

    public function switchCart(Request $request)
    {
        $this->initCartSession();
        $workspaceId = $this->getCurrentWorkspaceId();
        
        $cartId = $request->input('cart_id');
        
        // Validate cart ID format first
        if (!$cartId) {
            return response()->json([
                'success' => false,
                'message' => 'Cart ID is required'
            ], 400);
        }
        
        $workspaceCarts = $this->getWorkspaceCarts($workspaceId);
        
        // Debug: Log the available carts
        \Log::info('Available carts for workspace ' . $workspaceId, array_keys($workspaceCarts));
        \Log::info('Trying to switch to cart: ' . $cartId);
        
        if (!isset($workspaceCarts[$cartId])) {
            return response()->json([
                'success' => false,
                'message' => 'Cart not found in current workspace',
                'debug' => [
                    'workspace_id' => $workspaceId,
                    'requested_cart_id' => $cartId,
                    'available_carts' => array_keys($workspaceCarts)
                ]
            ], 404);
        }
        
        Session::put("active_pos_cart_{$workspaceId}", $cartId);
        Session::put('active_pos_cart', $cartId); // Backward compatibility
        
        return response()->json([
            'success' => true,
            'active_cart' => $cartId,
            'active_pos_cart' => $cartId, // Backward compatibility
            'carts' => $this->getFormattedCarts(),
            'message' => 'Cart switched successfully'
        ]);
    }

    public function deleteCart(Request $request)
    {
        $this->initCartSession();
        $workspaceId = $this->getCurrentWorkspaceId();
        // $cartId = $id ;
        $cartId = $request->input('cart_id');
        $allCarts = Session::get('pos_carts');
        $workspaceCarts = $allCarts[$workspaceId];
        
        // Check if cart exists and is not default
        if (!isset($workspaceCarts[$cartId])) {
            return response()->json([
                'success' => false,
                'message' => 'Cart not found'
            ], 404);
        }
        
        if (isset($workspaceCarts[$cartId]['is_default']) && $workspaceCarts[$cartId]['is_default']) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete default cart'
            ], 400);
        }
        
        // If deleting active cart, switch to default cart
        $activeCart = Session::get("active_pos_cart_{$workspaceId}");
        if ($activeCart === $cartId) {
            $defaultCartId = $this->getDefaultCartId($workspaceId);
            Session::put("active_pos_cart_{$workspaceId}", $defaultCartId);
            Session::put('active_pos_cart', $defaultCartId); // Backward compatibility
        }
        
        // Remove cart
        unset($workspaceCarts[$cartId]);
        $allCarts[$workspaceId] = $workspaceCarts;
        Session::put('pos_carts', $allCarts);
        
        return response()->json([
            'success' => true,
            'message' => 'Cart deleted successfully',
            'carts' => $this->getFormattedCarts(),
            'active_cart' => Session::get("active_pos_cart_{$workspaceId}"),
            'active_pos_cart' => Session::get("active_pos_cart_{$workspaceId}") // Backward compatibility
        ]);
    }

    public function switchWorkspace(Request $request)
    {
        $newWorkspaceId = $request->input('workspace_id');
        
        // Update current workspace - adjust based on your implementation
        if (auth()->user()) {
            auth()->user()->update(['current_workspace_id' => $newWorkspaceId]);
        } else {
            session(['current_workspace_id' => $newWorkspaceId]);
        }
        
        // Initialize carts for new workspace
        $this->initCartSession();
        
        return response()->json([
            'success' => true,
            'workspace_id' => $newWorkspaceId,
            'carts' => $this->getFormattedCarts(),
            'active_cart' => Session::get("active_pos_cart_{$newWorkspaceId}"),
            'active_pos_cart' => Session::get("active_pos_cart_{$newWorkspaceId}") // Backward compatibility
        ]);
    }

    public function getActiveCart()
    {
        $this->initCartSession();
        $workspaceId = $this->getCurrentWorkspaceId();
        
        $activeCartId = Session::get("active_pos_cart_{$workspaceId}");
        $workspaceCarts = $this->getWorkspaceCarts($workspaceId);
        
        if (!$activeCartId || !isset($workspaceCarts[$activeCartId])) {
            // Fallback to default cart
            $activeCartId = $this->getDefaultCartId($workspaceId);
            Session::put("active_pos_cart_{$workspaceId}", $activeCartId);
            Session::put('active_pos_cart', $activeCartId); // Backward compatibility
        }
        
        return response()->json([
            'success' => true,
            'cart' => $workspaceCarts[$activeCartId] ?? null,
            'cart_id' => $activeCartId
        ]);
    }

    // Debug method to see session state
    public function debugSession()
    {
        $workspaceId = $this->getCurrentWorkspaceId();
        $allCarts = Session::get('pos_carts', []);
        $activeCart = Session::get("active_pos_cart_{$workspaceId}");
        
        return response()->json([
            'workspace_id' => $workspaceId,
            'all_carts' => $allCarts,
            'workspace_carts' => $allCarts[$workspaceId] ?? [],
            'active_cart' => $activeCart,
            'session_keys' => array_keys(Session::all())
        ]);
    }

    // Method to clear and reinitialize carts for testing
    public function resetCarts()
    {
        Session::forget('pos_carts');
        Session::forget('active_pos_cart_' . $this->getCurrentWorkspaceId());
        
        $this->initCartSession();
        
        return response()->json([
            'success' => true,
            'message' => 'Carts reset successfully',
            'carts' => $this->getFormattedCarts()
        ]);
    }

    // Enhanced method to update cart items
    public function updateCartItem(Request $request)
    {
        $this->initCartSession();
        $workspaceId = $this->getCurrentWorkspaceId();
        
        $cartId = $request->input('cart_id') ?? Session::get("active_pos_cart_{$workspaceId}");
        $itemIndex = $request->input('item_index');
        $quantity = $request->input('quantity');
        
        $allCarts = Session::get('pos_carts');
        
        if (!isset($allCarts[$workspaceId][$cartId])) {
            return response()->json([
                'success' => false,
                'message' => 'Cart not found'
            ], 404);
        }
        
        if (!isset($allCarts[$workspaceId][$cartId]['items'][$itemIndex])) {
             return response()->json(
                [
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This product is out of stock!'),
                ],
                404
            );
        }
        
        if ($quantity <= 0) {
            // Remove item if quantity is 0 or negative
            unset($allCarts[$workspaceId][$cartId]['items'][$itemIndex]);
            $allCarts[$workspaceId][$cartId]['items'] = array_values($allCarts[$workspaceId][$cartId]['items']);
        } else {
            // Update quantity
            $allCarts[$workspaceId][$cartId]['items'][$itemIndex]['quantity'] = $quantity;
        }
        
        $allCarts[$workspaceId][$cartId]['updated_at'] = now();
        Session::put('pos_carts', $allCarts);
        
        return response()->json([
            'success' => true,
            'cart' => $allCarts[$workspaceId][$cartId],
            'carts' => $this->getFormattedCarts()
        ]);
    }

    // Method to remove item from cart
    public function removeCartItem(Request $request)
    {
        $this->initCartSession();
        $workspaceId = $this->getCurrentWorkspaceId();
        
        $cartId = $request->input('cart_id') ?? Session::get("active_pos_cart_{$workspaceId}");
        $itemIndex = $request->input('item_index');
        
        $allCarts = Session::get('pos_carts');
        
        if (!isset($allCarts[$workspaceId][$cartId])) {
            return response()->json([
                'success' => false,
                'message' => 'Cart not found'
            ], 404);
        }
        
        if (!isset($allCarts[$workspaceId][$cartId]['items'][$itemIndex])) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found'
            ], 404);
        }
        
        unset($allCarts[$workspaceId][$cartId]['items'][$itemIndex]);
        $allCarts[$workspaceId][$cartId]['items'] = array_values($allCarts[$workspaceId][$cartId]['items']);
        $allCarts[$workspaceId][$cartId]['updated_at'] = now();
        
        Session::put('pos_carts', $allCarts);
        
        return response()->json([
            'success' => true,
            'cart' => $allCarts[$workspaceId][$cartId],
            'carts' => $this->getFormattedCarts()
        ]);
    }

    public function getCartItems(Request $request)
    {
        $this->initCartSession();
        $workspaceId = $this->getCurrentWorkspaceId();
        
        $cartId = $request->input('cart_id') ?? Session::get("active_pos_cart_{$workspaceId}");
        $workspaceCarts = $this->getWorkspaceCarts($workspaceId);
        
        if (!$cartId || !isset($workspaceCarts[$cartId])) {
            // Fallback to default cart
            $cartId = $this->getDefaultCartId($workspaceId);
            if (!$cartId || !isset($workspaceCarts[$cartId])) {
                return response()->json([
                    'success' => false,
                    'message' => 'No cart available'
                ], 404);
            }
        }
        
        $cart = $workspaceCarts[$cartId];
        $cartItems = $cart['items'] ?? [];
        
        // Process cart items to ensure images are available
        $processedItems = [];
        foreach ($cartItems as $itemId => $item) {
            // Ensure image is available - if not, get from product
            if (!isset($item['image']) || empty($item['image'])) {
                $product = \Workdo\ProductService\Entities\ProductService::find($itemId);
                if ($product) {
                    $item['image'] = (check_file($product->image) && get_file($product->image)) 
                        ? $product->image 
                        : asset('packages/workdo/ProductService/src/Resources/assets/image/img01.jpg');
                    
                    // Update the session with the image
                    $this->updateCartItemImage($workspaceId, $cartId, $itemId, $item['image']);
                }
            }
            $processedItems[$itemId] = $item;
        }
        
        // Set active cart
        Session::put("active_pos_cart_{$workspaceId}", $cartId);
        
        return response()->json([
            'success' => true,
            'cart_id' => $cartId,
            'items' => $processedItems,
            'cart_name' => $cart['name'],
            'total' => $this->calculateCartTotal($processedItems),
            'totalWithoutDiscount' => currency_format_with_sym($this->calculateTotalWithoutDiscount($processedItems)),
            'customer_id' => $cart['customer_id'] ?? null,
            'warehouse_id' => $cart['warehouse_id'] ?? 1,
            'discount' => $cart['discount'] ?? 0,
            'item_count' => count($processedItems)
        ]);
    }

    /**
     * Helper method to update cart item image in session
     */
    private function updateCartItemImage($workspaceId, $cartId, $itemId, $imageUrl)
    {
        $allCarts = Session::get('pos_carts', []);
        
        if (isset($allCarts[$workspaceId][$cartId]['items'][$itemId])) {
            $allCarts[$workspaceId][$cartId]['items'][$itemId]['image'] = $imageUrl;
            $allCarts[$workspaceId][$cartId]['updated_at'] = now();
            Session::put('pos_carts', $allCarts);
        }
    }

   
}
