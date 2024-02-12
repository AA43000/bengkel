<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stuk Pembayaran</title>
    <style>
        body {
            font-family: monospace; /* Font yang cocok untuk printer thermal */
            font-size: 12px; /* Ukuran font yang sesuai */
        }
        .container {
            /* width: 280px; /* Lebar maksimum untuk printer thermal */
            margin: 0 auto; */
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .content {
            margin-bottom: 10px;
        }
        .footer {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <p>{{ $app->nama }}</p>
            <p>{{ $app->alamat }}</p>
            <p>{{ $app->telephone }}</p>
            <p>Tanggal: 08/02/2024</p>
            <p>Nama Pelanggan: {{ ($thpenjualan->id_pelanggan != 0 ? $thpenjualan->nama : 'Pelanggan Pengunjung') }}</p>
            <p>Alamat Pelanggan: {{ ($thpenjualan->id_pelanggan != 0 ? $thpenjualan->alamat : '') }}</p>
            <p>Telephone Pelanggan: {{ ($thpenjualan->id_pelanggan != 0 ? $thpenjualan->telephone : '') }}</p>
            <p>No : {{ $thpenjualan->kode.' '.date("d/m/y").' '.date("h:i:s") }}</p>
            <p>Kasir : {{ auth()->user()->name }}</p>
            -------------------------------------------------
            <table width="100%">
                @php
                    $total = 0;
                    $potongan = 0;
                @endphp
                @foreach ($tdpenjualan as $row)
                    @php
                        $total += $row->subtotal;
                        $potongan += ($row->subtotal - $row->grand_total);
                    @endphp
                   <tr>
                        <td colspan="2">{{ $row->kode_item }}</td>
                        <td colspan="2">{{ $row->nama_item }}</td>
                   </tr> 
                   <tr>
                        <td>{{ $row->qty }}</td>
                        <td>x</td>
                        <td>{{ number_format($row->harga) }}</td>
                        <td>{{ number_format($row->subtotal) }}</td>
                   </tr>
                @endforeach
            </table>
            -------------------------------------------------
            <table width="100%">
                <tr>
                    <td>Total</td>
                    <td>=</td>
                    <td style="text-align: right">{{ number_format($total) }}</td>
                </tr>
                <tr>
                    <td>Potongan</td>
                    <td>=</td>
                    <td style="text-align: right">{{ number_format($potongan) }}</td>
                </tr>
                <tr>
                    <td>Total Akhir</td>
                    <td>=</td>
                    <td style="text-align: right">{{ number_format($thpenjualan->total_akhir) }}</td>
                </tr>
                <tr>
                    <td>Bayar / DP</td>
                    <td></td>
                    <td style="text-align: right">{{ number_format($thpenjualan->total_bayar) }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>------------------</td>
                </tr>
                <tr>
                    <td>Kembali</td>
                    <td>=</td>
                    <td style="text-align: right">{{ number_format($thpenjualan->kembalian) }}</td>
                </tr>
                <tr>
                    <td>Cara Bayar</td>
                    <td>=</td>
                    <td>{{ $thpenjualan->pembayaran }}</td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <p>Barang dibeli tidak dapat dikembalikan <br> //GARANSI SERVICE 1 MINGGU//</p>
        </div>
    </div>
    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>
