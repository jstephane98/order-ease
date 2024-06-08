<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
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


Route::middleware('auth')->group(function () {

    Route::middleware('is_guest')->group(function () {
        Route::match(['get', 'post'], '/articles', [HomeController::class, 'home'])->name('home');
        Route::get('/article/{article:ART_CODE}', [HomeController::class, 'showArticle'])->name("show-article");
    });

    Route::get('/panier/{step?}', [CartController::class, 'showCart'])->name('panier');
    Route::get('/orders/save', [OrderController::class, 'store'])->name('orders.save');
    Route::get("order/cancel", [OrderController::class, 'cancel'])->name("order.cancel");

    Route::get('commercial/orders', [\App\Http\Controllers\Commercial\OrderController::class, 'index'])->name("commercial:orders.index");

    Route::get("/orders/{id}", [OrderController::class, 'show'])->name('admin:order.show');

    Route::prefix('admin')->middleware('is_admin')->group(function () {
       Route::get("/orders", [OrderController::class, 'index'])->name('admin:order.index');
       Route::post('/orders/validate', [OrderController::class, 'validOrder'])->name('valid-order');

       // Users
        Route::get('/users', [UserController::class, 'index'])->name("admin:user.index");
        Route::post('register', [RegisteredUserController::class, 'store'])->name("store:user");
        Route::put('users', [UserController::class, 'update'])->name("update:user");
        Route::patch('/users/activate', [UserController::class, 'activate'])->name("activate:user");
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
