<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class RekapTransaksi extends Component
{
    public function render()
    {
        $rekap = DB::table('orders')
            ->selectRaw('DATE(done_at) as tanggal, COUNT(*) as jumlah_transaksi, SUM(paid_amount) as total_pendapatan')
            ->whereNotNull('done_at')
            ->groupBy('tanggal')
            ->orderByDesc('tanggal')
            ->get();

        $totalPrice = $rekap->sum('total_pendapatan');
        $totalTransactions = $rekap->sum('jumlah_transaksi');

        return view('livewire.rekap-transaksi', [
            'rekap' => $rekap,
            'totalPrice' => $totalPrice,
            'totalPriceFormatted' => 'Rp ' . number_format($totalPrice, 0, ',', '.'),
            'totalTransactions' => $totalTransactions,
        ]);
    }
}
