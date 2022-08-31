<?php

use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Controllers\Api\v1\Comment\CommentController;
use App\Http\Controllers\Api\v1\Playlist\PlaylistController;
use App\Http\Controllers\Api\v1\Song\SongController;
use App\Http\Controllers\Api\v1\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('guest')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
        Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('/me', [AuthController::class, 'me'])->name('auth.me');
        Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/{user_id}', [UserController::class, 'find'])->name('users.find');
        Route::put('/{user_id}/update', [UserController::class, 'update'])->name('users.update');
        Route::put('/{user_id}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::delete('/{user_id}/destroy', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::prefix('playlists')->group(function () {
        Route::get('/{playlist_id}', [PlaylistController::class, 'find'])->name('playlists.find');
        Route::get('/{playlist_id}/songs', [PlaylistController::class, 'getSongs'])->name('playlists.songs');
        Route::get('profile/hearts', [PlaylistController::class, 'getPlaylistsHearts'])->name('playlists.hearts');
        Route::post('/', [PlaylistController::class, 'store'])->name('playlists.store');
        Route::post('/{playlist_id}/songs', [PlaylistController::class, 'storeManySongs'])->name('playlists.songs.store');
        Route::post('/{playlist_id}/heart', [PlaylistController::class, 'storeHeart'])->name('playlists.heart');
        Route::put('/{playlist_id}/update', [PlaylistController::class, 'update'])->name('playlists.update');
        Route::delete('/{playlist_id}/destroy', [PlaylistController::class, 'destroy'])->name('playlists.destroy');
        Route::delete('/{playlist_id}/heart', [PlaylistController::class, 'destroyHeart'])->name('playlists.destroy-heart');
    });

    Route::prefix('songs')->group(function () {
        Route::get('/', [SongController::class, 'index'])->name('songs.index');
        Route::get('/{song_id}', [SongController::class, 'find'])->name('songs.find');
        Route::post('/', [SongController::class, 'store'])->name('songs.store');
        Route::put('/{song_id}/update', [SongController::class, 'update'])->name('songs.update');
        Route::delete('/{song_id}/destroy', [SongController::class, 'destroy'])->name('songs.destroy');
    });

    Route::prefix('comments')->group(function () {
        Route::post('/{playlist_id}', [CommentController::class, 'storeComment'])->name('playlists.comment');
    });
});

Route::prefix('playlists')->group(function () {
    Route::get('/', [PlaylistController::class, 'index'])->name('playlists.index');
    Route::get('/{playlist_id}/owner', [PlaylistController::class, 'getPlaylistOwnerUser'])->name('playlists.owner');
    Route::get('/{playlist_id}/hearts/count', [PlaylistController::class, 'getHeartsCount'])->name('playlists.hearts-count');
});

Route::prefix('comments')->group(function () {
    Route::get('/{playlist_id}', [CommentController::class, 'getPlaylistComments'])->name('playlists.comments');
});
