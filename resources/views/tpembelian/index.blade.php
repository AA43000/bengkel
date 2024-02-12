@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Transaksi Pembelian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Transaksi Pembelian</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="card">
        <div class="card-header">
            <a href="{{ route('tpembelian.create') }}" class="btn btn-md btn-success mb-3">Tambah Pembelian</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Transaksi</th>
                            <th>No Pesanan</th>
                            <th>Supplier</th>
                            <th>Total Akhir</th>
                            <th>Total Bayar</th>
                            <th>Sisa Bayar</th>
                            <th>Tanggal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @forelse ($thpembelians as $thpembelian)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td><span class="text-primary" style="cursor: pointer" onclick="get_detail({{ $thpembelian->id }})">{{ $thpembelian->kode }}</span></td>
                            <td>{{ $thpembelian->no_pesanan }}</td>
                            <td>{{ $thpembelian->kode_supplier.' - '.$thpembelian->nama_supplier }}</td>
                            <td>{{ $thpembelian->total_akhir }}</td>
                            <td>{{ $thpembelian->total_bayar }}</td>
                            <td>{{ $thpembelian->sisa_bayar }}</td>
                            <td>{{ $thpembelian->tanggal }}</td>
                            <td class="project-actions text-right">
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('tpembelian.destroy', $thpembelian->id) }}" method="post">
                                    <a href="{{ route('tpembelian.edit', $thpembelian->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <div class="alert alert-danger">
                            Data pembelian belum tersedia.
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
                                <th>#</th>
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
                                <th style="text-align: right" colspan="7">Total Akhir</th>
                                <th id="total_akhir"></th>
                            </tr>
                            <tr>
                                <th style="text-align: right" colspan="7">Total Bayar</th>
                                <th id="total_bayar"></th>
                            </tr>
                            <tr>
                                <th style="text-align: right" colspan="7">Sisa Bayar</th>
                                <th id="sisa_bayar"></th>
                            </tr>
                            <tr>
                                <th style="text-align: right" colspan="7">Pembayaran</th>
                                <th id="pembayaran"></th>
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
    })
    function get_detail(idthpembelian) {
        $('.table').DataTable().destroy();
        $.ajax({
            url: '/tpembelian/get_detail/'+idthpembelian,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $("#kode_transaksi").html(data.thpembelian.kode);
                $("#total_akhir").html(data.thpembelian.total_akhir);
                $("#total_bayar").html(data.thpembelian.total_bayar);
                $("#sisa_bayar").html(data.thpembelian.sisa_bayar);
                $("#pembayaran").html(data.thpembelian.pembayaran);

                var html = '';
                var no = 1;
                for(var x=0;x<data.tdpembelian.length;x++) {
                    html += '<tr>';
                        html += '<td>'+no+'</td>';
                        html += '<td>'+data.tdpembelian[x].nama_item+'</td>';
                        html += '<td>'+(data.tdpembelian[x].pesan != null ? data.tdpembelian[x].pesan : '')+'</td>';
                        html += '<td>'+data.tdpembelian[x].qty+'</td>';
                        html += '<td>'+data.tdpembelian[x].harga+'</td>';
                        html += '<td>'+data.tdpembelian[x].subtotal+'</td>';
                        html += '<td>'+data.tdpembelian[x].potongan+'</td>';
                        html += '<td>'+data.tdpembelian[x].grand_total+'</td>';
                    html += '</tr>';
                    no++;
                }
                $("#tabel_body").html(html);
                $("#modal_detail").modal('show');
                $('.table').DataTable();
            },
            error: function(error) {
                console.log(error);
            }
        })
    }
</script>
@endsection
