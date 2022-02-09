<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Models\FirstLevelCategory;
use App\Models\SecondLevelCategory;
use App\Models\ThirdLevelCategory;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;

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

Route::resource('/', HomeController::class);

Route::resource('brands', BrandsController::class);

Route::resource('cart', CartController::class);

Route::resource('categories', CategoryController::class);

Route::resource('products', ProductController::class);

Route::resource('admin', AdminController::class)->middleware(['auth']);

Route::post('admin/variant', [AdminController::class, 'createVariant'])->middleware(['auth']);

Route::post('admin/update', [AdminController::class, 'updateProduct'])->middleware(['auth']);

Route::post('admin/removeVariant', [AdminController::class, 'removeVariant'])->middleware(['auth']);

Route::get('/search', [CategoryController::class, 'search']);

Route::get('/count', [CartController::class, 'changeCount']);

Route::resource('orders', OrderController::class);

require __DIR__.'/auth.php';
