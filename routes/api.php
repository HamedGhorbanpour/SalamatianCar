<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::namespace('App\Http\Controllers\Pannel')->group(function($router) {
    // Category
    Route::prefix('/cars')->controller('CarController')->group(function (){
        Route::get('/','index');
        Route::post('/','store')->middleware('auth:sanctum');
        Route::get('/{id}','show');
        Route::patch('/{id}','update')->middleware('auth:sanctum');
        Route::delete('/{id}','destroy')->middleware('auth:sanctum');
    });
    // Article
    Route::prefix('/brands')->controller('BrandController')->group(function (){
        Route::get('/','index');
        Route::post('/','store')->middleware('auth:sanctum');
        Route::get('/{id}','show');
        Route::patch('/{id}','update')->middleware('auth:sanctum');
        Route::delete('/{id}','destroy')->middleware('auth:sanctum');
    });
});
