<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\OptionController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [FrontendController::class, 'index']);

Route::group(['prefix' => 'dashboard'], function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'manage'], function() {
        Route::resource('role', RoleController::class);
        Route::resource('user', UserController::class);
        Route::resource('option', OptionController::class)->only(['index', 'store']);
    });
});
require __DIR__.'/auth.php';
