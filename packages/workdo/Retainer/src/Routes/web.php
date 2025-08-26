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
use Workdo\Retainer\Http\Controllers\RetainerController;

Route::group(['middleware' => ['web', 'auth', 'verified','PlanModuleCheck:Retainer']], function () {

    Route::get('retainer/items/', [RetainerController::class, 'items'])->name('retainer.items');

    Route::resource('retainer', RetainerController::class)->except(['create']);

    Route::post('retainer/product', [RetainerController::class, 'product'])->name('retainer.product');

    Route::get('retainer/{id}/sent', [RetainerController::class, 'sent'])->name('retainer.sent');
    Route::get('retainer/{id}/status/change', [RetainerController::class, 'statusChange'])->name('retainer.status.change');

    Route::get('retainer/{id}/resent', [RetainerController::class, 'resent'])->name('retainer.resent');
    Route::get('retainer/{id}/duplicate', [RetainerController::class, 'duplicate'])->name('retainer.duplicate');
    Route::get('retainer/{id}/payment', [RetainerController::class, 'payment'])->name('retainer.payment');
    Route::post('retainer/{id}/payment', [RetainerController::class, 'createPayment'])->name('retainer.store.payment');
    Route::get('retainer/{id}/payment/reminder', [RetainerController::class, 'paymentReminder'])->name('retainer.payment.reminder');
    Route::post('retainer/{id}/payment/{pid}/destroy', [RetainerController::class, 'paymentDestroy'])->name('retainer.payment.destroy');
    Route::post('retainer/product/destroy', [RetainerController::class, 'productDestroy'])->name('retainer.product.destroy');

    Route::get('retainer/create/{cid}', [RetainerController::class, 'create'])->name('retainer.create');

    Route::get('/retainer/pay/{retainer}', [RetainerController::class, 'payretainer'])->name('pay.retainerpay');
    Route::post('/retainer/template/setting', [RetainerController::class, 'saveRetainerTemplateSettings'])->name('retainer.template.setting');
    Route::get('/retainer/preview/{template}/{color}', [RetainerController::class, 'previewRetainer'])->name('retainer.preview');

    Route::get('export/retainer', [RetainerController::class, 'export'])->name('retainer.export');

    Route::post('retainer/customer', [RetainerController::class, 'customer'])->name('retainer.customer');

    Route::post('retainer/section/type', [RetainerController::class, 'RetainerSectionGet'])->name('retainer.section.type');

    Route::post('tax/detail/get', [RetainerController::class, 'TaxDetailGet'])->name('tax.detail.get');

    Route::post('retainer/retainer_get_tax', [RetainerController::class, 'getTax'])->name('retainer_get_tax');

    Route::post('retainer-attechment/{id}', [RetainerController::class, 'retainerAttechment'])->name('retainer.attechment');

    Route::delete('retainer-attechment/destroy/{id}', [RetainerController::class, 'retainerAttechmentDestroy'])->name('retainer.attachment.destroy');

    // retainer template settig in retainer

    Route::get('/retainer/preview/{template}/{color}', [RetainerController::class, 'previewRetainer'])->name('retainer.preview');

    Route::get('retainer-grid', [RetainerController::class, 'grid'])->name('retainer.grid');

    Route::get('/retainer/pay/{retainer}', [RetainerController::class, 'payretainer'])->name('pay.retainerpay');

    Route::get('retainer/{id}/convert_invoice', [RetainerController::class, 'convert'])->name('retainer.convert_invoice');

    Route::get('retainer/{id}/convert', [RetainerController::class, 'proposal_convert'])->name('retainer.convert');
});

Route::group(['middleware' => ['web']], function () {

    Route::get('retainer/pdf/{id}', [RetainerController::class, 'retainer'])->name('retainer.pdf')->middleware('web');
    Route::get('/retainer/pay/{retainer}', [RetainerController::class, 'payretainer'])->name('pay.retainer')->middleware('web');
});
