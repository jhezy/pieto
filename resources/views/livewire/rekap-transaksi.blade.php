<div class="mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Rekap Transaksi</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Rekap Harian Transaksi</h5>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Jumlah Transaksi</th>
                            <th>Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekap as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                            <td>{{ $item->jumlah_transaksi }}</td>
                            <td>Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}</td>

                        </tr>

                        @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>