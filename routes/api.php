<?php

use App\Http\Controllers\VerificationController;
use Illuminate\Http\Request;
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

Route::group(["middleware" => ["auth:sanctum"]], function(){
    Route::get("/products", function(){
        return response()->json(["product1" => "$1", "product2" => "$2"]);
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');

Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
