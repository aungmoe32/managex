<?php

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use App\Http\Controllers\EmailVerificationNotificationController;
use  Laravel\Fortify\Http\Controllers\{AuthenticatedSessionController, ConfirmedTwoFactorAuthenticationController, RegisteredUserController, PasswordResetLinkController, TwoFactorAuthenticationController, TwoFactorQrCodeController};

// Retrieve the limiter configuration for login attempts
$limiter = config('fortify.limiters.login');

// Route for user login
Route::post('/auth/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(array_filter([
        'web',
        'guest:' . config('fortify.guard'),  // Only guests (non-authenticated users) are allowed
        $limiter ? 'throttle:' . $limiter : null,  // Throttle login attempts if limiter is configured
    ]));


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('roles', [RoleController::class, 'index']);


    // Authentication routes
    Route::prefix('auth')->group(function () {

        // Retrieve the verification limiter configuration for verification attempts
        $verificationLimiter = config('fortify.limiters.verification', '6,1');

        Route::withoutMiddleware('auth:sanctum')->group(function () {


            // Route for user registration
            Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware('guest:' . config('fortify.guard'));  // Only guests (non-authenticated users) are allowed

            // Route for initiating password reset
            Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest:' . config('fortify.guard'))  // Only guests (non-authenticated users) are allowed
                ->name('password.email');  // Name for the route
        });
        Route::post('/logout', [LogoutController::class, 'destroy']);


        // Route to resend email verification notification
        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware([
                'throttle:' . $verificationLimiter // Throttle resend email attempts
            ]);
    });
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])->name('two-factor.enable');
    Route::delete('user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])->name('two-factor.disable');
    Route::get('user/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])->name('two-factor.qr-code');
    Route::post('user/confirmed-two-factor-authentication', [ConfirmedTwoFactorAuthenticationController::class, 'store'])->name('two-factor.confirm');
});
