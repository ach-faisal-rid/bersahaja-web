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
use App\Http\Controllers\HijriEventController;
use App\Http\Controllers\GuestPageController;
use App\Http\Controllers\PinnedDayController;
use App\Http\Controllers\TataCaraController;
use App\Http\Controllers\GerakanShalatController;
use App\Http\Controllers\BacaanController;
use App\Http\Controllers\WuduController;
use App\Http\Controllers\LegalContentController;

Route::get('/welcome', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/', [GuestPageController::class, 'index'])->name('guest.index');
Route::get('/guest/hijri/events', [HijriEventController::class, 'events'])->name('guest.hijri.events');
Route::get('/terms-and-conditions', [LegalContentController::class, 'terms'])->name('legal.terms');
Route::get('/privacy-policy', [LegalContentController::class, 'privacy'])->name('legal.privacy');

// Public read-only routes for shalat modules
Route::resource('tata-cara', TataCaraController::class)->only(['index', 'show']);
Route::resource('gerakan-shalat', GerakanShalatController::class)->only(['index', 'show']);
Route::resource('bacaan', BacaanController::class)->only(['index', 'show']);
Route::resource('wudu', WuduController::class)->only(['index', 'show']);
Route::resource('doas', DoaController::class)->only(['index', 'show']);
Route::resource('hadists', HadistController::class)->only(['index']);
Route::get('/hijri', [HijriEventController::class, 'index'])->name('hijri.index');
Route::get('/hijri/events', [HijriEventController::class, 'events'])->name('hijri.events');

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

    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('tags', TagController::class)->except(['show']);
    Route::resource('repositories', RepositoryController::class)->except(['show']);
    
    // Hijri calendar routes
    Route::post('/hijri/events/fetch-external', [HijriEventController::class, 'fetchExternal'])->name('hijri.events.fetch-external');
    Route::get('/hijri/pinned-days', [PinnedDayController::class, 'index'])->name('hijri.pinned-days.index');
    Route::post('/hijri/pinned-days', [PinnedDayController::class, 'store'])->name('hijri.pinned-days.store');
    Route::delete('/hijri/pinned-days/{pinnedDay}', [PinnedDayController::class, 'destroy'])->name('hijri.pinned-days.destroy');

    Route::get('/doas/{doa}/tags', [DoaController::class, 'editTags'])->name('doas.tags.edit');
    Route::put('/doas/{doa}/tags', [DoaController::class, 'updateTags'])->name('doas.tags.update');
    Route::resource('doas', DoaController::class)->except(['index', 'show']);
    Route::resource('hadists', HadistController::class)->except(['index', 'show']);
    Route::resource('tata-cara', TataCaraController::class)->except(['index', 'show']);
    Route::resource('gerakan-shalat', GerakanShalatController::class)->except(['index', 'show']);
    Route::resource('bacaan', BacaanController::class)->except(['index', 'show']);
    Route::resource('wudu', WuduController::class)->except(['index', 'show']);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::get('/admin/legal-content', [LegalContentController::class, 'edit'])->name('admin.legal.edit');
    Route::put('/admin/legal-content', [LegalContentController::class, 'update'])->name('admin.legal.update');
});

require __DIR__.'/auth.php';
