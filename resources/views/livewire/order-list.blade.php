<div class="mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Daftar Order</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Penjualan</h5>
                        <p class="card-text fs-4">
                            {{ $totalPriceFormatted }}

                        </p>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Transaksi</h5>
                        <p class="card-text fs-4">
                            {{ $totalTransactions }} Transaksi
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center mt-3 mb-3">
                        <!-- Kolom input pencarian -->
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input wire:model.live.debounce.300ms='search' type="text" class="form-control" placeholder="Search"
                                    aria-label="Search" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <!-- Kolom tombol hapus -->
                        <div class="col-md-4 text-end">
                            <button wire:click="deleteTodayOrders" class="btn btn-danger"
                                onclick="return confirm('Yakin ingin menghapus semua order hari ini?')">
                                <i class="bi bi-trash"></i> Hapus Order Hari Ini
                            </button>
                        </div>
                    </div>


                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Order Code</th>
                                    <th scope="col">Waktu Selesai</th>
                                    <th scope="col">Penjualan</th>
                                    <th scope="col">Struk</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $item)
                                <tr>

                                    <td>{{$item->invoice_number}}</td>
                                    <td>{{$item->done_at_for_human}}</td>
                                    <td>{{$item->total_price_formatted}}</td>
                                    <td>
                                        <a href="{{ route('order.receipt', $item->id) }}" target="_blank" class="btn btn-primary">
                                            <i class="bi bi-printer"></i> Print
                                    </td>



                                </tr>
                                @endforeach
                                <!-- Data rows here -->
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <label class="form-label">Per Page</label>
                            <select
                                wire:model.live='perPage'
                                class="form-select">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="col-md-11">
                            {{$orders->links('pagination::bootstrap-5')}}
                        </div>
                    </div>
                    <!-- Pagination here -->
                </div>
            </div>
        </div>
    </div>
</div>