<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [MovieController::class, 'homePage']);
Route::resource('movie', MovieController::class);
Route::get('/movie/{id}/{slug}', [MovieController::class, 'detail']);
Route::get('movie_add', [MovieController::class, 'add'])->name('movie_add');
