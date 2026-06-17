<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuickAddController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Customer CRUD
    Route::resource('customers', \App\Http\Controllers\CustomerController::class);
    // Product CRUD
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    // Debt CRUD
    Route::resource('debts', \App\Http\Controllers\DebtController::class);
    // Debt Payment CRUD
    Route::resource('debt-payments', \App\Http\Controllers\DebtPaymentController::class);
    
    // Quick Add
    Route::get('/quick-add', [QuickAddController::class, 'index'])->name('quick-add.index');
    // Categories
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::post('/pos', [POSController::class, 'store'])->name('pos.store');

    // History & Logs
    Route::get('/history', [\App\Http\Controllers\HistoryController::class, 'index'])->name('history.index');
    // Reprint Receipt
    Route::get('/sales/{sale}/print', [POSController::class, 'printReceipt'])->name('sales.print');
});

require __DIR__.'/auth.php';
