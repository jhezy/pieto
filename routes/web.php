<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware(['auth'])->group(
    function () {
        Route::get('/', App\Livewire\Pos::class);
        Route::get('pos', App\Livewire\Pos::class)->name('pos');
        Route::get('product', App\Livewire\ProductList::class)->name('product');
        Route::get('product/create', App\Livewire\ProductCreate::class);
        Route::get('product/edit/{id}', App\Livewire\ProductEdit::class)->name('posts.edit');
        Route::get('order', App\Livewire\OrderList::class)->name('order');
        Route::get('/order/{id}/receipt', [App\Livewire\OrderList::class, 'printReceipt'])->name('order.receipt');
        Route::get('/home', [\App\Livewire\Pos::class])->name('home');
    }
);

Auth::routes();
