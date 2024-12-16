<?php

use App\Http\Middleware\AutoLogin;
use App\Http\Middleware\AutoLoginVerifyMiddleware;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Request;

use Laravel\Fortify\Contracts\{LoginResponse, RegisterResponse, PasswordResetResponse};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!

|
*/

// https://github.com/laravel/ideas/issues/1632
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json([
        'message' => "Email verification success",
    ], 200);
})->middleware([AutoLogin::class,  'signed'])->name('verification.verify');

// Password Reset View
Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::get('/', function () {
    return view('welcome');
});
