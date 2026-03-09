<?php

use App\Http\Controllers\App\Users\ProfileController;
use App\Http\Controllers\App\Movies\MovieController;
use App\Http\Controllers\App\LanguageController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


use App\Http\Controllers\App\Users\RoleController;
use App\Http\Controllers\App\Users\UserRoleController;

Route::get('/', function () {return redirect()->route('login');});
Route::get('lang/{locale}', [LanguageController::class, 'switchLang'])->name('lang.switch');
 

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {return Inertia::render('Dashboard');})->middleware('verified')->name('dashboard');

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('roles', RoleController::class);
        Route::get('/users', [UserRoleController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserRoleController::class, 'create'])->name('users.create');
        Route::post('/users', [UserRoleController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserRoleController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserRoleController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserRoleController::class, 'destroy'])->name('users.destroy');
    });

    Route::get('/movie/index', [MovieController::class, 'index'])->name('movie.index');
    Route::get('/movie/create', [MovieController::class, 'create'])->name('movie.create');
    Route::post('/movie/store', [MovieController::class, 'store'])->name('movie.store');
    Route::get('/movie/edit/{id}', [MovieController::class, 'edit'])->name('movie.edit');
    Route::put('/movie/update/{id}', [MovieController::class, 'update'])->name('movie.update');
    Route::delete('/movie/destroy/{id}', [MovieController::class, 'destroy'])->name('movie.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
