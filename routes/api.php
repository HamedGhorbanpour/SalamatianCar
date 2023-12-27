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

// Panel
Route::namespace('App\Http\Controllers\Panel')
    ->middleware('auth:sanctum')
    ->group(function() {
    // Cars
    Route::prefix('/cars')->controller('CarController')->group(function (){
        Route::post('/','store',);
        Route::get('/{car}','show');
        Route::patch('/{car}','update');
        Route::delete('/{car}','destroy');
    });
    // Brands
    Route::prefix('/brands')->controller('BrandController')->group(function (){
        Route::post('/','store',);
        Route::get('/{brand}','show');
        Route::patch('/{brand}','update');
        Route::delete('/{brand}','destroy');
    });
    // Users
    Route::prefix('/users')->controller('UserController')->group(function (){
        Route::get('/','index');
        Route::post('/','store');
        Route::get('/{user}','show');
        Route::patch('/{user}','update');
        Route::delete('/{user}','destroy');
    });
    // Taxes & Benefits
    Route::prefix('/percents')->controller('PercentController')->group(function (){
        Route::patch('/','update');
    });
});
Route::namespace('App/Http/Controllers/Panel')->group(function (){
    Route::prefix('/cars')->controller('CarController')->group(function (){
        Route::get('/','index',);
    });
    Route::prefix('/brands')->controller('BrandController')->group(function (){
        Route::post('/','index',);
    });
    Route::prefix('/percents')->controller('BrandController')->group(function (){
        Route::get('/','index',);
    });
});
// Auth
Route::namespace('App\Http\Controllers')->group(function ($router) {
    Route::prefix('/auth')->controller('AuthController')->group(function (){
        Route::post('/login', 'login')->name('login');
        Route::post('/logout', 'logout')->middleware('auth:sanctum')->name('logout');
        Route::post('/forgot-password' ,'forget')->name('password.forgot');
        Route::patch('/reset-password' ,'reset')->name('password.reset');
    });
});
