@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Transaksi Tukar Tambah</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Transaksi Tukar Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="card">
        <div class="card-header">
            <a href="{{ route('tukartambah.create') }}" class="btn btn-md btn-success mb-3">Tambah Tukar Tambah</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($thtukartambahs as $thtukartambah)
                    <tr>
                        <td>#</td>
                        <td><span class="text-primary" style="cursor: pointer" onclick="get_detail({{ $thtukartambah->id }})">{{ $thtukartambah->kode }}</span></td>
                        <td>{{ $thtukartambah->kode_pelanggan.' - '.$thtukartambah->nama_pelanggan }}</td>
                        <td>{{ $thtukartambah->total }}</td>
                        <td>{{ $thtukartambah->tanggal }}</td>
                        <td class="project-actions text-right">
                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('tukartambah.destroy', $thtukartambah->id) }}" method="post">
                                <a href="{{ route('tukartambah.edit', $thtukartambah->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <div class="alert alert-danger">
                        Data tukartambah belum tersedia.
                    </div>
                    @endforelse
                </tbody>
            </table>
            {{ $thtukartambahs->links() }}
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
                            <th>Potongan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="tabel_body">

                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="text-align: right" colspan="6">Total</th>
                            <th id="total"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>

    </div>

</section>

<script type="text/javascript">
    function get_detail(idthtukartambah) {
        $.ajax({
            url: '/tukartambah/get_detail/'+idthtukartambah,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $("#kode_transaksi").html(data.thtukartambah.kode);
                $("#total").html(data.thtukartambah.total);

                var html = '';
                var no = 1;
                for(var x=0;x<data.tdtukartambah.length;x++) {
                    html += '<tr>';
                        html += '<td>'+no+'</td>';
                        html += '<td>'+data.tdtukartambah[x].nama_item+'</td>';
                        html += '<td>'+data.tdtukartambah[x].qty+'</td>';
                        html += '<td>'+data.tdtukartambah[x].harga+'</td>';
                        html += '<td>'+data.tdtukartambah[x].subtotal+'</td>';
                        html += '<td>'+data.tdtukartambah[x].potongan+'</td>';
                        html += '<td>'+data.tdtukartambah[x].total+'</td>';
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
