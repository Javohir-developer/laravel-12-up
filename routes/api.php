<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Movies\MovieController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/test', [MovieController::class, 'search'])->name('movies.search');
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
<<<<<<< HEAD
Route::post('/create-movies', [MovieController::class, 'createMovies'])->name('movies.create');
Route::post('/edit-movies', [MovieController::class, 'editMovies'])->name('movies.edit');
Route::get('/get-status', [MovieController::class, 'getStatus'])->name('movies.status');
Route::get('/get-movie-for-edit/{id}', [MovieController::class, 'getMovieForEdit'])->name('movies.getMovieForEdit');
=======
Route::post('/create-movies', [MovieController::class, 'createMovies'])->name('create.movies');
Route::get('/get-status', [MovieController::class, 'getStatus'])->name('get.status');
>>>>>>> f946413cffde185a4b24753e1313de5c7e61d215
