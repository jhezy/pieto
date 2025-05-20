<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Carbon\Carbon;
use Livewire\Component;

class ReportComponent extends Component
{
    public $startDate;
    public $endDate;
    public $orders;
    public $totalSales = 0;
    public $totalCost = 0;
    public $totalProfit = 0;
    public $topProducts = [];
    public $dailySales = [];
    public $isFiltered = false;

    public function mount()
    {
        // Set default date range to current month
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
    }

    public function generateReport()
    {
        $this->isFiltered = true;

        // Get orders within date range
        $this->orders = Order::whereBetween('created_at', [
            Carbon::parse($this->startDate)->startOfDay(),
            Carbon::parse($this->endDate)->endOfDay()
        ])
            ->with(['orderProducts.product'])
            ->get();

        // Reset calculations
        $this->totalSales = 0;
        $this->totalCost = 0;
        $this->totalProfit = 0;
        $productSales = [];
        $this->dailySales = [];

        // Daily sales data
        $period = Carbon::parse($this->startDate)->daysUntil(Carbon::parse($this->endDate));
        foreach ($period as $date) {
            $this->dailySales[$date->format('Y-m-d')] = [
                'date' => $date->format('d M'),
                'sales' => 0,
                'profit' => 0
            ];
        }

        // Calculate totals
        foreach ($this->orders as $order) {
            $orderDate = Carbon::parse($order->created_at)->format('Y-m-d');
            $orderSales = 0;
            $orderCost = 0;

            foreach ($order->orderProducts as $item) {
                $sales = $item->unit_price * $item->quantity;
                $cost = $item->product->cost_price * $item->quantity;
                $profit = $sales - $cost;

                $orderSales += $sales;
                $orderCost += $cost;

                // Track product sales
                if (!isset($productSales[$item->product_id])) {
                    $productSales[$item->product_id] = [
                        'product' => $item->product,
                        'quantity' => 0,
                        'sales' => 0,
                        'profit' => 0
                    ];
                }

                $productSales[$item->product_id]['quantity'] += $item->quantity;
                $productSales[$item->product_id]['sales'] += $sales;
                $productSales[$item->product_id]['profit'] += $profit;
            }

            // Add to daily sales
            if (isset($this->dailySales[$orderDate])) {
                $this->dailySales[$orderDate]['sales'] += $orderSales;
                $this->dailySales[$orderDate]['profit'] += ($orderSales - $orderCost);
            }

            $this->totalSales += $orderSales;
            $this->totalCost += $orderCost;
        }

        $this->totalProfit = $this->totalSales - $this->totalCost;

        // Get top 5 products by sales
        usort($productSales, function ($a, $b) {
            return $b['sales'] <=> $a['sales'];
        });

        $this->topProducts = array_slice($productSales, 0, 5);
    }

    public function exportPDF()
    {
        $this->dispatch('printReport');
    }

    public function render()
    {
        return view('livewire.report-component');
    }
}
