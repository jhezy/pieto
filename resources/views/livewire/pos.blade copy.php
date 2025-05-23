<div class="row mt-4 mb-4">
    <!-- Bagian Produk -->
    <div class="col-lg-8">
        <!-- Search -->
        <div class="mb-3">
            <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="Cari produk...">
        </div>

        <!-- Daftar Produk -->
        <div class="row">
            @forelse ($products as $item)
            <div wire:click="updateCart('{{ $item->id }}')" class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card product-card h-100 border-0 shadow-sm rounded-4">
                    <div class="position-relative">
                        <img src="{{ Str::startsWith($item->image, ['http://', 'https://']) ? $item->image : asset('/storage/product/' . $item->image) }}"
                            class="card-img-top rounded-top-4" alt="{{ $item->name }}"
                            style="height: 150px; object-fit: cover;">
                    </div>
                    <div class="card-body text-center">
                        <h6 class="card-title mb-1 text-truncate" title="{{ $item->name }}">{{ $item->name }}</h6>
                        <div class="text-primary fw-bold">{{ $item->selling_price_formatted }}</div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">Produk masih kosong</div>
            </div>
            @endforelse
        </div>


        <!-- Pagination -->
        <div class="mt-3">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Bagian Keranjang -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white text-center fw-bold">
                {{ $order ? 'Order Code : ' . $order->invoice_number : 'Aplikasi Kasir' }}
            </div>

            <div class="card-body">
                @if (session()->has('message'))
                <div class="alert alert-success text-center">{{ session('message') }}</div>
                @endif

                @if ($order)
                @foreach ($order->orderProducts as $item)
                <div class="d-flex align-items-center mb-3 p-2 border rounded">
                    <img src="{{ Str::startsWith($item->product->image, ['http://', 'https://']) ? $item->product->image : asset('/storage/product/' . $item->product->image) }}"
                        width="60" height="60" class="rounded me-2" style="object-fit: cover;">
                    <div class="flex-grow-1">
                        <div>{{ $item->product->name }}</div>
                        <small class="text-muted">{{ $item->product->selling_price_formatted }}</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm btn-outline-secondary me-2"
                            wire:click="updateCart('{{ $item->product->id }}', false)">−</button>
                        <span>{{ $item->quantity }}</span>
                        <button class="btn btn-sm btn-outline-primary ms-2"
                            wire:click="updateCart('{{ $item->product->id }}')">+</button>
                    </div>
                </div>
                @endforeach
                @else
                @if(count($products) > 0)
                <div class="text-center">
                    <p>Keranjang masih kosong</p>
                    <button wire:click="createOrder()" class="btn btn-warning text-light w-100">Mulai Transaksi</button>
                </div>
                @endif
                @endif

                @if ($total_price != 0)
                <h5 class="text-center mt-4">Total: Rp {{ number_format($total_price, 0, ',', '.') }}</h5>
                @endif
            </div>

            @if($order)
            <div class="card-footer bg-white text-center">
                <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">Pembayaran</button>
            </div>
            @endif
        </div>
    </div>

    <!-- Modal Pembayaran -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- ukuran lebih besar -->
            <div class="modal-content border-0 rounded">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="paid_amount" class="form-label">Uang yang dibayarkan</label>
                        <input type="number" class="form-control" id="paid_amount" wire:model.debounce.300ms="paid_amount" placeholder="Masukkan nominal">
                        @error('paid_amount')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <form wire:submit.prevent="done" id="payment-form">


                        <!-- Tampilkan daftar item -->
                        @if ($order)
                        <hr>
                        <h6>Rincian Pesanan</h6>
                        <ul class="list-group mb-3">
                            @foreach ($order->orderProducts as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    {{ $item->product->name }} <br>
                                    <small>{{ $item->quantity }} x {{ $item->product->selling_price_formatted }}</small>
                                </div>
                                <span>Rp {{ number_format($item->quantity*$item->unit_price, 0, ',', '.') }}</span>
                            </li>
                            @endforeach
                        </ul>
                        <div class="d-flex justify-content-between">
                            <span><strong>Total:</strong></span>
                            <span><strong>Rp {{ number_format($total_price, 0, ',', '.') }}</strong></span>
                            <!-- <span><strong>Rp {{ $total_price }}</strong></span> -->
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><strong>Dibayar:</strong></span>
                            <span>Rp {{ number_format($paid_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span><strong>Kembalian:</strong></span>
                            <span>Rp {{ $change }}</span>
                        </div>
                        @endif

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100" onclick="printReceipt()">Simpan Pembayaran</button>
                            <button type="button" class="btn btn-outline-success" onclick="printReceipt()">Cetak Struk</button>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Area Struk (Hidden Print Area) -->
    <div class="printArea" id="printArea" style="display: none; width: 3.5in; height: 6in; padding: 10px; font-size: 12px;">
        <div class="header">
            <!-- <img src="../img/pieto.png" alt="Logo Kedai Pieto" style="width: 80px; margin-bottom: 8px;" /> -->
            <h1>KEDAI PIETO</h1>
            <p>Jl. Pabian No. 123, Sumenep</p>
            <p>Telp: 0812-3456-7890</p>
        </div>

        <hr class="separator" />

        <p>No. Struk: {{ $order->invoice_number }}<br />
            Transaksi: {{ $order->done_at_for_human }}</p>

        <hr class="separator" />

        <table>
            @foreach ($order->orderProducts as $item)
            <tr>
                <td class="product-name" colspan="2">{{ $item->product->name }}</td>
            </tr>
            <tr>
                <td class="qty-left quantity-price">{{ $item->quantity }} x
                    {{ number_format($item->unit_price, 0, ',', '.') }}
                </td>
                <td class="price-right">Rp
                    {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </table>

        <hr class="double-separator" />

        <table class="totals" style="width: 100%; font-weight: bold; font-size: 13px;">
            <tr>
                <td class="total-highlight">Total</td>
                <td style="text-align: right;" class="total-highlight">Rp
                    {{ number_format($order->total_price, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td>Dibayar</td>
                <td style="text-align: right;">Rp {{ number_format($order->paid_amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Kembalian</td>
                <td style="text-align: right;">Rp
                    {{ number_format($order->paid_amount - $order->total_price, 0, ',', '.') }}
                </td>
            </tr>
        </table>

        <hr class="separator" />

        <div class="footer">
            --- Terima kasih ---<br />
            Selamat Menikmati <br />
            --- = --- <br />
            <b>WIFI: Kedai Pieto<br />Password: hurufbesar</b>
        </div>
    </div>



    @push('scripts')
    <!-- Load html2pdf.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function printReceipt() {
            const element = document.getElementById("printArea");
            if (!element) return alert("Struk belum tersedia!");

            element.style.display = "block";

            setTimeout(() => {
                const opt = {
                    margin: 0.3,
                    filename: 'struk-pembayaran.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 2
                    },
                    jsPDF: {
                        unit: 'in',
                        format: 'A5',
                        orientation: 'portrait'
                    }
                };

                html2pdf().set(opt).from(element).save().then(() => {
                    element.style.display = "none";
                });
            }, 300);
        }
    </script>



    @endpush