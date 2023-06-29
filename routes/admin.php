<?php


use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Middleware\CheckAdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware'=> CheckAdminMiddleware::class,
    'prefix'=>'book',
    'as'=> 'book.'
],function(){
    Route::get('/',[BookController::class,'create'])->name('create');
    Route::put('/{book}',[BookController::class,'update'])->name('update');
    Route::get('/{book}',[BookController::class,'edit'])->name('edit');
    Route::delete('/{book}',[BookController::class,'destroy'])->name('destroy');
    Route::post('/',[BookController::class,'store'])->name('store');
});
Route::group([
    'middleware'=> CheckAdminMiddleware::class,
    'prefix'=>'cart',
    'as'=> 'cart.'
],function(){
    Route::get('/',[CartController::class,'index'])->name('index');
    Route::post('/accept/{id}',[CartController::class,'accept'])->name('accept');
    Route::post('/reject/{id}',[CartController::class,'reject'])->name('reject');
    Route::post('/restore/{id}',[CartController::class,'restore'])->name('restore');
});
