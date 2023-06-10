<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [App\Http\Controllers\HomeController::class, 'productShow'])->name('productShow');

Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);

    Route::get('reviews/create/{productId}', [ReviewController::class, 'create'])->name('createReview');
    Route::post('reviews/store/{productId}', [ReviewController::class, 'store'])->name('storeReview');
});
