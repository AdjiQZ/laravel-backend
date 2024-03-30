<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\Api\AuthController;
use App\http\Controllers\Api\ProdukController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['prefix' => 'v1/auth'], function() {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);


    Route::group(['middleware' => 'checktoken'], function(){
    Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::group(['prefix' => 'v1'], function(){    
    Route::group(['middleware' => 'checktoken'], function(){
    Route::get('produk', [ProdukController::class, 'getProduk']);
    Route::post('produk', [ProdukController::class, 'createProduk']);
    Route::put('produk/{id}', [ProdukController::class, 'editProduk']);
    Route::delete('produk/{id}', [ProdukController::class, 'deleteProduk']);
    });
});