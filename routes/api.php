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
    // Cars
    Route::prefix('/cars')->controller('CarController')->group(function (){
        Route::get('/','index');
        Route::post('/','store')->middleware('auth:sanctum');
        Route::get('/{car}','show');
        Route::patch('/{car}','update')->middleware('auth:sanctum');
        Route::delete('/{car}','destroy')->middleware('auth:sanctum');
    });
    // Brands
    Route::prefix('/brands')->controller('BrandController')->group(function (){
        Route::get('/','index');
        Route::post('/','store')->middleware('auth:sanctum');
        Route::get('/{brand}','show');
        Route::patch('/{brand}','update')->middleware('auth:sanctum');
        Route::delete('/{brand}','destroy')->middleware('auth:sanctum');
    });
});
Route::namespace('App\Http\Controllers')->group(function ($router) {
    Route::prefix('/auth')->controller('AuthController')->group(function (){
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::post('/logout', 'logout')->middleware('auth:sanctum');
        Route::post('/forgot-password' ,'forget')->middleware('auth:sanctum');
        Route::post('/reset-password' ,'reset')->middleware('auth:sanctum');
    });
});
