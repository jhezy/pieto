<div class="daily-summary">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h5>
                    <i class="bi bi-calendar-check me-2 text-warning"></i>
                    Ringkasan Hari Ini ({{ \Carbon\Carbon::now()->format('d F Y') }})
                </h5>
                <button wire:click="refresh" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise me-1"></i> Refresh
                </button>
            </div>
            <hr>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm h-100 bg-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted mb-1">Transaksi</h6>
                            <h3 class="mb-0">{{ $todayTransactions }}</h3>
                        </div>
                        <div class="icon-bg bg-light-warning">
                            <i class="bi bi-receipt text-warning"></i>
                        </div>
                    </div>
                    <div class="mt-2 small text-muted">Jumlah order hari ini</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm h-100 bg-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted mb-1">Produk Terjual</h6>
                            <h3 class="mb-0">{{ $todaySoldItems }}</h3>
                        </div>
                        <div class="icon-bg bg-light-primary">
                            <i class="bi bi-box-seam text-primary"></i>
                        </div>
                    </div>
                    <div class="mt-2 small text-muted">Item yang terjual hari ini</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm h-100 bg-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted mb-1">Pendapatan</h6>
                            <h3 class="mb-0">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h3>
                        </div>
                        <div class="icon-bg bg-light-info">
                            <i class="bi bi-cash-stack text-info"></i>
                        </div>
                    </div>
                    <div class="mt-2 small text-muted">Total penjualan hari ini</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm h-100 bg-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted mb-1">Keuntungan</h6>
                            <h3 class="mb-0">Rp {{ number_format($todayProfit, 0, ',', '.') }}</h3>
                        </div>
                        <div class="icon-bg bg-light-success">
                            <i class="bi bi-graph-up-arrow text-success"></i>
                        </div>
                    </div>
                    <div class="mt-2 small text-muted">Profit bersih hari ini</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="bi bi-list-check me-2 text-warning"></i>
                        Transaksi Hari Ini
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Invoice</th>
                                    <th>Waktu</th>
                                    <th>Produk</th>
                                    <th class="text-end">Total</th>
                                    <th class="text-end">Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                    <tr>
                                        <td>
                                            <span class="fw-medium">{{ $transaction['invoice'] }}</span>
                                        </td>
                                        <td>{{ $transaction['time'] }}</td>
                                        <td>
                                            <div class="transaction-products">
                                                @foreach ($transaction['products'] as $index => $product)
                                                    <span class="product-item">
                                                        {{ $product['name'] }} ({{ $product['quantity'] }})
                                                    </span>
                                                    @if ($index < count($transaction['products']) - 1)
                                                        <span class="separator">&bull;</span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="text-end">Rp
                                            {{ number_format($transaction['revenue'], 0, ',', '.') }}</td>
                                        <td class="text-end">Rp
                                            {{ number_format($transaction['profit'], 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <img src="{{ asset('images/empty-transaction.svg') }}"
                                                alt="No Transactions" style="width: 80px; opacity: 0.5;"
                                                onerror="this.src='https://via.placeholder.com/80'; this.onerror=null;">
                                            <p class="mt-3 text-muted">Belum ada transaksi hari ini</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .icon-bg {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-bg i {
            font-size: 1.5rem;
        }

        .bg-light-warning {
            background-color: rgba(236, 166, 5, 0.15);
        }

        .bg-light-primary {
            background-color: rgba(13, 110, 253, 0.15);
        }

        .bg-light-info {
            background-color: rgba(13, 202, 240, 0.15);
        }

        .bg-light-success {
            background-color: rgba(25, 135, 84, 0.15);
        }

        .transaction-products {
            max-width: 400px;
            white-space: normal;
        }

        .product-item {
            display: inline-block;
            color: #495057;
        }

        .separator {
            display: inline-block;
            margin: 0 4px;
            color: #adb5bd;
        }

        @media (max-width: 767.98px) {
            .transaction-products {
                max-width: 200px;
            }
        }
    </style>
</div>
