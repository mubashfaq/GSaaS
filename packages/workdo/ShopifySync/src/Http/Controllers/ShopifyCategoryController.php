<?php

namespace Workdo\ShopifySync\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\ShopifySync\Entities\ShopifyConection;
use Workdo\ShopifySync\Events\CreateShopify;
use Workdo\ShopifySync\Events\EditShopify;

use Workdo\ProductService\Entities\Category;


class ShopifyCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(Auth::user()->isAbleTo('shopify category manage'))
        {
            $company_settings = getCompanyAllSetting();
            $shopify_store_url = isset($company_settings['shopify_store_url']) ? $company_settings['shopify_store_url'] : '';
            $shopify_access_token = isset($company_settings['shopify_access_token']) ? $company_settings['shopify_access_token'] : '';

            if(!empty($shopify_store_url ) && !empty($shopify_access_token))
            {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://{$shopify_store_url}.myshopify.com/admin/api/2023-07/custom_collections.json",
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
                $shopify_categorys = json_decode($response, true);
                $shopify_conection = ShopifyConection::where('created_by', '=', creatorId())->where('workspace_id',getActiveWorkSpace())->where('type','category')->pluck('shopify_id')->toarray();

                return view('shopify-sync::shopifycategory.index',compact('shopify_categorys','shopify_conection'));
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
        if(Auth::user()->isAbleTo('shopify category create'))
        {
            $company_settings = getCompanyAllSetting();
            $shopify_store_url = isset($company_settings['shopify_store_url']) ? $company_settings['shopify_store_url'] : '';
            $shopify_access_token = isset($company_settings['shopify_access_token']) ? $company_settings['shopify_access_token'] : '';

            if(!empty($shopify_store_url ) && !empty($shopify_access_token))
            {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://{$shopify_store_url}.myshopify.com/admin/api/2023-07/custom_collections/{$id}.json",
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

                $shopify_categorys = json_decode($response, true);
                $category             = new Category();
                $category->name       = $shopify_categorys['custom_collection']['title'];
                $category->color      = '#fc544b';
                $category->type       = 0;
                $category->created_by       = creatorId();
                $category->workspace_id     =  getActiveWorkSpace();
                $category->save();

                $Category                   = new ShopifyConection();
                $Category->type             = 'category';
                $Category->shopify_id       = $id;
                $Category->original_id      = $category->id;
                $Category->created_by       = creatorId();
                $Category->workspace_id     = getActiveWorkSpace();
                $Category->save();

                event(new CreateShopify($shopify_categorys, $Category));


                return redirect()->back()->with('success', __('The Category has been created successfully.'));


            }
            else
            {
                return redirect()->back()->with('error',__('Please configure the Shopify store settings.'));
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
        if(Auth::user()->isAbleTo('shopify category edit'))
        {
            $company_settings = getCompanyAllSetting();
            $shopify_store_url = isset($company_settings['shopify_store_url']) ? $company_settings['shopify_store_url'] : '';
            $shopify_access_token = isset($company_settings['shopify_access_token']) ? $company_settings['shopify_access_token'] : '';

            if(!empty($shopify_store_url ) && !empty($shopify_access_token))
            {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://{$shopify_store_url}.myshopify.com/admin/api/2023-07/custom_collections/{$id}.json",
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
                $shopify_categorys = json_decode($response, true);

                $shopify_conection        = ShopifyConection::where('created_by', '=', creatorId())->where('workspace_id',getActiveWorkSpace())->where('type','category')->where('shopify_id' ,$id)->first();
                $category             = Category::where('id',$shopify_conection->original_id)->where('created_by', '=', creatorId())->where('workspace_id',getActiveWorkSpace())->where('type',0)->first();
                $Category                   = $category;
                $Category->name             = $shopify_categorys['custom_collection']['title'];
                $Category->created_by       = creatorId();
                $Category->workspace_id     =  getActiveWorkSpace();
                $Category->save();
                event(new EditShopify($shopify_categorys, $Category));

                // return redirect()->back()->with('sucess', __('Category successfully created.'));

                return redirect()->back()->with('success', __('The Category details are updated successfully.'));


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
}
