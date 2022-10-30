<?php

use App\Http\Controllers\API\V1\ApiAuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function() {
    Route::post('login', [ApiAuthController::class, 'login']);
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::group(['prefix' => 'user'], function () {

    });
});
