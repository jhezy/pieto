<div class="pos-container">
    <div class="row mt-4 mb-4">
        <!-- Bagian Produk -->
        <div class="col-lg-8">
            <!-- Search -->
            <div class="mb-4">
                <div class="search-container">
                    <i class="bi bi-search search-icon"></i>
                    <input wire:model.live.debounce.300ms="search" type="text" class="form-control search-input"
                        placeholder="Cari produk...">
                </div>
            </div>

            <!-- Daftar Produk -->
            <div class="row product-grid">
                @forelse ($products as $item)
                    <div wire:click="updateCart('{{ $item->id }}')"
                        class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="product-card card h-100 border-0 shadow-sm">
                            <div class="position-relative product-img-container">
                                <img src="{{ Str::startsWith($item->image, ['http://', 'https://']) ? $item->image : asset('/storage/product/' . $item->image) }}"
                                    class="card-img-top" alt="{{ $item->name }}">
                                <div class="product-overlay">
                                    <span class="add-to-cart"><i class="bi bi-plus-circle"></i></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="product-title" title="{{ $item->name }}">{{ $item->name }}</h6>
                                <div class="product-price">{{ $item->selling_price_formatted }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-products">
                            <i class="bi bi-basket"></i>
                            <p>Produk masih kosong</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-4 pagination-container">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <!-- Bagian Keranjang -->
        <div class="col-lg-4">
            <div class="cart-container card border-0 shadow h-100">
                <div class="card-header">
                    <h5 class="mb-0 text-center">
                        @if ($order)
                            <i class="bi bi-receipt me-2"></i>{{ $order->invoice_number }}
                        @else
                            <i class="bi bi-cart me-2"></i>Keranjang Belanja
                        @endif
                    </h5>
                </div>

                <div class="card-body cart-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($order)
                        <div class="cart-items">
                            @foreach ($order->orderProducts as $item)
                                <div class="cart-item">
                                    <div class="cart-item-img">
                                        <img src="{{ Str::startsWith($item->product->image, ['http://', 'https://']) ? $item->product->image : asset('/storage/product/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}">
                                    </div>
                                    <div class="cart-item-details">
                                        <h6>{{ $item->product->name }}</h6>
                                        <span class="price">{{ $item->product->selling_price_formatted }}</span>
                                    </div>
                                    <div class="cart-item-quantity">
                                        <button class="btn-quantity decrease"
                                            wire:click="updateCart('{{ $item->product->id }}', false)">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <span class="quantity">{{ $item->quantity }}</span>
                                        <button class="btn-quantity increase"
                                            wire:click="updateCart('{{ $item->product->id }}')">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-cart">
                            @if (count($products) > 0)
                                <div class="text-center">
                                    <i class="bi bi-cart-plus"></i>
                                    <p>Keranjang masih kosong</p>
                                    <button wire:click="createOrder()" class="btn btn-primary w-100">
                                        <i class="bi bi-plus-circle me-2"></i>Mulai Transaksi
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                @if ($total_price != 0)
                    <div class="cart-total">
                        <span>Total</span>
                        <span class="total-price">Rp {{ number_format($total_price, 0, ',', '.') }}</span>
                    </div>
                @endif

                @if ($order)
                    <div class="card-footer">
                        <button class="btn btn-pay w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="bi bi-cash me-2"></i>Pembayaran
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Pembayaran -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">
                        <i class="bi bi-credit-card me-2"></i>Pembayaran
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="payment-form">
                        <div class="mb-4">
                            <label for="paid_amount" class="form-label">Uang yang dibayarkan</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control form-control-lg" id="paid_amount"
                                    wire:model.debounce.300ms="paid_amount" placeholder="Masukkan nominal">
                            </div>
                            @error('paid_amount')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <form wire:submit.prevent="done" id="payment-form">
                            <!-- Tampilkan daftar item -->
                            @if ($order)
                                <div class="order-details">
                                    <h6 class="section-title">
                                        <i class="bi bi-list-check me-2"></i>Rincian Pesanan
                                    </h6>
                                    <div class="order-items">
                                        @foreach ($order->orderProducts as $item)
                                            <div class="order-item">
                                                <div class="item-info">
                                                    <span class="item-name">{{ $item->product->name }}</span>
                                                    <span class="item-quantity">{{ $item->quantity }} x
                                                        {{ $item->product->selling_price_formatted }}</span>
                                                </div>
                                                <span class="item-total">Rp
                                                    {{ number_format($item->quantity * $item->unit_price, 0, ',', '.') }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="order-total">
                                        <span>Total</span>
                                        <span class="total-amount">Rp
                                            {{ number_format($total_price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endif

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary btn-lg w-100" onclick="printReceipt()">
                                    <i class="bi bi-check-circle me-2"></i>Simpan Pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Sukses -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-body text-center py-4">
                    <div class="success-icon mb-3">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h5 class="mb-3">Pembayaran Berhasil!</h5>
                    <p class="mb-0">Mengalihkan dalam 3 detik...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Area Struk (Hidden Print Area) -->
    <div id="printArea"
        style="display: none; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; width: 300px; margin: 0 auto; padding: 20px; background: white; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 8px;">
        <div class="text-center" style="border-bottom: 2px solid #333; padding-bottom: 10px;">
            <h2 style="font-weight: 700; margin: 0;">KEDAI PIETO</h2>
            <p style="font-size: 12px; margin: 2px 0;">Jl. DR. Cipto, Mastasek, Pabian,Sumenep,</p>
            <p style="font-size: 12px; margin: 2px 0;">Telp: (081) 913 680 800</p>
        </div>

        <h3 style="text-align: center; margin: 20px 0 10px 0; font-weight: 600;">Struk Pembayaran</h3>

        @if ($order)
            <p style="font-size: 14px; margin: 8px 0;"><strong>Invoice:</strong> {{ $order->invoice_number }}</p>

            <div style="border-top: 1px dashed #999; border-bottom: 1px dashed #999; padding: 10px 0;">
                @foreach ($order->orderProducts as $item)
                    <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 8px;">
                        <div>
                            {{ $item->product->name }}<br>
                            <small style="color: #666;">{{ $item->quantity }} x Rp
                                {{ number_format($item->product->selling_price, 0, ',', '.') }}</small>
                        </div>
                        <div style="font-weight: 600;">
                            Rp {{ number_format($item->quantity * $item->unit_price, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 12px; font-size: 14px;">
                <div
                    style="display: flex; justify-content: space-between; font-weight: 700; border-top: 2px solid #333; padding-top: 8px;">
                    <span>Total</span>
                    <span>Rp {{ number_format($total_price, 0, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-top: 4px;">
                    <span>Dibayar</span>
                    <span>Rp {{ number_format($paid_amount, 0, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-top: 4px;">
                    <span>Kembalian</span>
                    <span>Rp {{ number_format($change, 0, ',', '.') }}</span>
                </div>
            </div>

            <p style="text-align: center; margin-top: 30px; font-weight: 600; font-size: 14px;">Terima kasih atas
                kunjungan Anda!</p>
        @endif
    </div>

    @push('scripts')
        <!-- Load html2pdf.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
        <script>
            function printReceipt() {
                const element = document.getElementById("printArea");
                element.style.display = "block"; // tampilkan area sebelum print

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
                    element.style.display = "none"; // sembunyikan kembali setelah print
                });
            }

            window.addEventListener('payment-successful', function() {
                // Tampilkan modal
                const modal = new bootstrap.Modal(document.getElementById('successModal'));
                modal.show();

                // Redirect setelah 3 detik
                setTimeout(function() {
                    window.location.href = "{{ route('order') }}";
                }, 3000);
            });
        </script>
    @endpush

    <style>
        /* General Styles */
        .pos-container {
            font-family: 'Montserrat', sans-serif;
        }

        /* Search Bar */
        .search-container {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
            z-index: 10;
        }

        .search-input {
            border-radius: 50px;
            padding-left: 40px;
            height: 50px;
            font-size: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #e9ecef;
        }

        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(236, 166, 5, 0.25);
            border-color: #ECA605;
        }

        /* Product Grid */
        .product-grid {
            margin-right: -10px;
            margin-left: -10px;
        }

        .product-grid>div {
            padding-right: 10px;
            padding-left: 10px;
        }

        .product-card {
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .product-img-container {
            height: 160px;
            overflow: hidden;
        }

        .product-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-img-container img {
            transform: scale(1.05);
        }

        .product-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .product-card:hover .product-overlay {
            opacity: 1;
        }

        .add-to-cart {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ECA605;
            font-size: 20px;
            transform: translateY(20px);
            transition: all 0.3s ease;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        .product-card:hover .add-to-cart {
            transform: translateY(0);
        }

        .product-title {
            font-weight: 600;
            color: #212529;
            margin-bottom: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-price {
            font-weight: 700;
            color: #ECA605;
            font-size: 16px;
        }

        .empty-products {
            text-align: center;
            padding: 40px 20px;
            background: #f8f9fa;
            border-radius: 10px;
            margin: 20px 0;
        }

        .empty-products i {
            font-size: 40px;
            color: #dee2e6;
            margin-bottom: 15px;
        }

        .empty-products p {
            color: #6c757d;
            margin-bottom: 0;
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: center;
        }

        /* Cart Section */
        .cart-container {
            border-radius: 15px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .cart-container .card-header {
            background-color: #ECA605;
            color: white;
            padding: 15px;
            border: none;
        }

        .cart-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .empty-cart {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 200px;
            text-align: center;
        }

        .empty-cart i {
            font-size: 40px;
            color: #dee2e6;
            margin-bottom: 15px;
        }

        .empty-cart p {
            color: #6c757d;
            margin-bottom: 20px;
        }

        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 10px;
            transition: transform 0.2s ease;
        }

        .cart-item:hover {
            transform: translateX(5px);
            background-color: #f1f3f5;
        }

        .cart-item-img {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            overflow: hidden;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .cart-item-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-details h6 {
            margin: 0;
            font-weight: 600;
            font-size: 14px;
        }

        .cart-item-details .price {
            color: #495057;
            font-size: 13px;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-quantity {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: none;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-quantity.decrease {
            background-color: #f8f9fa;
            color: #495057;
        }

        .btn-quantity.increase {
            background-color: #ECA605;
            color: white;
        }

        .btn-quantity:hover {
            transform: scale(1.1);
        }

        .quantity {
            font-weight: 600;
            width: 20px;
            text-align: center;
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .total-price {
            color: #ECA605;
            font-size: 18px;
        }

        .cart-container .card-footer {
            background-color: white;
            padding: 15px 20px;
            border: none;
        }

        .btn-pay {
            background-color: #28a745;
            color: white;
            border-radius: 50px;
            height: 50px;
            font-weight: 600;
            font-size: 16px;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-pay:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eaeaea;
        }

        .payment-form {
            padding: 10px;
        }

        .section-title {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            color: #495057;
        }

        .order-details {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .order-items {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 20px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            padding-bottom: 10px;
            border-bottom: 1px dashed #dee2e6;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-info {
            display: flex;
            flex-direction: column;
        }

        .item-name {
            font-weight: 600;
        }

        .item-quantity {
            font-size: 13px;
            color: #6c757d;
        }

        .item-total {
            font-weight: 600;
        }

        .order-total {
            display: flex;
            justify-content: space-between;
            padding-top: 15px;
            border-top: 2px solid #dee2e6;
            font-weight: 700;
            font-size: 18px;
        }

        .total-amount {
            color: #ECA605;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }

        /* Success Modal */
        .success-icon {
            font-size: 60px;
            color: #28a745;
        }
    </style>
</div>
