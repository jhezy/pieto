<?php

// app/Http/Controllers/ReceiptController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction; // sesuaikan jika modelnya bernama lain

class ReceiptController extends Controller
{
    public function print($id)
    {
        $transaction = Transaction::with('items.product')->findOrFail($id); // sesuaikan relasi jika berbeda
        return view('orders.receipt', compact('transaction'));
    }
}
