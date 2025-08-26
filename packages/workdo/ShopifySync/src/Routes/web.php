<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Workdo\ShopifySync\Http\Controllers\ShopifyCategoryController;
use Workdo\ShopifySync\Http\Controllers\ShopifyCouponController;
use Workdo\ShopifySync\Http\Controllers\ShopifyCustomerController;
use Workdo\ShopifySync\Http\Controllers\ShopifyOrderController;
use Workdo\ShopifySync\Http\Controllers\ShopifyProductController;
use Workdo\ShopifySync\Http\Controllers\ShopifySyncController;

Route::group(['middleware' => ['web', 'auth', 'verified','PlanModuleCheck:ShopifySync']], function () {

    Route::post('shopify/setting', [ShopifySyncController::class,'setting'])->name('shopify.setting');
    Route::resource('shopify-customer',ShopifyCustomerController::class);
    Route::resource('shopify-product',ShopifyProductController::class);
    Route::any('shopify-product-create/{id}',[ShopifyProductController::class ,'showCreateForm' ])->name('product.shopify.create');
    Route::post('shopify-product-store',[ShopifyProductController::class ,'product_store' ])->name('product.shopify.store');
    Route::resource('shopify-order',ShopifyOrderController::class);
    Route::resource('shopify-category',ShopifyCategoryController::class);
    Route::resource('shopify-coupon',ShopifyCouponController::class);
});
