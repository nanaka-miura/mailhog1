<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Http\Request;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;


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

Route::middleware(['auth'])->group(function () {
    Route::get('/mypage/profile', [UserController::class, 'profileEdit']);
    Route::post('/mypage/profile', [UserController::class, 'update']);
    Route::get('/sell', [ProductController::class, 'create']);
    Route::post('/sell', [ProductController::class, 'store']);
    Route::get('/mypage', [UserController::class, 'profile']);
    Route::get('/purchase/{id}', [PurchaseController::class, 'show'])->name('purchase');
    Route::get('/purchase/address/{id}', [PurchaseController::class, 'showAddressChangeForm'])->name('purchase.address');
    Route::post('/purchase/address/{id}', [PurchaseController::class, 'updateAddress'])->name('purchase.updateAddress');
    Route::post('/purchase/{id}', [PurchaseController::class, 'purchase'])->name('purchase.complete');
    Route::post('/products/{id}/comments', [ProductController::class, "storeComment"])->name('comments.store');
    Route::post('/products/{id}/like', [ProductController::class, 'like'])->name('products.like');
});

Route::get('/', [ProductController::class, 'index']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'store']);
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['signed'])
    ->name('verification.verify');

Route::get('/item/{id}', [ProductController::class, 'show'])->name('products.show');