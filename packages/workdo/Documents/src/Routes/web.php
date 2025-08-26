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
use Workdo\Documents\Http\Controllers\DocumentsController;
use Workdo\Documents\Http\Controllers\DocumentsTypeController;

Route::group(['middleware' => ['web', 'auth','verified', 'PlanModuleCheck:Documents']], function () {


    // Type

    Route::prefix('documents')->group(function () {
        Route::resource('/document', DocumentsController::class)->names('documents')->except(['create', 'edit']);

        Route::resource('documents-type', DocumentsTypeController::class)->names('documents-type');

        Route::get('create/{pro_id?}', [DocumentsController::class, 'create'])->name('documents.create');
        Route::get('{id}/edit/{pro_id?}', [DocumentsController::class, 'edit'])->name('documents.edit');

        Route::post('status/{id}', [DocumentsController::class, 'DocStatus'])->name('documents.status');
        Route::post('{id}/description', [DocumentsController::class, 'descriptionStore'])->name('documents.description.store');

        Route::get('copy/{id}', [DocumentsController::class, 'copyDoc'])->name('documents.copy');         // Copy
        Route::post('copy/{id}/store/', [DocumentsController::class, 'copyDocStore'])->name('documents.copy.store');

        Route::post('/{id}/file', [DocumentsController::class, 'fileUpload'])->name('documents.file.upload');
        Route::get('/{id}/file/{fid}', [DocumentsController::class, 'fileDownload'])->name('documents.file.download');
        Route::delete('/{id}/file/delete/{fid}', [DocumentsController::class, 'fileDelete'])->name('documents.file.delete');

        Route::post('/{id}/comment', [DocumentsController::class, 'commentStore'])->name('document.comment.store');
        Route::get('/{id}/comment', [DocumentsController::class, 'commentDestroy'])->name('document.comment.destroy');

        Route::post('/{id}/note', [DocumentsController::class, 'noteStore'])->name('documents.note.store');
        Route::get('/{id}/note', [DocumentsController::class, 'noteDestroy'])->name('documents.note.destroy');

        Route::get('{id}/get-document', [DocumentsController::class, 'printDoc'])->name('get.document');
        Route::get('pdf/{id}', [DocumentsController::class, 'pdfFromDoc'])->name('document.download.pdf');

        Route::post('setting/store', [DocumentsController::class, 'setting'])->name('document.setting.store');
    });
});
