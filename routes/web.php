<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;


Route::get('/', [FrontendController::class, 'home'])->name('/');
Route::get('/home', [FrontendController::class, 'home'])->name('/home');
Route::get('/book-publishing', [FrontendController::class, 'bookpublishing'])->name('/book-publishing');
Route::get('/editing-formatting', [FrontendController::class, 'editingformatting'])->name('/editing-formatting');
Route::get('/illustration-design', [FrontendController::class, 'illustrationdesign'])->name('/illustration-design');
Route::get('/cover-design', [FrontendController::class, 'coverdesign'])->name('/cover-design');
Route::get('/author-website', [FrontendController::class, 'authorwebsite'])->name('/author-website');
Route::get('/audiobook-production', [FrontendController::class, 'audiobookproduction'])->name('/audiobook-production');
Route::get('/about', [FrontendController::class, 'about'])->name('/about');
Route::get('/contact', [FrontendController::class, 'contact'])->name('/contact');
Route::get('thankyou', [FrontendController::class, 'thankyou'])->name('thankyou');
Route::get('/privacy-policy', [FrontendController::class, 'privacy'])->name('privacyPolicy');
Route::get('/terms-and-conditions', [FrontendController::class, 'termsAndConditions'])->name('termsAndConditions');

// Lp Routes
Route::get('/lp/publishing', [FrontendController::class, 'publishing'])->name('/publishing');
Route::get('/lp/privacy-policy', [FrontendController::class, 'lpPrivacy'])->name('lpPrivacyPolicy');
Route::get('/lp/terms-and-conditions', [FrontendController::class, 'lpTermsAndConditions'])->name('lpTermsAndConditions');
Route::get('/sequence/step1', [FrontendController::class, 'seq_step1'])->name('seq.step1');


 // ############## Invoice Routes ###################
Route::get('/invoice/payment', [FrontendController::class, 'reactInvoicePayment'])->name('react.invoice.payment');
