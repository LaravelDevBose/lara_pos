<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ExpanseHeadController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\Setting\BusinessLocationController;
use App\Http\Controllers\Setting\UnitController;
use App\Http\Controllers\Setting\TaxController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Purchase\PurchaseController;
use App\Http\Controllers\Sell\SellController;
use App\Http\Controllers\Sell\PosController;


Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login')->middleware('guest');

Route::middleware(['auth:sanctum', 'verified'])->group(function (){
    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::resource('/brand', BrandController::class)->except('create', 'show');
    Route::resource('/category', CategoryController::class)->except('create', 'show');
    Route::resource('/expanse-heads', ExpanseHeadController::class)->except('create', 'show')->names('expanse_heads');

    Route::resource('/contacts', ContactController::class);
    Route::get('/contact/details/{id}', [ContactController::class, 'details']);
    Route::get('/datatable/contacts', [ContactController::class, 'datatable'])->name('contacts.datatable');

    Route::resource('/bank-accounts', BankAccountController::class)->names('bank_accounts');


    Route::resource('/expenses', ExpenseController::class)->except('show');
    Route::get('/datatable/expenses', [ExpenseController::class, 'datatable'])->name('expenses.datatable');

    Route::get('view/{id}/payments', [TransactionController::class, 'show'])->name('view.transactions');
    Route::get('add/{id}/transaction', [TransactionController::class, 'create'])->name('add.transactions');
    Route::post('store/transaction', [TransactionController::class, 'store'])->name('store.transactions');

    Route::resource('products', ProductController::class);
    Route::get('/purchase/product/{id}', [ProductController::class, 'purchase_product']);
    Route::get('/datatable/products', [ProductController::class, 'datatable'])->name('products.datatable');

    Route::resource('purchases', PurchaseController::class);
    Route::get('/datatable/purchases', [PurchaseController::class, 'datatable'])->name('purchases.datatable');

    Route::resource('sells', SellController::class);
    Route::get('/datatable/sells', [SellController::class, 'datatable'])->name('sells.datatable');
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');

    Route::group(['prefix'=>'ajax', 'as'=>'ajax.'], function (){
        Route::get('/product-list', [ProductController::class, 'ajax_get_products'])->name('get.products');
    });

    Route::resource('/business-locations', BusinessLocationController::class)->names('business_locations');
    Route::resource('/unites', UnitController::class)->except('create', 'show');
    Route::resource('/taxes', TaxController::class)->except('create', 'show');
});
