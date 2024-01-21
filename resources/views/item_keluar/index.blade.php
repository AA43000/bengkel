@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Daftar Item Keluar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Daftar Item Keluar</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="card">
        <div class="card-header">
            <a href="{{ route('item_keluar.create') }}" class="btn btn-md btn-success mb-3">Tambah Item Keluar</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Keterangan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($thitemkeluars as $thitemkeluar)
                    <tr>
                        <td>#</td>
                        <td><span class="text-primary" style="cursor: pointer" onclick="get_detail({{ $thitemkeluar->id }})">{{ $thitemkeluar->kode }}</span></td>
                        <td>{{ $thitemkeluar->tanggal }}</td>
                        <td>{{ $thitemkeluar->total }}</td>
                        <td>{{ $thitemkeluar->keterangan }}</td>
                        <td class="project-actions text-right">
                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('item_keluar.destroy', $thitemkeluar->id) }}" method="post">
                                <a href="{{ route('item_keluar.edit', $thitemkeluar->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <div class="alert alert-danger">
                        Data item keluar belum tersedia.
                    </div>
                    @endforelse
                </tbody>
            </table>
            {{ $thitemkeluars->links() }}
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
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="tabel_body">

                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="text-align: right" colspan="4">Total</th>
                            <th id="total"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>

    </div>

</section>

<script type="text/javascript">
    function get_detail(idthitemkeluar) {
        $.ajax({
            url: '/item_keluar/get_detail/'+idthitemkeluar,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $("#kode_transaksi").html(data.thitemkeluar.kode);
                $("#total").html(data.thitemkeluar.total);

                var html = '';
                var no = 1;
                for(var x=0;x<data.tditemkeluar.length;x++) {
                    html += '<tr>';
                        html += '<td>'+no+'</td>';
                        html += '<td>'+data.tditemkeluar[x].nama_item+'</td>';
                        html += '<td>'+data.tditemkeluar[x].qty+'</td>';
                        html += '<td>'+data.tditemkeluar[x].harga+'</td>';
                        html += '<td>'+data.tditemkeluar[x].subtotal+'</td>';
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
