<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::post("/register", [Controllers\AuthController::class, 'register']);
Route::post("/login", [Controllers\AuthController::class, 'login']);
Route::get("/logout", [Controllers\AuthController::class, 'logout']);
Route::get("/logged-user", [Controllers\AuthController::class, 'loggedUser']);
Route::get("/email-exists/{email}", [Controllers\AuthController::class, 'emailExists']);

Route::post("forgot-password", [Controllers\ResetPasswordController::class, "forgotPassword"]);
Route::post("reset-password", [Controllers\ResetPasswordController::class, "reset"]);
Route::post("change-password", [Controllers\ResetPasswordController::class, "change"]);
Route::post("password-matches", [Controllers\ResetPasswordController::class, "passwordMatches"]);
