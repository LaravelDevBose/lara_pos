<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ExpanseHeadController;


Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login')->middleware('guest');

Route::middleware(['auth:sanctum', 'verified'])->group(function (){
    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::resource('/brand', BrandController::class)->except('create', 'show');
    Route::resource('/category', CategoryController::class)->except('create', 'show');
    Route::resource('/expanse_heads', ExpanseHeadController::class)->except('create', 'show');

    Route::resource('/contacts', ContactController::class);
    Route::get('/datatable/contacts', [ContactController::class, 'datatable'])->name('contacts.datatable');

});
