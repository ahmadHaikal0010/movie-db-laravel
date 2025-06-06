<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/', [MovieController::class, 'homePage']);
Route::resource('movie', MovieController::class);
Route::get('/movie/{id}/{slug}', [MovieController::class, 'detail']);
Route::get('movie_add', [MovieController::class, 'add'])->name('movie_add')->middleware('auth');
