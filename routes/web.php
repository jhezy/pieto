<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReceiptController;
use App\Livewire\Pos;
use App\Livewire\ProductList;
use App\Livewire\ProductCreate;
use App\Livewire\ProductEdit;
use App\Livewire\OrderList;
use App\Livewire\UserCreate;
use App\Livewire\UserEdit; // ⬅️ Tambahkan ini
use App\Http\Controllers\UserManagementController;

// Redirect default -> cek role
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();
    if ($user->role == 'admin') {
        return redirect()->route('order');
    } elseif ($user->role == 'kasir') {
        return redirect()->route('pos');
    } else {
        return redirect()->route('login'); // Kalau role tidak dikenali
    }
})->name('home');

// Redirect setelah login
Route::get('/home', function () {
    $user = Auth::user();
    if ($user->role == 'admin') {
        return redirect()->route('order');
    } elseif ($user->role == 'kasir') {
        return redirect()->route('pos');
    } else {
        return redirect()->route('login');
    }
});

// ✅ Route yang bisa diakses admin & kasir
Route::middleware(['auth'])->group(function () {
    Route::get('/order', OrderList::class)->name('order');
    Route::get('/order/{id}/receipt', [ReceiptController::class, 'show'])->name('receipt.print');
});

// Route khusus Admin
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/user-management', \App\Livewire\UserManagement::class)->name('user-management');

    Route::get('/user-management/create', UserCreate::class)->name('user.create');
    Route::get('/user-management/edit/{user}', UserEdit::class)->name('user.edit');


    Route::get('/product', ProductList::class)->name('product');
    Route::get('/product/create', ProductCreate::class)->name('product.create');
    Route::get('/product/edit/{id}', ProductEdit::class)->name('product.edit');

    Route::get('/rekap', fn() => view('report.rekap'))->name('rekap');
});

// Route khusus Kasir
Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/pos', Pos::class)->name('pos');
});

// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Auth Laravel UI
Auth::routes();
