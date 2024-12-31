<?php

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BestCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavouriteController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use App\Http\Controllers\EmailVerificationNotificationController;
use  Laravel\Fortify\Http\Controllers\{AuthenticatedSessionController, RegisteredUserController, PasswordResetLinkController, TwoFactorAuthenticationController, TwoFactorQrCodeController};

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('posts/trending', [PostController::class, 'trending']);
    Route::apiResource('posts', PostController::class)->except(['update']);
    Route::put('posts/{post}', [PostController::class, 'replace']);
    Route::patch('posts/{post}', [PostController::class, 'update']);
    Route::resource('posts.comments', CommentController::class)->shallow();

    Route::post('/comments/{comment}/best', [BestCommentController::class, 'mark']);
    Route::delete('/comments/{comment}/best', [BestCommentController::class, 'unmark']);

    Route::post('/favourites/{post}', [FavouriteController::class, 'addToFavourites']);
    Route::delete('/favourites/{post}', [FavouriteController::class, 'removeFromFavourites']);
    Route::get('/favourites', [FavouriteController::class, 'getFavourites']);

    Route::apiResource('categories', CategoryController::class);
    // Route::apiResource('profiles', ProfileController::class);
    Route::apiResource('users', UserController::class);

    Route::get('profile', [ProfileController::class, 'me']);
    Route::get('stats', [ProfileController::class, 'stats']);
    Route::post('profile', [ProfileController::class, 'updateMe']);

    Route::put('/update-password', [PasswordController::class, 'update']);
    Route::put('/update-email', [ProfileController::class, 'updateEmail']);

    Route::post('posts/{post}/medias', [MediaController::class, 'store']);
    Route::delete('posts/{post}/medias/{media_id}', [MediaController::class, 'destroy']);
});

require_once(__DIR__ . '/auth.php');
require_once(__DIR__ . '/media_routes.php');
