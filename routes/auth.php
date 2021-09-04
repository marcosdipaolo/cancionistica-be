<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post("/register", [AuthController::class, 'register']);
Route::post("/login", [AuthController::class, 'login']);
Route::get("/logout", [AuthController::class, 'logout']);
Route::get("/logged-user", [AuthController::class, 'loggedUser']);
Route::get("/email-exists/{email}", [AuthController::class, 'emailExists']);
