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
use Workdo\FindGoogleLeads\Http\Controllers\FindGoogleLeadsController;

Route::group(['middleware' => ['web', 'auth', 'verified', 'PlanModuleCheck:FindGoogleLeads']], function () {
    Route::prefix('findgoogleleads')->group(function () {
            Route::post('/setting/store', [FindGoogleLeadsController::class, 'setting'])->name('findgooglelead.setting.save');
            Route::delete('/find-google-leads/contact/delete/{id}', [FindGoogleLeadsController::class, 'contact_destroy'])->name('findgooglelead.contact.destroy');
            Route::resource('find-google-leads', FindGoogleLeadsController::class);
            Route::any('/setting/get/stage', [FindGoogleLeadsController::class, 'get_stage'])->name('findgooglelead.setting.get.stage');
    });
});
