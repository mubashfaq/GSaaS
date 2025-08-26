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
use Workdo\AIDocument\Http\Controllers\AiTemplateController;

Route::group(['middleware' => ['web', 'auth', 'verified','PlanModuleCheck:AIDocument']], function () {
    Route::prefix('aidocument')->group(function () {
        Route::any('/', [AiTemplateController::class, 'index'])->name('aidocument.index');
        Route::post('/setting/store', [AiTemplateController::class, 'setting'])->name('aidocument.setting.store');
        Route::any('/store', [AiTemplateController::class, 'store'])->name('aidocument.document.store');
        Route::any('/show/{doc_id}/{id}/', [AiTemplateController::class, 'show'])->name('aidocument.document.show');
        Route::any('/process', [AiTemplateController::class, 'AiGenerate'])->name('aidocument.document.process');
        Route::any('/regenerate/response', [AiTemplateController::class, 'regenerate_response'])->name('aidocument.document.regenerate.response');
        Route::any('exportallresponsecontent', [AiTemplateController::class, 'exportallresponsecontent'])->name('aidocument.document.export.allresponse');
        Route::any('exportresponsecontent', [AiTemplateController::class, 'exportresponsecontent'])->name('aidocument.document.export.response');
        Route::any('/edit/document/{doc_id}/{id}/', [AiTemplateController::class, 'edit'])->name('aidocument.document.edit');
        Route::any('/save', [AiTemplateController::class, 'save'])->name('aidocument.document.save');
        Route::any('delete/history/document/{id}', [AiTemplateController::class, 'destroy'])->name('aidocument.document.destroy');
        Route::any('history/', [AiTemplateController::class, 'history'])->name('aidocument.document.history');
    });
});
