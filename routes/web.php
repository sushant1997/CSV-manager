<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\UserRegistrationController;
use Illuminate\Support\Facades\Route;


Route::get('login', [AuthController::class, 'show_login_form'])->name('login');
Route::post('user/authenticate', [AuthController::class, 'login'])->name('user.authenticate')->middleware('validate_user');
Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get("auth/google/call-back", [GoogleAuthController::class, 'callbackGoogle']);

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('upload', [FileController::class, 'upload_file'])->name('upload');
    Route::get('download/{file_id}', [FileController::class, 'file_download'])->name('download');
    Route::delete('delete/{file_id}', [FileController::class, 'delete_file'])->name('delete');
});
