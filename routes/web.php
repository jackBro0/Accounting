<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MoneyFlowController;
use Illuminate\Support\Facades\Route;

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
Route::middleware('guest')->group(function (){
    Route::get('/', [LoginController::class, 'login'])->name('login');
    Route::get('/register',[UserAuthController::class,'register'])->name('register');
    Route::post('/create',[UserAuthController::class,'createUser'])->name('create');
});

Route::post('/check', [LoginController::class, 'check'])->name('check');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



Route::middleware('auth')->group(function (){
    Route::get('/index',[MainController::class,'index'])->name('index');
    Route::resource('money_flow', MoneyFlowController::class);
    Route::resource('category', CategoryController::class);
});
