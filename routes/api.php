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
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use App\Http\Controllers\EmailVerificationNotificationController;
use  Laravel\Fortify\Http\Controllers\{AuthenticatedSessionController, RegisteredUserController, PasswordResetLinkController, TwoFactorAuthenticationController, TwoFactorQrCodeController};

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::apiResource('posts', PostController::class)->except(['update']);
    Route::put('posts/{post}', [PostController::class, 'replace']);
    Route::patch('posts/{post}', [PostController::class, 'update']);
    Route::resource('posts.comments', CommentController::class)->shallow();


    // Route::apiResource('profiles', ProfileController::class);
    Route::get('profile', [ProfileController::class, 'me']);
    Route::post('profile', [ProfileController::class, 'updateMe']);

    Route::put('/update-password', [PasswordController::class, 'update']);
    Route::put('/update-email', [ProfileController::class, 'updateEmail']);

    Route::post('posts/{post}/medias', [MediaController::class, 'store']);
    Route::delete('posts/{post}/medias/{media_id}', [MediaController::class, 'destroy']);
});

require_once(__DIR__ . '/auth.php');

// Get posts' media files
Route::get('/medias/{id}/{filename}', [MediaController::class, 'show'])->middleware([
    'auth:sanctum',
    'verified'
]);
// Get profile images
Route::get('/profile-image/{id}/{filename}', [MediaController::class, 'profile'])->middleware([
    'auth:sanctum',
    'verified'
]);
