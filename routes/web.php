<?php

use App\Http\Controllers\Dashboard\BundleController;
use App\Http\Controllers\Dashboard\OperatorCategoryController;
use App\Http\Controllers\Dashboard\OperatorController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\OptionController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Dashboard\TransactionController;
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

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'operator'], function(){
        Route::resource('category', OperatorCategoryController::class)->except(['destroy']);
    });
    Route::resource('operator', OperatorController::class);
    Route::resource('bundle', BundleController::class);
    Route::resource('transaction', TransactionController::class)->only('index');

    Route::group(['prefix' => 'manage'], function() {
        Route::resource('role', RoleController::class);

        Route::group(['prefix' => 'user'], function() {
            Route::get('import', [UserController::class, 'import'])->name('user.import');
            Route::get('export', [UserController::class, 'export'])->name('user.export');
        });
        Route::resource('user', UserController::class);
        Route::resource('option', OptionController::class)->only(['index', 'store']);
    });
});
require __DIR__.'/auth.php';
