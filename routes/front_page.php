<?php


use App\Http\Controllers\HomePage\CartController;
use App\Http\Controllers\HomePage\HomePageController;
use App\Http\Middleware\CheckLoginMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomePageController::class,'index'])->name('index');
Route::get('/book/{book}',[HomePageController::class,'show'])->name('show');

Route::group([
    'middleware' => CheckLoginMiddleware::class
],function (){
    Route::post('/comment',[HomePageController::class,'postComment'])->name('postComment');
    Route::post('/buy',[CartController::class,'processBuy'])->name('processBuy');
    Route::get('/cart',[CartController::class,'showCart'])->name('showCart');
    Route::get('/cart/edit/{cart}',[CartController::class,'editCart'])->name('editCart');
    Route::put('/cart/update/{cart}',[CartController::class,'updateCart'])->name('updateCart');
    Route::delete('/cart/{cart}',[CartController::class,'destroy'])->name('destroyCart');
    Route::post('/receive/{cart}',[CartController::class,'receive'])->name('receive');
});

