<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReceiptController;
use App\Livewire\Pos;
use App\Livewire\ProductList;
use App\Livewire\ProductCreate;
use App\Livewire\ProductEdit;
use App\Livewire\OrderList;

// Redirect default -> cek role/email
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();
    if ($user->email == 'superadmin@gmail.com') {
        return redirect()->route('order');
    } elseif ($user->email == 'kasir@gmail.com') {
        return redirect()->route('pos');
    } else {
        return redirect()->route('order'); // Default redirect jika email tidak terdaftar
    }
});

// Redirect setelah login
Route::get('/home', function () {
    $user = Auth::user();
    if ($user->email == 'superadmin@gmail.com') {
        return redirect()->route('order');
    } elseif ($user->email == 'kasir@gmail.com') {
        return redirect()->route('pos');
    } else {
        return redirect()->route('order');
    }
});

Route::middleware(['auth'])->group(function () {
    Route::get('/pos', Pos::class)->name('pos');

    Route::get('/product', ProductList::class)->name('product');
    Route::get('/product/create', ProductCreate::class);
    Route::get('/product/edit/{id}', ProductEdit::class)->name('product.edit');

    Route::get('/order', OrderList::class)->name('order');

    // Perbaiki duplikasi route receipt
    Route::get('/order/{id}/receipt', [ReceiptController::class, 'show'])->name('receipt.print');

    Route::get('/rekap', fn() => view('report.rekap'));

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});

// Route auth bawaan Laravel
Auth::routes();
