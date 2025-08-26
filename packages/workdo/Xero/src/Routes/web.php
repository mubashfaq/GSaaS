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
use Workdo\Xero\Http\Controllers\XeroController;

Route::group(['middleware' => ['web', 'auth', 'verified','PlanModuleCheck:Xero']], function () {
    Route::post('/xero/setting/store', [XeroController::class,'saveXeroSettings'])->name('save.xero.setting');
    Route::any('/xero/gettoken', [XeroController::class,'xeroGettoken'])->name('xero.gettoken');
    Route::any('/xero/callback', [XeroController::class,'xeroCallback'])->name('xero.callback');
    Route::get('/xero/chart-of-account/sync',[XeroController::class,'ChartofAccountSync'])->name('xero.chartofaccount.sync');
});
