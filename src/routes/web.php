<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;


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

Route::get('/login', [AuthController::class,'index']);
Route::get('/register', [AuthController::class,'register']);
Route::get('/mypage/profile', [UserController::class,'profile']);
Route::get('/', [ProductController::class,'index']);
Route::get('/mypage', [UserController::class,'mypage']);
Route::get('/sell', [ProductController::class,'sell']);