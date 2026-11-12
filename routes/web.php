<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Protected Route (Harus Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [TransactionController::class, 'dashboard'])->name('dashboard');
    
    // Hak Akses Admin & Kasir
    Route::resource('customers', CustomerController::class);
    Route::resource('transactions', TransactionController::class);

    // Proteksi Khusus Role Admin[cite: 2]
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
    });
});

require __DIR__.'/auth.php';