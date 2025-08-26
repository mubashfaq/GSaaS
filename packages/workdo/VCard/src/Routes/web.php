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
use Workdo\VCard\Http\Controllers\CardPaymentController;
use Workdo\VCard\Http\Controllers\ContactsController;
use Workdo\VCard\Http\Controllers\AppointmentDetailController;
use Workdo\VCard\Http\Controllers\BusinessController;
use Workdo\VCard\Http\Controllers\VCardController;


Route::group(['middleware' => ['web', 'auth', 'verified', 'PlanModuleCheck:VCard']], function () {
    //dashboard
    Route::get('dashboard/vcard', [VCardController::class, 'index'])->name('dashboard.vcard');

    //Business
    Route::resource('business', BusinessController::class);
    Route::get('business/grid/view', [BusinessController::class, 'gridView'])->name('business.grid.view');
    Route::post('business/duplicate/{id}', [BusinessController::class, 'duplicateBusiness'])->name('business.duplicate');
    Route::post('business/status/{id}', [BusinessController::class, 'changeStatus'])->name('business.status');
    Route::get('business/whatsapp/{id}', [BusinessController::class, 'whatsappShare'])->name('business.whatsapp');
    Route::get('business/getcard/{slug}', [BusinessController::class, 'cardPdf'])->name('get.card');
    Route::post('business/edit-theme/{id}', [BusinessController::class, 'editTheme'])->name('business.edit-theme');
    Route::post('business/domain-setting/{id}', [BusinessController::class, 'domainSetting'])->name('business.domain-setting');
    Route::post('business/block-setting/{id}', [BusinessController::class, 'blockSetting'])->name('business.block-setting');
    Route::post('business/cookie/{id}', [BusinessController::class, 'saveCookieSetting'])->name('business.cookie-setting');
    Route::post('business/custom-qrcode/{id}', [BusinessController::class, 'saveCustomQrSetting'])->name('business.qrcode-setting');
    Route::post('business/seo/{id}', [BusinessController::class, 'saveSeo'])->name('business.seo-setting');
    Route::post('business/pwa/{id}', [BusinessController::class, 'savePWA'])->name('business.pwa-setting');
    Route::post('business/card-payment/{id}', [BusinessController::class, 'saveCardPaymentSetting'])->name('business.payment_setting');
    Route::get('business/qr/download/', [BusinessController::class, 'downloadQrCode'])->name('download.vcard.qr');
    Route::post('business/destroy/', [BusinessController::class, 'destroyGallery'])->name('destory.gallery');
    Route::get('business/current/{id}', [BusinessController::class, 'ChangeBusiness'])->name('business.current');


    //Pixel
    Route::get('pixel-create/{id}', [BusinessController::class, 'pixelCreate'])->name('pixel.vcard.create');
    Route::post('pixel', [BusinessController::class, 'pixelStore'])->name('pixel.store');
    Route::delete('pixel-delete/{id}', [BusinessController::class, 'pixelDestroy'])->name('pixel.vcard.destroy');

    //Appointment
    Route::resource('appointment', AppointmentDetailController::class);
    Route::get('appointment-calender', [AppointmentDetailController::class, 'appointmentCalender'])->name('appointment.calendar');
    Route::get('appointment-note/{id?}', [AppointmentDetailController::class, 'addNote'])->name('appointment.add-note');
    Route::post('appointment-note-store/{id?}', [AppointmentDetailController::class, 'noteStore'])->name('appointment.note.store');
    Route::get('get-appointment-detail/{id}', [AppointmentDetailController::class, 'getAppointmentDetails'])->name('appointment.details');

    //Contact
    Route::get('contacts/show', [ContactsController::class, 'index'])->name('contacts.index');
    Route::get('contacts/show/{business_id?}', [ContactsController::class, 'index'])->name('business.contacts.show');
    Route::get('contact-note/{id}', [ContactsController::class, 'addNote'])->name('contact.add-note');
    Route::post('contact-note-store/{id}', [ContactsController::class, 'noteStore'])->name('contact.note.store');
    Route::post('contacts/delete/{id}', [ContactsController::class, 'destroy'])->name('contacts.destroy');

    Route::get('contact/{id}/message', [ContactsController::class, 'viewmessage'])->name('contacts.message');
});
Route::group(['middleware' => 'web'], function () {
    Route::get('cards/{slug}', [BusinessController::class, 'getCard'])->name('get.vcard');
    Route::get('download/{slug}', [BusinessController::class, 'getVcardDownload'])->name('bussiness.save');
    Route::any('appoinment/make-appointment', [AppointmentDetailController::class, 'store'])->name('appoinment.store');
    Route::post('contacts/store/', [ContactsController::class, 'store'])->name('contacts.store');
    Route::get('card-cookie-consent', [BusinessController::class, 'cardCookieConsent'])->name('card-cookie-consent');
    Route::any('card-pay-with-stripe/{id}', [CardPaymentController::class, 'cardPayWithStripe'])->name('card.pay.with.stripe');
    Route::any('stripe-get-card-payment/', [CardPaymentController::class, 'cardGetStripePaymentStatus'])->name('card.stripe');
    Route::any('card-pay-with-paypal/{id}', [CardPaymentController::class, 'cardPayWithPaypal'])->name('card.pay.with.paypal');
    Route::get('get-payment-status/{id}', [CardPaymentController::class, 'cardGetPaymentStatus'])->name('card.get.payment.status');
});
