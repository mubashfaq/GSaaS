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
use Workdo\QuickBooks\Http\Controllers\QuickBooksController;

Route::group(['middleware' => ['web', 'auth', 'verified','PlanModuleCheck:QuickBooks']], function () {
    Route::post('/quickbooks/setting/store', [QuickBooksController::class, 'saveQuickbookSettings'])->name('save.quickbooks.setting');
    Route::get('/quickbook/gettoken', [QuickBooksController::class, 'gettoken'])->name('quickbook.gettoken');
    Route::get('/quickbook/callback', [QuickBooksController::class, 'callback'])->name('quickbook.callback');

    Route::get('/quickbook/chart-of-account/sync', [QuickBooksController::class, 'ChartofAccountSync'])->name('quickbook.chartofaccount.sync');
});
