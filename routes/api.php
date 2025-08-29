<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Movies\MovieController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/test', [MovieController::class, 'search'])->name('movies.search');
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::post('/create-movies', [MovieController::class, 'createMovies'])->name('create.movies');
Route::get('/get-status', [MovieController::class, 'getStatus'])->name('get.status');
