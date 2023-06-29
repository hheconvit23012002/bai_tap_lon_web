<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckLoginedMiddleware;
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

Route::get('/books', [BookController::class,'index'])->name('list_book');

Route::group([
    'middleware' => CheckLoginedMiddleware::class
],function (){
    Route::get('/login', [AuthController::class,'login'])->name('login');
    Route::get('/register', [AuthController::class,'register'])->name('register');
    Route::post('/register', [AuthController::class,'registering'])->name('registering');
    Route::post('/login', [AuthController::class,'logining'])->name('logining');
});

Route::get('/logout', [AuthController::class,'logout'])->name('logout');
