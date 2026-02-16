<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\DoaController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RepositoryController;
use App\Http\Controllers\HadistController;
use App\Http\Controllers\FavoritController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Favorit routes
    Route::get('/favorit', [FavoritController::class, 'index'])->name('favorit.index');
    Route::get('/favorit/create', [FavoritController::class, 'create'])->name('favorit.create');
    Route::post('/favorit/add', [FavoritController::class, 'add'])->name('favorit.add');
    Route::delete('/favorit/remove', [FavoritController::class, 'remove'])->name('favorit.remove');
    Route::get('/favorit/user/{user}', [FavoritController::class, 'user'])->name('favorit.user');
});

Route::resource('users', UserController::class);
Route::resource('categories', CategoryController::class);
Route::resource('tags', TagController::class);
Route::resource('repositories', RepositoryController::class);
Route::resource('doas', DoaController::class);
Route::resource('hadists', HadistController::class);

require __DIR__.'/auth.php';
