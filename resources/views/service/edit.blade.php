@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Form Service</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Form Service</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('service.update', $thservice->id) }}" method="POST" enctype="multipart/form-data" id="formall">
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
                                    <label for="kode">Kode</label>
                                    <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" id="kode" value="{{ old('kode', $thservice->kode) }}" readonly>
                                    
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
                                    <label for="no_plat">No Plat</label>
                                    <input type="text" class="form-control @error('no_plat') is-invalid @enderror" name="no_plat" id="no_plat" value="{{ old('no_plat', $thservice->no_plat) }}" readonly>
                                    
                                        <!-- error message untuk no_plat -->
                                        @error('no_plat')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_mekanik">Mekanik</label>
                                    <select id="id_mekanik" name="id_mekanik" class="form-control custom-select @error('id_mekanik') is-invalid @enderror">
                                        <option value="0" selected="">Select one</option>
                                        @foreach($mekaniks as $mekanik)
                                        <option value="{{ $mekanik->id }}" {{ $thservice->id_mekanik == $mekanik->id ? "selected" : "" }}>{{ $mekanik->kode.' - '.$mekanik->nama }}</option>
                                        @endforeach
                                    </select>
                                    
                                        <!-- error message untuk id_mekanik -->
                                        @error('id_mekanik')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="number" class="form-control @error('total') is-invalid @enderror" name="total" id="total" value="{{ old('total', $thservice->total) }}" readonly>
                                    
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
                                    <label for="potongan">Potongan</label>
                                    <input type="number" class="form-control @error('potongan') is-invalid @enderror" name="potongan" id="potongan" value="{{ old('potongan', $thservice->potongan) }}" onkeyup="get_total()">
                                    
                                        <!-- error message untuk potongan -->
                                        @error('potongan')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_akhir">Total Akhir</label>
                                    <input type="number" class="form-control @error('total_akhir') is-invalid @enderror" name="total_akhir" id="total_akhir" value="{{ old('total_akhir', $thservice->total_akhir) }}" readonly>
                                    
                                        <!-- error message untuk total_akhir -->
                                        @error('total_akhir')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" id="tanggal" value="{{ old('tanggal', $thservice->tanggal) }}">
                                    
                                        <!-- error message untuk tanggal -->
                                        @error('tanggal')
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
            <input type="hidden" name="idthservice" id="idthservice" value="{{ $thservice->id }}">
            <input type="hidden" name="id_detail" id="id_detail" value="0">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Detail</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
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
                                                <input type="text" class="form-control" name="pesan" id="pesan" value="">
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
                                                <button type="submit" class="btn btn-success">Add Detail</button>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>Produk</th>
                                            <th>Pesan</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Subtotal</th>
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

            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
        <a href="{{ route('service.index') }}" class="btn btn-secondary">Cancel</a>
        <input type="button" onclick="$('#formall').submit()" value="Update Service" class="btn btn-success float-right">
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
                url: '{{ route('service.post_detail') }}',
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
        $("#pesan").val('');
        $("#qty").val('0');
        $("#harga").val('0');
        $("#subtotal").val('0');
        $("#id_detail").val('0');
    }
    function load_detail() {
        var idthservice = $("#idthservice").val();
        $.ajax({
            url: '/service/load_detail/'+idthservice,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var html = '';
                var no = 1;
                var total = 0;
                for(var x = 0;x<data.data.length;x++) {
                    html += '<tr>';
                        html += '<td>'+no+'</td>';
                        html += '<td>'+data.data[x].nama_item+'</td>';
                        html += '<td>'+(data.data[x].pesan != null ? data.data[x].pesan : '')+'</td>';
                        html += '<td>'+data.data[x].qty+'</td>';
                        html += '<td>'+data.data[x].harga+'</td>';
                        html += '<td>'+data.data[x].subtotal+'</td>';
                        html += '<td>'+'<button type="button" class="btn btn-success" onclick="edit_detail('+data.data[x].id+')">Edit</button> '+' <button type="button" class="btn btn-danger" onclick="delete_detail('+data.data[x].id+')">Hapus</button>'+'</td>';
                    html += '</tr>';
                    no++;

                    total += data.data[x].subtotal;
                }
                $("#tabel_detail").html(html);
                $("#total").val(total);
                get_total();
            },
            error: function(error) {
                console.log(error);
            }
        })
    }
    function get_total() {
        var total = Number($("#total").val());
        var potongan = Number($("#potongan").val());

        $("#total_akhir").val(total-potongan);
    }
    function delete_detail(idtdpenjualan) {
        var next = confirm("Apakah Anda Yakin ?");
        if(next) {
            $.ajax({
                url: '/service/delete_detail/'+idtdpenjualan,
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
    function edit_detail(idtdpenjualan) {
        $.ajax({
            url: '/service/edit_detail/'+idtdpenjualan,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $("#id_detail").val(data.id);
                $("#id_produk").val(data.id_produk);
                $("#pesan").val(data.pesan);
                $("#qty").val(data.qty);
                $("#harga").val(data.harga);
                $("#subtotal").val(data.subtotal);
            },
            error: function(error) {
                console.log(error);
            }
        })
    }
    function load_produk() {
        var id_produk = $("#id_produk").val();
        $.ajax({
            url: '/service/load_produk/'+id_produk,
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