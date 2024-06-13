<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CustomerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/v1', 'middleware' => 'jwt.auth'], function () {

    Route::controller(CustomerController::class)->group(function () {
        Route::get('customers', 'index');
        Route::get('/customer/{id}', 'show');
        Route::delete('/customer', 'destroy');
        Route::put('/customer/{id}', 'update');
        #Route::put('/customer/editPermission', 'editPermission');
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'index');
        Route::get('/product/{id}', 'show');
        Route::post('/product', 'store');
        Route::delete('/product/{id}', 'destroy');
        Route::put('/product/{id}', 'update');
    });
});

//Create User
Route::post('v1/customer/store', [CustomerController::class, 'store']);

// Auth Routes
Route::group(['prefix' => '/v1'], function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/logout', 'logout');
        Route::post('/validateEmail', 'validateEmail');
    });
});
