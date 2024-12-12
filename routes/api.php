<?php

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\EmailVerificationNotificationController;
use App\Http\Controllers\MediaController;
use  Laravel\Fortify\Http\Controllers\{AuthenticatedSessionController, RegisteredUserController, PasswordResetLinkController};

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
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
});



Route::group(['middleware' => 'auth:sanctum'], function () {
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

        // Route to resend email verification notification
        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware([
                'throttle:' . $verificationLimiter // Throttle resend email attempts
            ]);
    });


    Route::prefix('user')->middleware(['verified'])->group(function () {
        Route::get('/', function (Request $request) {
            $user = Auth::user();
            $user->all_permissions = $user->getAllPermissions();
            return $user;
        });
    });
});

Route::get('/storage/{id}/{filename}', [MediaController::class, 'show'])->middleware([
    'auth:sanctum',
    'verified'
]);
