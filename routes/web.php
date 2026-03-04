<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Movies\MovieController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/movie/index', [MovieController::class, 'index'])->name('movie.index');
    Route::get('/movie/create', [MovieController::class, 'create'])->name('movie.create');
    Route::post('/movie/store', [MovieController::class, 'store'])->name('movie.store');
    Route::get('/movie/edit/{id}', [MovieController::class, 'edit'])->name('movie.edit');
    Route::put('/movie/update/{id}', [MovieController::class, 'update'])->name('movie.update');
    Route::delete('/movie/destroy/{id}', [MovieController::class, 'destroy'])->name('movie.destroy');
    Route::get('/movie/test', [MovieController::class, 'test'])->name('movie.test');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
