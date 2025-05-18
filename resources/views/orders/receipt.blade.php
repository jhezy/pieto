<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px;
            background: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .receipt {
            width: 320px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border: 1px dashed #aaa;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            letter-spacing: 1px;
        }

        .header p {
            margin: 2px 0;
            font-size: 11px;
            color: #555;
        }

        .separator,
        .double-separator {
            margin: 10px 0;
            border: none;
        }

        .separator {
            border-top: 1px dashed #444;
        }

        .double-separator {
            border-top: 2px solid #000;
        }

        table {
            width: 100%;
            font-size: 13px;
            border-collapse: collapse;
        }

        td {
            padding: 2px 0;
        }

        .product-name {
            font-weight: bold;
            padding-bottom: 0;
        }

        .quantity-price {
            font-size: 12px;
            color: #555;
        }

        .qty-left {
            text-align: left;
            vertical-align: top;
        }

        .price-right {
            text-align: right;
            vertical-align: top;
            white-space: nowrap;
            font-weight: normal;
            color: #000;
        }

        .totals td {
            font-weight: bold;
        }

        .total-highlight {
            font-size: 16px;
            color: #000;
        }

        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 12px;
            color: #444;
        }

        .footer b {
            display: block;
            margin-top: 6px;
        }
    </style>
</head>

<body>
    <div class="receipt">
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

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>