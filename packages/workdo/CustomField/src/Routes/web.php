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
use Workdo\CustomField\Http\Controllers\CustomFieldController;

Route::group(['middleware' => ['web', 'auth', 'verified','PlanModuleCheck:CustomField']], function () {

    Route::resource('custom-field', CustomFieldController::class);
    Route::get('custom-field/get_module/{module_name}', [CustomFieldController::class, 'get_module_list']);
});
