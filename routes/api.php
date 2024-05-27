<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Models\Famille;
use App\Models\SousFamille;
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

Route::post('/add-cart', [CartController::class, 'addCart'])->name('add-cart');
Route::post('/cart/remove-art', [CartController::class, 'removeCart'])->name('cart.remove-cart');
