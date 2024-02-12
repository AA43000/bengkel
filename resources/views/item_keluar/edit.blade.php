@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Daftar Item Keluar Edit</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Daftar Item Keluar Edit</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('item_keluar.update', $thitemkeluar->id) }}" method="POST" enctype="multipart/form-data" id="formall">
            @csrf
            @method('PUT')
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">General</h3>
                    </div>
                    <div class="card-body">
                    
                    <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode">No</label>
                                    <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" id="kode" value="{{ old('kode', $thitemkeluar->kode) }}">
                                    
                                        <!-- error message untuk kode -->
                                        @error('kode')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" id="tanggal" value="{{ old('tanggal', $thitemkeluar->tanggal) }}">
                                    
                                        <!-- error message untuk tanggal -->
                                        @error('tanggal')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="number" class="form-control @error('total') is-invalid @enderror" name="total" id="total" value="{{ old('total', $thitemkeluar->total) }}" readonly>
                                    
                                        <!-- error message untuk total -->
                                        @error('total')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_qty">Total Qty</label>
                                    <input type="number" class="form-control @error('total_qty') is-invalid @enderror" name="total_qty" id="total_qty" value="{{ old('total_qty', $thitemkeluar->total_qty) }}" readonly>
                                    
                                        <!-- error message untuk total_qty -->
                                        @error('total_qty')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan" value="{{ old('keterangan', $thitemkeluar->keterangan) }}">
                                    
                                        <!-- error message untuk keterangan -->
                                        @error('keterangan')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                            </div>
                            
                        </div>
                    </div>

                </div>

            </form>

        </div>
        <div class="col-md-12">
            <form id="formdetail" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="idthitemkeluar" id="idthitemkeluar" value="{{ $thitemkeluar->id }}">
            <input type="hidden" name="id_detail" id="id_detail" value="0">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Detail</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="2">
                                                    <select id="id_produk" name="id_produk" class="form-control select2" onchange="load_produk()" required>
                                                        <option value="0" selected="">Select one</option>
                                                        @foreach($produks as $produk)
                                                        <option value="{{ $produk->id }}">{{ $produk->kode_item.' - '.$produk->nama_item }}</option>
                                                        @endforeach
                                                    </select>
                                                </th>
                                                <th>
                                                    <input type="number" class="form-control" name="qty" id="qty" value="" onkeyup="get_total_detail()" required>
                                                </th>
                                                <th>
                                                    <input type="number" class="form-control" name="harga" id="harga" value="" onkeyup="get_total_detail()" required>
                                                </th>
                                                <th>
                                                    <input type="number" class="form-control" name="subtotal" id="subtotal" value="" readonly>
                                                </th>
                                                <th>
                                                    <input type="text" class="form-control" name="keterangan" id="ket" value="">
                                                </th>
                                                <th>
                                                    <button type="submit" class="btn btn-success"><i class="fa fa-fw fa-plus"></i></button>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>#</th>
                                                <th>Produk</th>
                                                <th>Qty</th>
                                                <th>Harga</th>
                                                <th>Subtotal</th>
                                                <th>Ket</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel_detail">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
        <a href="{{ route('item_keluar.index') }}" class="btn btn-secondary">Cancel</a>
        <input type="button" onclick="$('#formall').submit()" value="Update Item Keluar" class="btn btn-success float-right">
        </div>
    </div>
    
</section>
<script type="text/javascript">
    $(document).ready(function() {
        load_detail();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#formdetail').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('item_keluar.post_detail') }}',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    if(response.status == 200) {
                        load_detail();
                        reset_detail();
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
    function reset_detail() {
        $("#id_produk").val('0').trigger("change");
        $("#qty").val('0');
        $("#harga").val('0');
        $("#subtotal").val('0');
        $("#ket").val('');
        $("#id_detail").val('0');
    }
    function load_detail() {
        var idthitemkeluar = $("#idthitemkeluar").val();
        $.ajax({
            url: '/item_keluar/load_detail/'+idthitemkeluar,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var html = '';
                var no = 1;
                var total = 0;
                var total_qty = 0;
                for(var x = 0;x<data.data.length;x++) {
                    html += '<tr>';
                        html += '<td>'+no+'</td>';
                        html += '<td>'+data.data[x].nama_item+'</td>';
                        html += '<td>'+data.data[x].qty+'</td>';
                        html += '<td>'+data.data[x].harga+'</td>';
                        html += '<td>'+data.data[x].subtotal+'</td>';
                        html += '<td>'+data.data[x].keterangan+'</td>';
                        html += '<td>'+'<button type="button" class="btn btn-success" onclick="edit_detail('+data.data[x].id+')"><i class="fa fa-fw fa-edit"></i></button> '+' <button type="button" class="btn btn-danger" onclick="delete_detail('+data.data[x].id+')"><i class="fa fa-fw fa-trash"></i></button>'+'</td>';
                    html += '</tr>';
                    no++;

                    total += data.data[x].subtotal;
                    total_qty += data.data[x].qty;
                }
                $("#tabel_detail").html(html);
                $("#total_qty").val(total_qty);
                $("#total").val(total);
            },
            error: function(error) {
                console.log(error);
            }
        })
    }
    function delete_detail(idtditemkeluar) {
        var next = confirm("Apakah Anda Yakin ?");
        if(next) {
            $.ajax({
                url: '/item_keluar/delete_detail/'+idtditemkeluar,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    load_detail();
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }
    }
    function edit_detail(idtditemkeluar) {
        $.ajax({
            url: '/item_keluar/edit_detail/'+idtditemkeluar,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $("#id_detail").val(data.id);
                $("#id_produk").val(data.id_produk);
                $("#qty").val(data.qty);
                $("#harga").val(data.harga);
                $("#subtotal").val(data.subtotal);
                $("#ket").val(data.keterangan);
            },
            error: function(error) {
                console.log(error);
            }
        })
    }
    function load_produk() {
        var id_produk = $("#id_produk").val();
        $.ajax({
            url: '/item_keluar/load_produk/'+id_produk,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $("#harga").val(data.harga);
                get_total_detail();
            },
            error: function(error) {
                console.log(error);
            }
        })
    }

    function get_total_detail() {
        var qty = Number($("#qty").val());
        var harga = Number($("#harga").val());

        $("#subtotal").val(qty*harga);
    }
</script>
@endsection