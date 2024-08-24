<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\Business;
use App\Http\Controllers\business_info_controller;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\csrfController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/all-users', function(){
    return User::all();
});

Route::get('/all-business', function(){
    return Business::all();
});

Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

Route::get('/business_info', [BusinessController::class, 'show']);
Route::post('/business_info', [BusinessController::class, 'store']);
Route::put('/business_info/{id}', [BusinessController::class, 'update']);
Route::delete('/business_info/{id}', [BusinessController::class, 'destroy']);



/*Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);*/

Route::apiResource('categories', CategoryController::class);

