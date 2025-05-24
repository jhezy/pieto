<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Carbon;

class OrderList extends Component
{
    public $todayTransactions = 0;
    public $todayRevenue = 0;
    public $todayProfit = 0;
    public $todaySoldItems = 0;
    public $transactions = [];

    public function mount()
    {
        $this->loadTodayData();
    }

    public function loadTodayData()
    {
        $todayStart = Carbon::today();
        $todayEnd = Carbon::today()->endOfDay();

        $todayOrders = Order::whereBetween('created_at', [$todayStart, $todayEnd])
            ->with(['orderProducts.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        $this->todayTransactions = $todayOrders->count();
        $this->todayRevenue = 0;
        $this->todayProfit = 0;
        $this->todaySoldItems = 0;
        $this->transactions = [];

        foreach ($todayOrders as $order) {
            $orderRevenue = 0;
            $orderCost = 0;
            $orderItems = 0;
            $productList = [];

            foreach ($order->orderProducts as $item) {
                $sales = $item->unit_price * $item->quantity;
                $cost = $item->product->cost_price * $item->quantity;

                $orderRevenue += $sales;
                $orderCost += $cost;
                $orderItems += $item->quantity;

                $productList[] = [
                    'name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->unit_price,
                    'total' => $sales,
                ];
            }

            $this->todayRevenue += $orderRevenue;
            $this->todayProfit += ($orderRevenue - $orderCost);
            $this->todaySoldItems += $orderItems;

            $this->transactions[] = [
                'id' => $order->id,
                'invoice' => $order->invoice_number,
                'time' => Carbon::parse($order->created_at)->format('H:i'),
                'revenue' => $orderRevenue,
                'profit' => ($orderRevenue - $orderCost),
                'items' => $orderItems,
                'products' => $productList,
            ];
        }
    }

    public function printReceipt($orderId)
    {
        return redirect()->route('receipt.print', ['id' => $orderId]);
    }



    public function refresh()
    {
        $this->loadTodayData();
    }

    public function render()
    {
        return view('livewire.order-list');
    }
}
