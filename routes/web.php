<?php

use App\Http\Middleware\AutoLogin;
use App\Http\Middleware\AutoLoginVerifyMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Request;

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



Route::get('/', function () {
    return view('welcome');
});
