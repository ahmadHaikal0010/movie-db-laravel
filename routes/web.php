<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [MovieController::class, 'homePage']);
Route::resource('movie', MovieController::class);
Route::get('/movie_add', [MovieController::class, 'add']);
Route::get('/movie/{id}/{slug}', [MovieController::class, 'detail']);
