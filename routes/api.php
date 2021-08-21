<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Notifications

Route::get('email/verify/{id}', [Controllers\VerificationController::class, 'verify'])->name('verification.verify');
Route::get('email/resend', [Controllers\VerificationController::class, 'resend'])->name('verification.resend');
Route::post('contact-form', [Controllers\NotificationController::class, 'contactForm']);

Route::post('payments/{method}', [Controllers\PaymentController::class, 'makePayment']);


// resources
Route::resource("posts", PostController::class);
Route::resource("categories", PostCategoryController::class);
