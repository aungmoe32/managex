<?php

use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return User::whereHas("posts", function (Builder $query) {
        $query->whereHas("comments", function (Builder $query) {
            $query->where('title', 'like', '%rem%');
        });
    })->paginate(1);
    //  return view('welcome');
});
