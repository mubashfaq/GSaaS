<?php

namespace Workdo\ShopifySync\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Setting;

class ShopifySyncController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function setting(Request $request)
    {
        if (Auth::user()->isAbleTo('shopify manage')) {
            $getActiveWorkSpace = getActiveWorkSpace();
            $creatorId = creatorId();
            if($request->has('shopify_setting_is_on'))
            {
                $validator = Validator::make($request->all(),
                [
                    'shopify_store_url' => 'required',
                    'shopify_access_token' => 'required',
                ]);
                if($validator->fails()){
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }
                $post = $request->all();
                unset($post['_token']);
                foreach ($post as $key => $value) {
                    // Define the data to be updated or inserted
                    $data = [
                        'key' => $key,
                        'workspace' => $getActiveWorkSpace,
                        'created_by' => $creatorId,
                    ];

                    // Check if the record exists, and update or insert accordingly
                    Setting::updateOrInsert($data, ['value' => $value]);
                }
            }else{
                $data = [
                    'key' => 'shopify_setting_is_on',
                    'workspace' => $getActiveWorkSpace,
                    'created_by' => $creatorId,
                ];
                // Check if the record exists, and update or insert accordingly
                Setting::updateOrInsert($data, ['value' => 'off']);
            }

            // Settings Cache forget
            AdminSettingCacheForget();
            comapnySettingCacheForget();
            return redirect()->back()->with('success',__('The Shopify setting  has been save successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function index()
    {
        return view('shopify-sync::index');
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
        return view('shopify-sync::edit');
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
