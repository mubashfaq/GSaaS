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
use Workdo\ProductService\Http\Controllers\CategoryController;
use Workdo\ProductService\Http\Controllers\ProductServiceController;
use Workdo\RestaurantMenu\Http\Controllers\RestaurantCartController;
use Workdo\RestaurantMenu\Http\Controllers\RestaurantCategoryController;
use Workdo\RestaurantMenu\Http\Controllers\RestaurantCustomerController;
use Workdo\RestaurantMenu\Http\Controllers\RestaurantDiningTableController;
use Workdo\RestaurantMenu\Http\Controllers\RestaurantMenuController;
use Workdo\RestaurantMenu\Http\Controllers\RestaurantOfferController;
use Workdo\RestaurantMenu\Http\Controllers\RestaurantOrderController;
use Workdo\RestaurantMenu\Http\Controllers\RestaurantPlaceOrderController;
use Workdo\RestaurantMenu\Http\Controllers\RestaurantSystemSetController;
use Workdo\RestaurantMenu\Http\Controllers\RestaurantVarientController;

Route::group(['middleware' => ['web', 'auth', 'verified','PlanModuleCheck:RestaurantMenu']], function () {
    Route::prefix('restaurantmenu')->group(function () {

        Route::resource('restaurant-items', RestaurantMenuController::class);
        Route::resource('restaurant-offers', RestaurantOfferController::class);
        Route::resource('restaurant-customer', RestaurantCustomerController::class);
        Route::resource('restaurant-items-attribute', RestaurantSystemSetController::class);
        // Route::resource('restaurant-varient', RestaurantVarientController::class);
        Route::resource('restaurant-dining-table', RestaurantDiningTableController::class);
        Route::resource('restaurant-category', RestaurantCategoryController::class);
        Route::get('restaurant', [ProductServiceController::class,'create'])->name('restaurant-item');
        Route::get('restaurant-category/create', [CategoryController::class,'create'])->name('restaurant-category-create');
        Route::get('restaurant-category/edit/{id}', [CategoryController::class,'edit'])->name('restaurant-category-edit');
        Route::delete('restaurant-category/delete/{id}', [CategoryController::class,'destroy'])->name('restaurant-category-destroy');
        Route::get('restaurant-order', [RestaurantOrderController::class, 'index'])->name('restaurant-order.index');
        Route::get('restaurant-order-show/{id}', [RestaurantOrderController::class, 'show'])->name('restaurant-order.show');
    });
});
Route::group(['middleware' => ['web']], function () {
Route::any('restaurant-qr-reader/{workspace?}/{table_id}',[RestaurantDiningTableController::class,'qrReader'])->name('restaurant-qr-reader');
Route::get('restaurant-store-cart/{workspace?}/{table_id}', [RestaurantPlaceOrderController::class, 'storeCart'])->name('restaurant-store-cart');
Route::post('restaurant-product-qty/{item_id?}/{workspace?}/{table_id}/{key?}', [RestaurantCartController::class, 'productQty'])->name('restaurant-product_qty.product_qty');
Route::get('restaurant-check-out/{workspace?}/{table_id}/{total}', [RestaurantCartController::class, 'checkoutCart'])->name('restaurant-check-out');
Route::post('restaurant-order/{workspace?}/{table_id}', [RestaurantOrderController::class, 'store'])->name('restaurant-order');
Route::get('restaurant-order-update/{id}', [RestaurantOrderController::class, 'update'])->name('restaurant-order.update');
Route::get('restaurant-order-status/{workspace?}/{table_id}', [RestaurantOrderController::class, 'showOrderStatus'])->name('restaurant-order-status');
Route::get('restaurant-order-status-change/{workspace?}/{table_id}/{order_id}', [RestaurantOrderController::class, 'orderStatusChange'])->name('restaurant-order-status-change');
Route::get('restaurant-place-order/{item_id}/{table_id}', [RestaurantPlaceOrderController::class,'index'])->name('restaurant-place-order');
Route::post('restaurant-place-order-store/{item_id}/{table_id}', [RestaurantPlaceOrderController::class,'placeOrderStore'])->name('restaurant-place-order-store');
Route::delete('restaurant-add-to-cart/delete/{workspace?}/{table_id}/{id}', [RestaurantCartController::class,'destroy'])->name('restaurant-add-to-cart-destroy');
});
