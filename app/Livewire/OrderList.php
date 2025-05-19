<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Closing;

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

    public function closingToday()
    {
        $tanggal = Carbon::today()->toDateString();

        $data = DB::table('orders')
            ->whereDate('done_at', $tanggal)
            ->selectRaw('COUNT(*) as jumlah_transaksi, SUM(paid_amount) as total_pendapatan')
            ->first();

        // Cek jika sudah pernah closing hari ini
        if (Closing::where('tanggal', $tanggal)->exists()) {
            session()->flash('message', 'Transaksi hari ini sudah ditutup.');
            return;
        }

        Closing::create([
            'tanggal' => $tanggal,
            'jumlah_transaksi' => $data->jumlah_transaksi ?? 0,
            'total_pendapatan' => $data->total_pendapatan ?? 0,
        ]);

        session()->flash('message', 'Transaksi hari ini berhasil ditutup (closing).');
    }
}
