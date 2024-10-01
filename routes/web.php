<?php

use App\Http\Controllers\AboutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Controller;

// user
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\PlaylistController;
use App\Http\Controllers\HomeController;


// admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArtistController;
use App\Http\Controllers\Admin\SongController;
use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Middleware\UserMiddleware;

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/about', [AboutController::class, 'index'])->name('about');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// User routes

Route::middleware(['auth', 'userMiddleware'])->group(function () {
    Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');

    // route songs
    Route::get('/songs', [App\Http\Controllers\User\SongController::class, 'index'])->name('user.songs.index');
    Route::get('songs/{id}', [UserController::class, 'showSong'])->name('user.songs.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // route playlist
    Route::get('/playlists', [App\Http\Controllers\User\PlaylistController::class, 'index'])->name('user.playlists.index');
    Route::get('playlists/create', [PlaylistController::class, 'create'])->name('user.playlists.create');
    Route::post('playlists', [PlaylistController::class, 'store'])->name('user.playlists.store');
    Route::get('/playlists/{playlist}', [PlaylistController::class, 'show'])->name('user.playlists.show');
    Route::get('playlists/{playlist}/edit', [PlaylistController::class, 'edit'])->name('user.playlists.edit');
    Route::put('playlists/{playlist}', [PlaylistController::class, 'update'])->name('user.playlists.update');
    Route::delete('playlists/{playlist}', [PlaylistController::class, 'destroy'])->name('user.playlists.destroy');
});


// Admin route
Route::prefix('admin')->name('admin.')->middleware(['auth', 'adminMiddleware'])->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // route songs
    Route::resource('songs', SongController::class);

    // route artists
    Route::resource('artists', ArtistController::class);

    // route album
    Route::resource('albums', AlbumController::class);

    // genre route
    Route::resource('genres', GenreController::class);

    // route user
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
});
