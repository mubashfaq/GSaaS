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
use Workdo\ProjectTemplate\Http\Controllers\ProjectTemplateController;

Route::middleware(['web', 'auth','verified', 'PlanModuleCheck:ProjectTemplate'])->group(function () {
    Route::resource('project-template', ProjectTemplateController::class);
    Route::get('project-template-list', [ProjectTemplateController::class, 'List'])->name('project-template.list');
});
