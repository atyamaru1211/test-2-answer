<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SeasonController;

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

//GETリクエストで、/productsというURLにアクセスがあった場合に、ProductControllerのgetProductsを実行する
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/register', [SeasonController::class, 'create']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/detail/{product_id}', [ProductController::class, 'show']);
Route::get('/products/search', [ProductController::class, 'search']);
//Route::post('/products/search', [ProductController::class, 'postSearch']);
Route::get('/products/{product_id}/delete', [ProductController::class, 'destroy']);
