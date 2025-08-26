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
use Workdo\Pos\Http\Controllers\PosController;
use Workdo\Pos\Http\Controllers\ReportController;

Route::group(['middleware' => ['web', 'auth', 'verified','PlanModuleCheck:Pos']], function ()
{

        Route::get('dashboard/pos',[PosController::class, 'dashboard'])->name('pos.dashboard');
        Route::post('pos/setting/store', [PosController::class, 'setting'])->name('pos.setting.store');
        Route::resource('pos', PosController::class);
        Route::get('pos-grid', [PosController::class, 'grid'])->name('pos.grid');
        Route::get('report/pos', [PosController::class, 'report'])->name('pos.report');
        Route::get('search-products', [PosController::class, 'searchProducts'])->name('search.products');
        Route::get('name-search-products', [PosController::class, 'searchProductsByName'])->name('name.search.products');
        Route::post('warehouse-empty-cart', [PosController::class, 'warehouseemptyCart'])->name('warehouse-empty-cart');
        Route::get('product-categories', [PosController::class, 'getProductCategories'])->name('product.categories');
        Route::get('empty-cart', [PosController::class, 'emptyCart'])->name('empty-cart');;
        Route::get('add-to-cart/{id}/{session}/{war_id}', [PosController::class, 'addToCart']);
        // Route::delete('remove-from-cart', [PosController::class, 'removeFromCart']);
        
        Route::delete('/remove-from-cart', [PosController::class, 'removeFromCart'])->name('remove-from-cart');
        Route::patch('update-cart', [PosController::class, 'updateCart'])->name('update.cart.quantity');;
        Route::post('/pos/scan-barcode', [PosController::class, 'scanBarcode'])->name('pos.scan.barcode');
        Route::get('pos/data/store', [PosController::class, 'store'])->name('pos.data.store');

        // thermal print

        Route::get('printview/pos', [PosController::class, 'printView'])->name('pos.printview');

        Route::post('/cartdiscount', [PosController::class, 'cartdiscount'])->name('cartdiscount');

        Route::get('pos/pdf/{id}', [PosController::class, 'pos'])->name('pos.pdf');
        Route::post('/pos/template/setting', [PosController::class, 'savePosTemplateSettings'])->name('pos.template.setting');
        Route::get('pos/preview/{template}/{color}', [PosController::class, 'previewPos'])->name('pos.preview');


        //Reports
        Route::get('reports-warehouse', [ReportController::class, 'warehouseReport'])->name('report.warehouse');
        Route::get('reports-daily-purchase', [ReportController::class, 'purchaseDailyReport'])->name('report.daily.purchase');
        Route::get('reports-monthly-purchase', [ReportController::class, 'purchaseMonthlyReport'])->name('report.monthly.purchase');
        Route::get('reports-daily-pos', [ReportController::class, 'posDailyReport'])->name('report.daily.pos');
        Route::get('reports-monthly-pos', [ReportController::class, 'posMonthlyReport'])->name('report.monthly.pos');
        Route::get('reports-pos-vs-purchase', [ReportController::class, 'posVsPurchaseReport'])->name('report.pos.vs.purchase');

    	//pos barcode
        Route::get('barcode/pos', [PosController::class, 'barcode'])->name('pos.barcode');
        Route::get('setting/pos', [PosController::class, 'barcodeSetting'])->name('pos.setting');
        Route::post('barcode/settings', [PosController::class, 'BarcodesettingStore'])->name('barcode.setting');
        Route::get('print/pos', [PosController::class, 'printBarcode'])->name('pos.print');
        Route::post('pos/getproduct', [PosController::class, 'getproduct'])->name('pos.getproduct');
        Route::any('pos-receipt', [PosController::class, 'receipt'])->name('pos.receipt');
    // });
    
    
    
        // POS Register
        Route::get('/pos-register', [PosController::class, 'register'])->name('register.index');
        Route::post('/register/open', [PosController::class, 'openRegister'])->name('register.open');
        Route::get('/pos-register/close', [PosController::class, 'showCloseForm'])->name('register.close.form');
        Route::post('/register/close', [PosController::class, 'closeregister'])->name('register.close');
        
        
        // Multi-cart
        Route::prefix('pos/carts')->group(function () {
            Route::get('/get', [PosController::class, 'getCarts'])->name('pos.carts');
            Route::post('/create', [PosController::class, 'createCart'])->name('pos.carts.create');
            Route::post('/{cartId}/switch', [PosController::class, 'switchCart'])->name('pos.carts.switch');
            Route::post('/switch/{cartId}', [PosController::class, 'switchCart'])->name('pos.carts.switch');
             Route::post('/switch', [PosController::class, 'switchCart'])->name('pos.carts.switch');
            Route::delete('/delete', [PosController::class, 'deleteCart'])->name('pos.carts.delete');
            Route::put('/{cartId}/rename', [PosController::class, 'renameCart'])->name('pos.carts.rename');
            Route::get('/cart-items', [PosController::class, 'getCartItems']);
            // Cart operations
            //  Route::get('/{cartId}/items', [PosController::class, 'getCartItems'])->name('pos.carts.items.get');
            Route::post('/{cartId}/items', [PosController::class, 'addToCart'])->name('pos.carts.items.add');
            Route::put('/{cartId}/items/{itemId}', [PosController::class, 'updateCartItem'])->name('pos.carts.items.update');
            Route::delete('/{cartId}/items/{itemId}', [PosController::class, 'removeFromCart'])->name('pos.carts.items.remove');
            Route::delete('/{cartId}/items', [PosController::class, 'emptyCart'])->name('pos.carts.items.empty');
            
            // Cart settings
            Route::put('/{cartId}/customer', [PosController::class, 'setCustomer'])->name('pos.carts.customer');
            Route::put('/{cartId}/warehouse', [PosController::class, 'setWarehouse'])->name('pos.carts.warehouse');
            Route::put('/{cartId}/discount', [PosController::class, 'applyDiscount'])->name('pos.carts.discount');
        });
});
