<?php

// app/Http/Controllers/ReceiptController.php

namespace App\Http\Controllers;

use App\Models\Order;

class ReceiptController extends Controller
{
    public function show($id)
    {
        $order = Order::with('orderProducts.product')->findOrFail($id);

        return view('orders.receipt', compact('order'));
    }
}
