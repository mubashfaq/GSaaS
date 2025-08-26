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
use Workdo\ConsignmentManagement\Http\Controllers\ConsignmentManagementController;
use Workdo\ConsignmentManagement\Http\Controllers\ProductController;
use Workdo\ConsignmentManagement\Http\Controllers\PurchaseOrderController;
use Workdo\ConsignmentManagement\Http\Controllers\SaleOrderController;
use Workdo\ProductService\Http\Controllers\ProductServiceController;
use Workdo\ConsignmentManagement\Http\Controllers\ConsignmentShippingController;
use Workdo\ConsignmentManagement\Http\Controllers\ConsignmentReturnController;
use Workdo\ConsignmentManagement\Http\Controllers\ConsignmentQualityControlController;
use Workdo\ConsignmentManagement\Http\Controllers\ConsignmentContractController;
use Workdo\ConsignmentManagement\Http\Controllers\ConsignmentComplianceController;

Route::group(['middleware' => ['web', 'auth', 'verified','PlanModuleCheck:ConsignmentManagement']], function () {

    Route::prefix('consignment')->group(function () {
        Route::resource('product', ProductController::class);
        Route::get('products-item/create', [ProductServiceController::class, 'create'])->name('product-item.create');
        Route::get('products-item/{id}/edit', [ProductServiceController::class, 'edit'])->name('product-item.edit');
        Route::delete('products-item/{id}/delete', [ProductServiceController::class, 'destroy'])->name('product-item.destroy');
        Route::get('products-item/{id}/show', [ProductServiceController::class, 'show'])->name('product-item.show');

        Route::resource('consignment', ConsignmentManagementController::class);
        Route::post('get-product', [ConsignmentManagementController::class, 'getProduct'])->name('get.product.data');
        Route::post('consignment-item/destroy', [ConsignmentmanagementController::class, 'ConsignmentItemDestroy'])->name('consignmentitem.destroy');

        Route::resource('purchase-order', PurchaseOrderController::class);
        Route::post('get-section', [PurchaseOrderController::class, 'getSection'])->name('get.section');
        Route::get('purchase-order/convert/{id}/popup', [PurchaseOrderController::class, 'ConvertToPurchasePopup'])->name('purchase.order.popup');
        Route::get('purchase-order/{id}/convert', [PurchaseOrderController::class, 'ConvertToPurchase'])->name('purchase.order.convert');

        Route::resource('sale-order', SaleOrderController::class);
        Route::get('sale-order/convert/{id}/popup', [SaleOrderController::class, 'ConvertToSalePopup'])->name('sale.order.popup');
        Route::get('sale-order/{id}/convert', [SaleOrderController::class, 'ConvertToInvoice'])->name('sale.order.convert');


        Route::resource('consignment-shipping', ConsignmentShippingController::class);
        Route::resource('consignment-return', ConsignmentReturnController::class);
        Route::resource('consignment-qualitycontrol', ConsignmentQualityControlController::class);


        Route::post('consignment-return-product' ,[ConsignmentReturnController::class ,'ReturnProduct'])->name('consignment.return.product');
        Route::post('consignment-qualitycontrol-product' ,[ConsignmentQualityControlController::class ,'qualitycontrolproduct'])->name('consignment.qualitycontrol.product');

        Route::resource('consignment-contract', ConsignmentContractController::class);
        Route::resource('consignment-compliance', ConsignmentComplianceController::class);

    });
});
