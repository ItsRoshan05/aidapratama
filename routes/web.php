<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LabaRugiController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\LaporanPembelianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UserController;

// Redirect root to login
Route::redirect('/', '/login');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('products', ProductController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('supliers', SuplierController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::get('purchases/{id}/print', [PurchaseController::class, 'print'])->name('purchases.print');
    Route::resource('sales', SaleController::class);
    Route::get('sales/{id}/print', [SaleController::class, 'print'])->name('sales.print');
    Route::resource('expenses', ExpenseController::class);
    Route::get('laba-rugi', [LabaRugiController::class, 'index'])->name('laba-rugi.index');
    Route::get('laporan-penjualan', [LaporanPenjualanController::class, 'index'])->name('laporan-penjualan.index');
    Route::get('laporan-pembelian', [LaporanPembelianController::class, 'index'])->name('laporan-pembelian.index');
    Route::get('/ganti-password', [PasswordController::class, 'edit'])->name('password.change');
    Route::post('/ganti-password', [PasswordController::class, 'update'])->name('password.update');
    Route::resource('users', UserController::class);
    Route::get('admin/laporan-penjualan/pdf', [LaporanPenjualanController::class, 'exportPdf'])->name('laporan-penjualan.pdf');
    Route::get('admin/laporan-penjualan/excel', [LaporanPenjualanController::class, 'exportExcel'])->name('laporan-penjualan.excel');
}); 


// Testing
Route::view('/dashboard', 'dashboard');
Route::view('/customers', 'admin.customers.index');

