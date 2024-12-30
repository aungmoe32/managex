<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;


// // Get posts' media files
// Route::get('/medias/{id}/{filename}', [MediaController::class, 'show'])->middleware([
//     // 'auth:sanctum',
//     // 'verified'
//     'signed'
// ])->name('medias');

// Get profile images
Route::get('/profile-image/{id}/{filename}', [MediaController::class, 'profile'])->middleware([
    // 'auth:sanctum',
    // 'verified'
    'signed'
])->name('profile.image');

// Download medias from s3
Route::get('/download/{id}/{filename}', [MediaController::class, 'download'])->middleware([
    'auth:sanctum',
    'verified',
    'throttle:media-download'
])->name('media.download');
