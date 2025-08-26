<?php

namespace Workdo\ShopifySync\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\ProductService\Entities\Category;
use Workdo\ProductService\Entities\Tax;
use Workdo\ShopifySync\Entities\ShopifyConection;
use Workdo\ProductService\Entities\ProductService;
use Workdo\ShopifySync\Events\CreateShopifyProduct;
use Workdo\ShopifySync\Events\EditShopifyproduct;
use Illuminate\Support\Facades\File;




class ShopifyProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(Auth::user()->isAbleTo('shopify product manage'))
        {
            $company_settings = getCompanyAllSetting();
            $shopify_store_url = isset($company_settings['shopify_store_url']) ? $company_settings['shopify_store_url'] : '';
            $shopify_access_token = isset($company_settings['shopify_access_token']) ? $company_settings['shopify_access_token'] : '';

            if(!empty($shopify_store_url ) && !empty($shopify_access_token))
            {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://{$shopify_store_url}.myshopify.com/admin/api/2023-07/products.json",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        "X-Shopify-Access-Token: $shopify_access_token"
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                if ($response === false) {
                    return redirect()->back()->with('error', 'cURL Error: ' . curl_error($curl));
                }
                $shopify_products = json_decode($response, true);
                $shopify_conection = ShopifyConection::where('created_by', '=', creatorId())->where('workspace_id',getActiveWorkSpace())->where('type','product')->pluck('shopify_id')->toarray();

                return view('shopify-sync::shopifyproduct.index',compact('shopify_products','shopify_conection'));
            }
            else
            {
                return redirect()->back()->with('error', __('Please configure the Shopify store settings.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('shopify-sync::create');
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
        return view('shopify-sync::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        if(Auth::user()->isAbleTo('shopify product edit'))
        {
            $product_con = ShopifyConection::where('created_by', '=', creatorId())->where('workspace_id',getActiveWorkSpace())->where('shopify_id', $id)->where('type','product')->first();

            $product = ProductService::where('created_by', '=', creatorId())->where('workspace_id',getActiveWorkSpace())->where('id', $product_con->original_id)->first();
            $category             = Category::where('created_by', '=', creatorId())->where('workspace_id',getActiveWorkSpace())->where('type',0)->get()->pluck('name', 'id');


            $tax          = Tax::where('created_by', '=',creatorId())->where('workspace_id', '=', getActiveWorkSpace())->get()->pluck('name', 'id');

            return view('shopify-sync::shopifyproduct.edit' ,compact('id','category' ,'tax','product'));
        }
        else
        {
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

        if(Auth::user()->isAbleTo('shopify product edit'))
        {
            $company_settings = getCompanyAllSetting();
            $shopify_store_url = isset($company_settings['shopify_store_url']) ? $company_settings['shopify_store_url'] : '';
            $shopify_access_token = isset($company_settings['shopify_access_token']) ? $company_settings['shopify_access_token'] : '';

            if(!empty($shopify_store_url ) && !empty($shopify_access_token))
            {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://{$shopify_store_url}.myshopify.com/admin/api/2023-07/products.json?ids={$request->product_id }",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        "X-Shopify-Access-Token: $shopify_access_token"
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                if ($response === false) {
                    return redirect()->back()->with('error', 'cURL Error: ' . curl_error($curl));
                }
                $shopify_products = json_decode($response, true);
                $shopify_conection        = ShopifyConection::where('created_by', '=', creatorId())->where('workspace_id',getActiveWorkSpace())->where('type','product')->where('shopify_id' ,$id)->first();
                $productService             = ProductService::where('id',$shopify_conection->original_id)->where('created_by', '=', creatorId())->where('workspace_id',getActiveWorkSpace())->where('type',0)->first();
                $productService->name           = $shopify_products['products'][0]['title'];
                $productService->sku           = $shopify_products['products'][0]['variants'][0]['sku'];
                $productService->description    = strip_tags($shopify_products['products'][0]['body_html']);
                if($shopify_products['products'][0]['image']){
                    if(!empty($productService->image))
                    {
                      delete_file($productService->image);
                    }

                    $url    =$shopify_products['products'][0]['image']['src'];

                    $url =  strtok($url, '?');

                    $path   = '/products/';

                    $file_type = config('files_types');

                    foreach($file_type as $f){
                        $name = basename($url, ".".$f);
                    }
                    $file2 = rand(10,100).'_'.time() . "_" . $name;


                    $path =ShopifyConection::upload_woo_file($url,$file2,$path);

                    $productService->image          = empty($path) ? null : 'uploads'.$path['url'];
                }
                $productService->sale_price     = $shopify_products['products'][0]['variants'][0]['price'];
                if($shopify_products['products'][0]['variants'][0]['compare_at_price'] == null){
                    $productService->purchase_price =  $shopify_products['products'][0]['variants'][0]['price'] ;
                }else{
                    $productService->purchase_price = $shopify_products['products'][0]['variants'][0]['compare_at_price'];

                }
                if(!empty($request->tax_name)){
                    $productService->tax_id         =$request->tax_name;
                }else{
                    return redirect()->back()->with('error', __('Add Woocommerce Product Tax'));

                }
                $productService->unit_id        = 0;
                if($shopify_products['products'][0]['variants'][0]['inventory_quantity'] != 0)
                {
                    $productService->quantity        = $shopify_products['products'][0]['variants'][0]['inventory_quantity'];
                }
                else{
                    $productService->quantity   = 0;
                }
                $productService->type           = 'product';

                $productService->category_id    = $request->category_name;
                $productService->created_by     = creatorId();
                $productService->workspace_id     = getActiveWorkSpace();
                $productService->save();

                event(new EditShopifyproduct($shopify_products, $productService));
                return redirect()->back()->with('success' , __('The product details are updated successfully'));

            }
            else
            {
                return redirect()->back()->with('error', __('Please configure the Shopify store settings.'));
            }
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
        //
    }


    public function showCreateForm($id){


        if(Auth::user()->isAbleTo('shopify product create'))
        {
            $category             = Category::where('created_by', '=', creatorId())->where('workspace_id',getActiveWorkSpace())->where('type',0)->get()->pluck('name', 'id');
            $tax          = Tax::where('created_by', '=',creatorId())->where('workspace_id', '=', getActiveWorkSpace())->get()->pluck('name', 'id');
            return view('shopify-sync::shopifyproduct.create' ,compact('id','category' ,'tax'));
        }else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function product_store(Request $request ){

        if(Auth::user()->isAbleTo('shopify product create'))
        {
            $company_settings = getCompanyAllSetting();
            $shopify_store_url = isset($company_settings['shopify_store_url']) ? $company_settings['shopify_store_url'] : '';
            $shopify_access_token = isset($company_settings['shopify_access_token']) ? $company_settings['shopify_access_token'] : '';

            if(!empty($shopify_store_url ) && !empty($shopify_access_token))
            {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://{$shopify_store_url}.myshopify.com/admin/api/2023-07/products.json?ids={$request->product_id }",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        "X-Shopify-Access-Token: $shopify_access_token"
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                if ($response === false) {
                    return redirect()->back()->with('error', 'cURL Error: ' . curl_error($curl));
                }
                $shopify_products = json_decode($response, true);
                $productService                 = new ProductService();
                $productService->name           = $shopify_products['products'][0]['title'];
                $productService->sku           = $shopify_products['products'][0]['variants'][0]['sku'];
                $productService->description    = strip_tags($shopify_products['products'][0]['body_html']);
                if($shopify_products['products'][0]['image']){
                    $url    =$shopify_products['products'][0]['image']['src'];

                    $url =  strtok($url, '?');

                    $path   = '/products/';

                    $file_type = config('files_types');

                    foreach($file_type as $f){
                        $name = basename($url, ".".$f);
                    }
                    $file2 = rand(10,100).'_'.time() . "_" . $name;


                    $path =ShopifyConection::upload_woo_file($url,$file2,$path);

                    $productService->image          = empty($path) ? null : 'uploads'.$path['url'];
                }
                $productService->sale_price     = $shopify_products['products'][0]['variants'][0]['price'];
                if($shopify_products['products'][0]['variants'][0]['compare_at_price'] == null){
                    $productService->purchase_price =  $shopify_products['products'][0]['variants'][0]['price'] ;
                }else{
                    $productService->purchase_price = $shopify_products['products'][0]['variants'][0]['compare_at_price'];

                }
                if(!empty($request->tax_name)){
                    $productService->tax_id         =$request->tax_name;
                }else{
                    return redirect()->back()->with('error', __('Add Woocommerce Product Tax'));

                }
                $productService->unit_id        = 0;
                if($shopify_products['products'][0]['variants'][0]['inventory_quantity'] != 0)
                {
                    $productService->quantity        = $shopify_products['products'][0]['variants'][0]['inventory_quantity'];
                }
                else{
                    $productService->quantity   = 0;
                }
                $productService->type           = 'product';

                $productService->category_id    = $request->category_name;
                $productService->created_by     = creatorId();
                $productService->workspace_id     = getActiveWorkSpace();
                $productService->save();


                $Product                   = new ShopifyConection();
                $Product->type             = 'product';
                $Product->shopify_id    = $request->product_id;
                $Product->original_id      =$productService->id;
                $Product->created_by       = creatorId();
                $Product->workspace_id     =  getActiveWorkSpace();
                $Product->save();
                event(new CreateShopifyProduct($shopify_products, $productService ));
                return redirect()->back()->with('success' , __('The product has been created successfully'));

            }
            else
            {
                return redirect()->back()->with('error', __('Please configure the Shopify store settings.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


}
