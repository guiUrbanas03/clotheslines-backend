<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/{user_id}', [UserController::class, 'find'])->name('users.find');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::put('/{user_id}/update', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user_id}/destroy', [UserController::class, 'destroy'])->name('users.destroy');
});
