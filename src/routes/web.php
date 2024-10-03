<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Http\Request;


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

Route::get('/', [ProductController::class,'index']);
Route::get('/register', [AuthController::class,'register']);
Route::post('/register', [AuthController::class, 'store']);
Route::get('/mypage/profile', [UserController::class,'profileEdit'])->middleware(['auth']);
Route::post('/mypage/profile', [UserController::class,'update'])->middleware(['auth']);
Route::get('/sell', [ProductController::class,'create'])->middleware(['auth']);
Route::post('/sell', [ProductController::class,'store'])->middleware(['auth']);
Route::get('/item/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/mypage', [UserController::class, 'profile'])->middleware(['auth']);
Route::get('/purchase/{id}', [PurchaseController::class,'show'])->name('purchase');
Route::get('/purchase/address/{id}',[PurchaseController::class,'showAddressChangeForm'])->name('purchase.address');
Route::post('/purchase/address/{id}',[PurchaseController::class,'updateAddress'])->name('purchase.updateAddress');
Route::post('/purchase/{id}',[PurchaseController::class,'purchase'])->name('purchase.complete');
