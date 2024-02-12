@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Transaksi Penjualan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Transaksi Penjualan</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="card">
        <div class="card-header">
            <a href="{{ route('tpenjualan.create') }}" class="btn btn-md btn-success mb-3">Tambah Penjualan</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Pelanggan</th>
                            <th>Total Akhir</th>
                            <th>Pembayaran</th>
                            <th>Tanggal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @forelse ($thpenjualans as $thpenjualan)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td><span class="text-primary" style="cursor: pointer" onclick="get_detail({{ $thpenjualan->id }})">{{ $thpenjualan->kode }}</span></td>
                            <td>{{ ($thpenjualan->id_pelanggan != 0 ? $thpenjualan->kode_pelanggan.' - '.$thpenjualan->nama_pelanggan : 'Pelanggan Pengunjung') }}</td>
                            <td>{{ $thpenjualan->total_akhir }}</td>
                            <td>{{ $thpenjualan->pembayaran }}</td>
                            <td>{{ $thpenjualan->tanggal }}</td>
                            <td class="project-actions text-right">
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('tpenjualan.destroy', $thpenjualan->id) }}" method="post">
                                    <a href="{{ route('tpenjualan.edit', $thpenjualan->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <div class="alert alert-danger">
                            Data penjualan belum tersedia.
                        </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="modal fade" id="modal_detail">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Transaksi: <span id="kode_transaksi"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Pesan</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                                <th>Potongan(%)</th>
                                <th>Grand Total</th>
                            </tr>
                        </thead>
                        <tbody id="tabel_body">
    
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="text-align: right" colspan="6">Total Akhir</th>
                                <th id="total_akhir"></th>
                            </tr>
                            <tr>
                                <th style="text-align: right" colspan="6">Pembayaran</th>
                                <th id="pembayaran"></th>
                            </tr>
                            <tr>
                                <th style="text-align: right" colspan="6">Total bayar</th>
                                <th id="total_bayar"></th>
                            </tr>
                            <tr>
                                <th style="text-align: right" colspan="6">Kembalian</th>
                                <th id="kembalian"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>

    </div>

</section>

<script type="text/javascript">
    $(document).ready(function() {
        @if(session('idthpenjualan'))
            var next = confirm("Apakah anda ingin mencetak nota?");
            if(next) {
                window.open('/tpenjualan/print/'+{{ session('idthpenjualan') }});
            }
        @endif
    })
    function get_detail(idthpenjualan) {
        $.ajax({
            url: '/tpenjualan/get_detail/'+idthpenjualan,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $("#kode_transaksi").html(data.thpenjualan.kode);
                $("#pembayaran").html(data.thpenjualan.pembayaran);
                $("#total_bayar").html(data.thpenjualan.total_bayar);
                $("#kembalian").html(data.thpenjualan.kembalian);
                $("#total_akhir").html(data.thpenjualan.total_akhir);

                var html = '';
                var no = 1;
                for(var x=0;x<data.tdpenjualan.length;x++) {
                    html += '<tr>';
                        html += '<td>'+data.tdpenjualan[x].nama_item+'</td>';
                        html += '<td>'+(data.tdpenjualan[x].pesan != null ? data.tdpenjualan[x].pesan : '')+'</td>';
                        html += '<td>'+data.tdpenjualan[x].qty+'</td>';
                        html += '<td>'+data.tdpenjualan[x].harga+'</td>';
                        html += '<td>'+data.tdpenjualan[x].subtotal+'</td>';
                        html += '<td>'+data.tdpenjualan[x].potongan+'</td>';
                        html += '<td>'+data.tdpenjualan[x].grand_total+'</td>';
                    html += '</tr>';
                    no++;
                }
                $("#tabel_body").html(html);
                $("#modal_detail").modal('show');
            },
            error: function(error) {
                console.log(error);
            }
        })
    }
</script>
@endsection
