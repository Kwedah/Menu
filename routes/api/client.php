<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Client\AuthController;
use App\Http\Controllers\Api\Client\CartController;
use App\Http\Controllers\Api\Client\ProductController;
use App\Http\Controllers\Api\Client\CategoryController;
use App\Http\Controllers\Api\Client\DelivaryController;


Route::post('client-register' , [AuthController::class , 'register']);
Route::post('client-login' , [AuthController::class , 'login']);

Route::group(['middleware' => ['auth:sanctum']], function (){

    Route::get('client-profile' , [AuthController::class , 'profile']);
    Route::get('client-logout' , [AuthController::class , 'logout']);

    Route::get('get-category' , [CategoryController::class , 'getCategory']);

    Route::get('get-product' , [ProductController::class , 'getProduct']);

    // Route::post('delivary' , [DelivaryController::class , 'delivary']);

    Route::post('add-delivary' , [CartController::class , 'addCart']);
    Route::post('get-delivary' , [CartController::class , 'getCart']);
    Route::post('remove-delivary' , [CartController::class , 'removeCart']);
});

Route::get('/', function () {
    return view('welcome');
});
