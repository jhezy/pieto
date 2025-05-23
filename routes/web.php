<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Livewire\Pos;
use App\Livewire\ProductList;
use App\Livewire\ProductCreate;
use App\Livewire\ProductEdit;
use App\Livewire\OrderList;
use App\Livewire\RekapTransaksi;

Route::middleware(['auth'])->group(function () {
    // POS
    Route::get('/', Pos::class)->name('pos');
    Route::get('/home', function () {
        return redirect()->route('pos');
    });

    // Produk
    Route::get('/product', ProductList::class)->name('product');
    Route::get('/product/create', ProductCreate::class);
    Route::get('/product/edit/{id}', ProductEdit::class)->name('product.edit');

    // Order
    Route::get('/order', OrderList::class)->name('order');
    Route::get('/order/{id}/receipt', [App\Livewire\OrderList::class, 'printReceipt'])->name('order.receipt');
    Route::get('/receipt/{id}/print', [ReceiptController::class, 'print'])->name('receipt.print');



    // Rekap Transaksi
    Route::get('/rekap', function () {
        return view('report.rekap');
    });


    // logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});

Auth::routes();
