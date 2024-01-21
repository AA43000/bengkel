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
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Supplier</th>
                        <th>Total</th>
                        <th>Potongan</th>
                        <th>Total Akhir</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($thpembelians as $thpembelian)
                    <tr>
                        <td>#</td>
                        <td><span class="text-primary" style="cursor: pointer" onclick="get_detail({{ $thpembelian->id }})">{{ $thpembelian->kode }}</span></td>
                        <td>{{ $thpembelian->kode_supplier.' - '.$thpembelian->nama_supplier }}</td>
                        <td>{{ $thpembelian->total }}</td>
                        <td>{{ $thpembelian->potongan }}</td>
                        <td>{{ $thpembelian->total_akhir }}</td>
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
            {{ $thpembelians->links() }}
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
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Produk</th>
                            <th>Pesan</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="tabel_body">

                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="text-align: right" colspan="5">Total</th>
                            <th id="total"></th>
                        </tr>
                        <tr>
                            <th style="text-align: right" colspan="5">Potongan</th>
                            <th id="potongan"></th>
                        </tr>
                        <tr>
                            <th style="text-align: right" colspan="5">Total Akhir</th>
                            <th id="total_akhir"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>

    </div>

</section>

<script type="text/javascript">
    function get_detail(idthpembelian) {
        $.ajax({
            url: '/tpembelian/get_detail/'+idthpembelian,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $("#kode_transaksi").html(data.thpembelian.kode);
                $("#total").html(data.thpembelian.total);
                $("#potongan").html(data.thpembelian.potongan);
                $("#total_akhir").html(data.thpembelian.total_akhir);

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
