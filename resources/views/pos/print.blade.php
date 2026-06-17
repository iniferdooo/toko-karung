<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Struk #{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            line-height: 1.4;
            width: 72mm;
            margin: 0 auto;
            padding: 10px;
            background: white;
            color: black;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .flex { display: flex; justify-content: space-between; }
        .divider { border-top: 1px dashed #000; margin: 8px 0; }
        .font-bold { font-weight: bold; }
        @media print {
            body { 
                margin: 0; 
                padding: 0; 
                width: 72mm; 
            }
        }
    </style>
</head>
<body>
    <div class="text-center">
        <div style="font-weight: bold; font-size: 13px; letter-spacing: 1px; text-transform: uppercase;">TOKO KARUNG G</div>
        <div style="font-size: 9px; color: #555; margin-top: 2px;">Grosir & Eceran Karung</div>
        <div style="font-size: 9px; color: #555;">Telp: 0812-3456-7890</div>
    </div>

    <div class="divider"></div>

    <div style="font-size: 9px;">
        <div class="flex"><span>No Struk:</span><span class="font-bold">#{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</span></div>
        <div class="flex"><span>Tanggal:</span><span>{{ $sale->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}</span></div>
        <div class="flex"><span>Pelanggan:</span><span>{{ $sale->customer->name ?? 'Umum' }}</span></div>
    </div>

    <div class="divider"></div>

    @php $rawSub = 0; @endphp
    @foreach($sale->items as $item)
        @php $line = $item->unit_price * $item->quantity; $rawSub += $line; @endphp
        <div style="font-size: 9px; margin-bottom: 6px;">
            <div class="font-bold" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $item->product->name ?? 'Produk Dihapus' }}</div>
            <div class="flex" style="color: #333; margin-top: 1px;">
                <span>{{ number_format($item->unit_price, 0, ',', '.') }} x{{ $item->quantity }}</span>
                <span class="font-bold text-right" style="color: #000;">{{ number_format($line, 0, ',', '.') }}</span>
            </div>
        </div>
    @endforeach

    <div class="divider"></div>

    <div style="font-size: 9px;">
        <div class="flex"><span>Subtotal:</span><span>{{ number_format($rawSub, 0, ',', '.') }}</span></div>
        @if($sale->discount > 0)
            <div class="flex font-bold" style="color: #000;"><span>Diskon:</span><span>-{{ number_format($sale->discount, 0, ',', '.') }}</span></div>
        @endif
        <div class="flex font-bold" style="font-size: 11px; border-top: 1px dotted #ccc; padding-top: 4px; margin-top: 4px;">
            <span>TOTAL:</span><span>Rp{{ number_format($sale->total_amount, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="divider"></div>
    <div class="text-center" style="font-size: 9px; color: #333; margin-top: 4px;">
        <div class="font-bold" style="color: #000; margin-bottom: 2px;">*** TERIMA KASIH ***</div>
        <div>Barang tidak dapat dikembalikan</div>
    </div>

    <script>
        window.onload = function() {
            window.print();
            window.onafterprint = function() {
                window.close();
            };
            setTimeout(function() {
                window.close();
            }, 10000);
        }
    </script>
</body>
</html>
