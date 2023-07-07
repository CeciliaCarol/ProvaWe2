<?php

use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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
});

Route::middleware('auth')->group(function() {
    Route::resource('songs', SongController::class);
    Route::resource('Playlists', PlaylistController::class);

    Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists.index');
    Route::put('/playlists/{playlist}/songs/{song}', [PlaylistController::class, 'addSong'])->name('playlists.add-song');
    Route::delete('/playlists/{playlist}/songs/{song}', [PlaylistController::class, 'removeSong'])->name('playlists.remove-song');
});

require __DIR__.'/auth.php';
