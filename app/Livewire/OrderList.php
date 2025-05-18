<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class OrderList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;


    public function render()
    {
        $query = Order::search($this->search)
            ->whereNotNull('done_at')
            ->orderBy('done_at', 'DESC');

        // GANTI 'grand_total' sesuai nama kolom yang benar
        $totalPrice = $query->clone()->sum('paid_amount');
        $totalTransactions = $query->clone()->count();

        $orders = Order::whereDate('done_at', now())->get();

        return view('livewire.order-list', [
            'orders' => $orders,
            'totalPriceFormatted' => 'Rp ' . number_format($orders->sum('total_price'), 0, ',', '.'),

            'orders' => $query->paginate($this->perPage),
            'totalPrice' => $totalPrice,
            'totalTransactions' => $totalTransactions,
        ]);
    }
    public function deleteTodayOrders()
    {
        $today = Carbon::today();

        DB::table('orders')
            ->whereDate('created_at', $today)
            ->delete();

        session()->flash('message', 'Order hari ini berhasil dihapus.');

        $this->resetPage(); // jika pakai pagination
    }
    public function getTotalPriceFormattedProperty()
    {
        $total = $this->orders->sum('total_price');
        return 'Rp ' . number_format($total, 0, ',', '.');
    }
    public function printReceipt($id)
    {
        $order = Order::with('orderProducts.product')->findOrFail($id);
        return view('orders.receipt', compact('order'));
    }


    public function done()
    {
        $this->validate([
            'paid_amount' => 'required|numeric|min:' . $this->total_price,
        ]);

        $this->order->update([
            'paid_amount' => $this->paid_amount,
            'done_at' => now(),
        ]);

        $this->order->refresh(); // <- ini penting agar data terbaru muncul

        $this->emit('paymentSuccess');
    }
}
