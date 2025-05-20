<div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-file-earmark-bar-graph me-2 text-warning"></i>
                        Laporan Penjualan & Keuntungan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="startDate" class="form-label">Tanggal Awal</label>
                            <input type="date" wire:model="startDate" id="startDate" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="endDate" class="form-label">Tanggal Akhir</label>
                            <input type="date" wire:model="endDate" id="endDate" class="form-control">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button wire:click="generateReport" class="btn btn-warning me-2">
                                <i class="bi bi-search me-1"></i> Tampilkan Laporan
                            </button>
                            @if ($isFiltered)
                                <button wire:click="exportPDF" class="btn btn-outline-dark">
                                    <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($isFiltered)
        <div id="printable-report">
            <div class="row mb-4">
                <div class="col-12 text-center print-header" style="display: none;">
                    <h3 class="mb-1">KASIR PIETO</h3>
                    <p class="mb-3">Laporan Penjualan & Keuntungan</p>
                    <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} -
                        {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
                    <hr>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm h-100 bg-white">
                        <div class="card-body text-center">
                            <h6 class="text-muted mb-2">Total Penjualan</h6>
                            <h3 class="mb-0">Rp {{ number_format($totalSales, 0, ',', '.') }}</h3>
                            <p class="text-muted mt-2 mb-0">{{ count($orders) }} Transaksi</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100 bg-white">
                        <div class="card-body text-center">
                            <h6 class="text-muted mb-2">Total Modal</h6>
                            <h3 class="mb-0">Rp {{ number_format($totalCost, 0, ',', '.') }}</h3>
                            <p class="text-muted mt-2 mb-0">HPP Produk</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100 border-warning">
                        <div class="card-body text-center">
                            <h6 class="text-muted mb-2">Total Keuntungan</h6>
                            <h3 class="mb-0 text-success">Rp {{ number_format($totalProfit, 0, ',', '.') }}</h3>
                            <p class="text-muted mt-2 mb-0">Margin
                                {{ $totalSales > 0 ? round(($totalProfit / $totalSales) * 100, 1) : 0 }}%</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h6 class="card-title mb-0">
                                <i class="bi bi-receipt me-2 text-warning"></i>
                                Detail Transaksi
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No. Invoice</th>
                                            <th>Tanggal</th>
                                            <th>Produk</th>
                                            <th class="text-end">Total</th>
                                            <th class="text-end">Modal</th>
                                            <th class="text-end">Keuntungan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            @php
                                                $orderTotal = 0;
                                                $orderCost = 0;
                                                foreach ($order->orderProducts as $item) {
                                                    $orderTotal += $item->unit_price * $item->quantity;
                                                    $orderCost += $item->product->cost_price * $item->quantity;
                                                }
                                                $orderProfit = $orderTotal - $orderCost;
                                            @endphp
                                            <tr>
                                                <td>{{ $order->invoice_number }}</td>
                                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}
                                                </td>
                                                <td>
                                                    @foreach ($order->orderProducts as $index => $item)
                                                        {{ $item->product->name }} ({{ $item->quantity }})
                                                        @if ($index < count($order->orderProducts) - 1)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="text-end">Rp
                                                    {{ number_format($orderTotal, 0, ',', '.') }}</td>
                                                <td class="text-end">Rp
                                                    {{ number_format($orderCost, 0, ',', '.') }}</td>
                                                <td class="text-end">Rp
                                                    {{ number_format($orderProfit, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach

                                        @if (count($orders) == 0)
                                            <tr>
                                                <td colspan="6" class="text-center py-3">Tidak ada transaksi
                                                    pada periode yang dipilih</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h6 class="card-title mb-0">
                                <i class="bi bi-trophy me-2 text-warning"></i>
                                Top 5 Produk Terlaris
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th class="text-center">Terjual</th>
                                            <th class="text-end">Pendapatan</th>
                                            <th class="text-end">Keuntungan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topProducts as $product)
                                            <tr>
                                                <td>{{ $product['product']->name }}</td>
                                                <td class="text-center">{{ $product['quantity'] }}</td>
                                                <td class="text-end">Rp
                                                    {{ number_format($product['sales'], 0, ',', '.') }}</td>
                                                <td class="text-end">Rp
                                                    {{ number_format($product['profit'], 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach

                                        @if (count($topProducts) == 0)
                                            <tr>
                                                <td colspan="4" class="text-center py-3">Tidak ada data
                                                    produk
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12 text-center py-5">
                <img src="{{ asset('images/report.svg') }}" alt="Report" style="width: 150px; opacity: 0.5;"
                    onerror="this.src='https://via.placeholder.com/150'; this.onerror=null;">
                <h5 class="mt-4 text-muted">Pilih Rentang Tanggal dan Klik Tampilkan Laporan</h5>
                <p class="text-muted">Data penjualan dan keuntungan akan ditampilkan di sini</p>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        let salesChart = null;
        let productPieChart = null;

        document.addEventListener('livewire:initialized', () => {
            @this.on('printReport', () => {
                const printContent = document.getElementById('printable-report');
                const printHeaders = document.querySelectorAll('.print-header');

                // Show print headers
                printHeaders.forEach(header => {
                    header.style.display = 'block';
                });

                // Create PDF
                const opt = {
                    margin: 10,
                    filename: 'laporan-penjualan-{{ \Carbon\Carbon::now()->format('dmY') }}.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 2
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'portrait'
                    }
                };

                html2pdf().set(opt).from(printContent).save().then(() => {
                    // Hide print headers after export
                    printHeaders.forEach(header => {
                        header.style.display = 'none';
                    });
                });
            });
        });

        // function initCharts() {
        //     const dailySales = @this.dailySales;
        //     const topProducts = @this.topProducts;

        //     if (!dailySales || Object.keys(dailySales).length === 0) return;

        //     // Sales Chart
        //     const salesCtx = document.getElementById('salesChart');
        //     const dates = Object.values(dailySales).map(day => day.date);
        //     const salesData = Object.values(dailySales).map(day => day.sales);
        //     const profitData = Object.values(dailySales).map(day => day.profit);

        //     if (salesChart) {
        //         salesChart.destroy();
        //     }

        //     salesChart = new Chart(salesCtx, {
        //         type: 'bar',
        //         data: {
        //             labels: dates,
        //             datasets: [{
        //                     label: 'Penjualan',
        //                     data: salesData,
        //                     backgroundColor: 'rgba(236, 166, 5, 0.7)',
        //                     borderColor: 'rgb(236, 166, 5)',
        //                     borderWidth: 1
        //                 },
        //                 {
        //                     label: 'Keuntungan',
        //                     data: profitData,
        //                     backgroundColor: 'rgba(40, 167, 69, 0.7)',
        //                     borderColor: 'rgb(40, 167, 69)',
        //                     borderWidth: 1,
        //                     type: 'line'
        //                 }
        //             ]
        //         },
        //         options: {
        //             responsive: true,
        //             maintainAspectRatio: false,
        //             scales: {
        //                 y: {
        //                     beginAtZero: true,
        //                     ticks: {
        //                         callback: function(value) {
        //                             return 'Rp ' + value.toLocaleString('id-ID');
        //                         }
        //                     }
        //                 }
        //             },
        //             plugins: {
        //                 tooltip: {
        //                     callbacks: {
        //                         label: function(context) {
        //                             return context.dataset.label + ': Rp ' + context.raw.toLocaleString(
        //                             'id-ID');
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //     });

        //     // Product Pie Chart
        //     if (topProducts && topProducts.length > 0) {
        //         const pieCtx = document.getElementById('productPieChart');
        //         const productNames = topProducts.map(p => p.product.name);
        //         const productSales = topProducts.map(p => p.sales);

        //         if (productPieChart) {
        //             productPieChart.destroy();
        //         }

        //         productPieChart = new Chart(pieCtx, {
        //             type: 'doughnut',
        //             data: {
        //                 labels: productNames,
        //                 datasets: [{
        //                     data: productSales,
        //                     backgroundColor: [
        //                         'rgba(236, 166, 5, 0.7)',
        //                         'rgba(23, 162, 184, 0.7)',
        //                         'rgba(40, 167, 69, 0.7)',
        //                         'rgba(220, 53, 69, 0.7)',
        //                         'rgba(108, 117, 125, 0.7)'
        //                     ],
        //                     borderColor: [
        //                         'rgb(236, 166, 5)',
        //                         'rgb(23, 162, 184)',
        //                         'rgb(40, 167, 69)',
        //                         'rgb(220, 53, 69)',
        //                         'rgb(108, 117, 125)'
        //                     ],
        //                     borderWidth: 1
        //                 }]
        //             },
        //             options: {
        //                 responsive: true,
        //                 maintainAspectRatio: false,
        //                 plugins: {
        //                     legend: {
        //                         position: 'bottom',
        //                         labels: {
        //                             boxWidth: 12
        //                         }
        //                     },
        //                     tooltip: {
        //                         callbacks: {
        //                             label: function(context) {
        //                                 const value = context.raw;
        //                                 const total = context.chart.data.datasets[0].data.reduce((a, b) => a +
        //                                     b, 0);
        //                                 const percentage = Math.round((value / total) * 100);
        //                                 return context.label + ': Rp ' + value.toLocaleString('id-ID') + ' (' +
        //                                     percentage + '%)';
        //                             }
        //                         }
        //                     }
        //                 }
        //             }
        //         });
        //     }
        // }

        // document.addEventListener('livewire:initialized', () => {
        //     @this.on('$refresh', () => {
        //         setTimeout(() => {
        //             if (@this.isFiltered) {
        //                 initCharts();
        //             }
        //         }, 100);
        //     });
        // });
    </script>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #printable-report,
            #printable-report * {
                visibility: visible;
            }

            #printable-report {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .chart-container {
                page-break-inside: avoid;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .text-warning {
            color: rgb(236, 166, 5) !important;
        }

        .btn-warning {
            background-color: rgb(236, 166, 5);
            border-color: rgb(236, 166, 5);
            color: white;
        }

        .btn-warning:hover {
            background-color: rgb(215, 151, 0);
            border-color: rgb(215, 151, 0);
            color: white;
        }

        .border-warning {
            border-color: rgb(236, 166, 5) !important;
        }
    </style>
@endpush
</div>
