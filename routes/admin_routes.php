<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MetricController;

Route::middleware(['auth:sanctum', 'verified', 'role:ADMIN'])->group(function () {
    Route::get('metrics', [MetricController::class, 'index']);
});
