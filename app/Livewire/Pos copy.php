<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\WithFileUploads;
use Livewire\Features\SupportBrowserEvents\Browser;


class Pos extends Component
{
    public $search = '';
    public $product;
    public $order;
    // public $change = 0;
    public $paid_amount = 0;
    public $total_price = 0;
    public $change = 0;

    public function render()
    {
        $this->order = Order::where('done_at', null)
            ->with('orderProducts')
            ->latest()
            ->first();
        $this->total_price = $this->order->total_price ?? 0;
        return view('livewire.pos', [
            'products' => Product::search($this->search)->paginate(12),
            'order' => $this->order
        ]);
    }

    public function createOrder()
    {
        $this->order = Order::where('done_at', null)
            ->latest()
            ->first();

        if ($this->order ==  null) {
            $this->order = Order::create([
                'invoice_number' => $this->generateUniqueCode()
            ]);
        }
        session()->flash('message', 'Sukses mulai transaksi, silakan pilih produk.');
    }

    public function updateCart($productId, $isAdded = true)
    {
        try {
            if ($this->order) {
                $product = Product::findOrFail($productId);
                $orderProduct = OrderProduct::where('order_id', $this->order->id)
                    ->where('product_id', $productId)
                    ->first();

                if ($orderProduct) {
                    if ($isAdded) {
                        $orderProduct->increment('quantity', 1);
                    } else {
                        $orderProduct->decrement('quantity', 1);
                        if ($orderProduct->quantity < 1) {
                            $orderProduct->delete();
                            session()->flash('message', 'Produk berhasil dihapus dari keranjang');
                            return;
                        }
                    }
                    $orderProduct->save();
                } else {
                    if ($isAdded) {
                        OrderProduct::create([
                            'order_id' => $this->order->id,
                            'product_id' => $product->id,
                            'unit_price' => $product->selling_price,
                            'quantity' => 1
                        ]);
                    }
                }
                $this->total_price = $this->order->total_price ?? 0;

                session()->flash('message', $isAdded ? 'Produk berhasil ditambahkan' : 'Produk berhasil dihapus dari keranjang');
            } else {
                session()->flash('message', 'Klik Mulai Transaksi Dahulu');
            }
        } catch (ValidationException $e) {
            dd($e);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function done()
    {
        $this->validate([
            'paid_amount' => 'required|numeric|min:' . $this->total_price,
        ]);

        $this->order->update([
            'paid_amount' => $this->paid_amount,
            'done_at' => now()
        ]);

        $this->change = "1000";

        // Reset property agar form kosong kembali
        $this->reset(['paid_amount']);

        session()->flash('message', 'Pembayaran berhasil disimpan.');

        return redirect()->route('order');
    }





    public function getTotalPriceProperty()
    {
        return $this->order?->orderProducts->sum('total_price') ?? 0;
    }


    function generateUniqueCode($length = 6)
    {
        $number = uniqid();
        $varray = str_split($number);
        $len = sizeof($varray);
        $uniq = array_slice($varray, $len - 6, $len);
        $uniq = implode(",", $uniq);
        $uniq = str_replace(',', '', $uniq);

        return $uniq;
    }
}
