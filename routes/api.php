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
use  Laravel\Fortify\Http\Controllers\{AuthenticatedSessionController, RegisteredUserController, PasswordResetLinkController, TwoFactorAuthenticationController, TwoFactorQrCodeController};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware([
//     'auth:sanctum',
//     'password.confirm'
// ])->get('/test', function (Request $request) {
//     return $request->user();
// });

// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/register', [AuthController::class, 'register']);
// Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::apiResource('users', UserController::class);
//     Route::apiResource('subjects', SubjectController::class);
//     Route::apiResource('teachers', TeacherController::class);
//     Route::post('profile', [ProfileController::class, 'update']);
//     Route::get('profile', [ProfileController::class, 'show']);
// });


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::apiResource('posts', PostController::class)->except(['update']);
    Route::put('posts/{post}', [PostController::class, 'replace']);
    Route::patch('posts/{post}', [PostController::class, 'update']);
    // Route::apiResource('profiles', ProfileController::class);
    Route::get('profile', [ProfileController::class, 'me']);
    Route::post('profile', [ProfileController::class, 'updateMe']);

    Route::put('/update-password', [PasswordController::class, 'update']);
    Route::put('/update-email', [ProfileController::class, 'updateEmail']);

    Route::post('posts/{post}/medias', [MediaController::class, 'store']);
    Route::delete('posts/{post}/medias/{media_id}', [MediaController::class, 'destroy']);
});



Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('roles', [RoleController::class, 'index']);
    // Authentication routes
    Route::prefix('auth')->group(function () {

        // Retrieve the verification limiter configuration for verification attempts
        $verificationLimiter = config('fortify.limiters.verification', '6,1');

        Route::withoutMiddleware('auth:sanctum')->group(function () {
            // Retrieve the limiter configuration for login attempts
            $limiter = config('fortify.limiters.login');

            // Route for user login
            Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware(array_filter([
                    'web',
                    'guest:' . config('fortify.guard'),  // Only guests (non-authenticated users) are allowed
                    $limiter ? 'throttle:' . $limiter : null,  // Throttle login attempts if limiter is configured
                ]));

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

// Get media files
Route::get('/medias/{id}/{filename}', [MediaController::class, 'show'])->middleware([
    'auth:sanctum',
    'verified'
]);
Route::post('user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])->middleware([
    'auth:sanctum',
])->name('two-factor.enable');
Route::delete('user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])->middleware([
    'auth:sanctum',
])->name('two-factor.disable');

Route::get('user/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])->middleware([
    'auth:sanctum',
])->name('two-factor.qr-code');
