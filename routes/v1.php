<?php

use App\Http\Controllers\API\V1\ApiAuthController;
use App\Http\Controllers\API\V1\ApiBundleController;
use App\Http\Controllers\API\V1\ApiBundlePurchaseController;
use App\Http\Controllers\API\V1\ApiCategoryController;
use App\Http\Controllers\API\V1\ApiOperatorController;
use App\Http\Controllers\API\V1\ApiUserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'middleware' => ['guest', 'throttle:30,1']], function() {
    Route::post('login', [ApiAuthController::class, 'login']);
    Route::post('verify', [ApiAuthController::class, 'verify']);
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::group(['prefix' => 'category'], function() {
        Route::get('/', [ApiCategoryController::class, 'index']);
    });

    Route::group(['prefix' => 'operator'], function() {
        Route::get('/{id}', [ApiOperatorController::class, 'show']);
    });

    Route::group(['prefix' => 'bundle'], function() {
        Route::get('/{id}', [ApiBundleController::class, 'show']);
    });

    Route::group(['prefix' => 'purchase'], function() {
        Route::post('/validate', [ApiBundlePurchaseController::class, 'validate']);
        Route::post('/execute', [ApiBundlePurchaseController::class, 'execute']);
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/profile', [ApiUserController::class, 'profile']);
    });
});
