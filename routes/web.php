<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;


Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->group(function (){
    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::group(['prefix'=>'brands', 'as'=>'brand.'], function (){
        Route::get('/list', [BrandController::class, 'index'])->name('index');
        Route::post('store', [BrandController::class, 'store'])->name('store');
        Route::put('/{brand_id}/update', [BrandController::class, 'update'])->name('update');
        Route::delete('/{brand_id}/destroy', [BrandController::class, 'destroy'])->name('delete');
    });

    Route::group(['prefix'=>'categories', 'as'=>'category.'], function (){
        Route::get('/list', [CategoryController::class, 'index'])->name('index');
        Route::post('store', [CategoryController::class, 'store'])->name('store');
        Route::put('/{cat_id}/update', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{cat_id}/destroy', [CategoryController::class, 'destroy'])->name('delete');
    });

});
