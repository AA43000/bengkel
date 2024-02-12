@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Pembelian Edit</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Pembelian Edit</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('tpembelian.update', $thpembelian->id) }}" method="POST" enctype="multipart/form-data" id="formall">
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
                                    <label for="kode">No Transaksi</label>
                                    <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" id="kode" value="{{ old('kode', $thpembelian->kode) }}">
                                    
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
                                    <label for="no_pesanan">No Pesanan</label>
                                    <input type="text" class="form-control @error('no_pesanan') is-invalid @enderror" name="no_pesanan" id="no_pesanan" value="{{ old('no_pesanan', $thpembelian->no_pesanan) }}">
                                    
                                        <!-- error message untuk no_pesanan -->
                                        @error('no_pesanan')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_supplier">Supplier</label>
                                    <div class="input-group">
                                        <select id="id_supplier" name="id_supplier" class="form-control select2 @error('id_supplier') is-invalid @enderror">
                                            <option value="0" selected="">Select one</option>
                                            @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ $thpembelian->id_supplier == $supplier->id ? "selected" : "" }}>{{ $supplier->kode.' - '.$supplier->nama }}</option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-info btn-flat" onclick="$('#modal_supplier').modal('show')"><i class="fa fa-user"></i></button>
                                        </span>
                                    </div>
                                    
                                        <!-- error message untuk id_supplier -->
                                        @error('id_supplier')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_akhir">Total Akhir</label>
                                    <input type="number" class="form-control @error('total_akhir') is-invalid @enderror" name="total_akhir" id="total_akhir" value="{{ old('total_akhir', $thpembelian->total_akhir) }}" readonly>
                                    
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
                                    <label for="total_bayar">Total Bayar</label>
                                    <input type="number" class="form-control @error('total_bayar') is-invalid @enderror" name="total_bayar" id="total_bayar" value="{{ old('total_bayar', $thpembelian->total_bayar) }}" onkeyup="get_total()">
                                    
                                        <!-- error message untuk total_bayar -->
                                        @error('total_bayar')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sisa_bayar">Sisa Bayar</label>
                                    <input type="number" class="form-control @error('sisa_bayar') is-invalid @enderror" name="sisa_bayar" id="sisa_bayar" value="{{ old('sisa_bayar', $thpembelian->sisa_bayar) }}" readonly>
                                    
                                        <!-- error message untuk sisa_bayar -->
                                        @error('sisa_bayar')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="potongan">Pembayaran</label>
                                    <select name="pembayaran" id="pembayaran" class="form-control">
                                        <option value="Cash" {{ $thpembelian->pembayaran == 'Cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="Transfer" {{ $thpembelian->pembayaran == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                                        <option value="Kredit" {{ $thpembelian->pembayaran == 'Kredit' ? 'selected' : '' }}>Kredit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" id="tanggal" value="{{ old('tanggal', $thpembelian->tanggal) }}">
                                    
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
            <input type="hidden" name="idthpembelian" id="idthpembelian" value="{{ $thpembelian->id }}">
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
                                                        <option value="0" selected="">Select One</option>
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
                                                    <input type="number" class="form-control" name="potongan" id="potongan" value="" onkeyup="get_total_detail()">
                                                </th>
                                                <th>
                                                    <input type="number" class="form-control" name="grand_total" id="grand_total" value="" readonly>
                                                </th>
                                                <th>
                                                    <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>#</th>
                                                <th>Produk</th>
                                                <th>Pesan</th>
                                                <th>Qty</th>
                                                <th>Harga</th>
                                                <th>Subtotal</th>
                                                <th>Potongan(%)</th>
                                                <th>Grand Total</th>
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

    <div class="modal fade" id="modal_supplier">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= route('tpembelian.add_supplier') ?>" method="post">
                <input type="hidden" name="callback" value="tpembelian/{{ $thpembelian->id }}/edit">
                @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Supplier</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kode_supplier">Kode</label>
                            <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" id="kode_supplier" value="">
                        </div>
                        <div class="form-group">
                            <label for="nama_supplier">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama_supplier" value="">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
        <a href="{{ route('tpembelian.index') }}" class="btn btn-secondary">Cancel</a>
        <input type="button" onclick="$('#formall').submit()" value="Update Pembelian" class="btn btn-success float-right">
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
                url: '{{ route('tpembelian.post_detail') }}',
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
        $("#potongan").val('0');
        $("#grand_total").val('0');
        $("#id_detail").val('0');
    }
    function load_detail() {
        var idthpembelian = $("#idthpembelian").val();
        $.ajax({
            url: '/tpembelian/load_detail/'+idthpembelian,
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
                        html += '<td>'+data.data[x].potongan+'</td>';
                        html += '<td>'+data.data[x].grand_total+'</td>';
                        html += '<td>'+'<button type="button" class="btn btn-success" onclick="edit_detail('+data.data[x].id+')"><i class="fa fa-edit"></i></button> '+' <button type="button" class="btn btn-danger" onclick="delete_detail('+data.data[x].id+')"><i class="fa fa-trash"></i></button>'+'</td>';
                    html += '</tr>';
                    no++;

                    total += data.data[x].grand_total;
                }
                $("#tabel_detail").html(html);
                $("#total_akhir").val(total);
                get_total();
            },
            error: function(error) {
                console.log(error);
            }
        })
    }
    function get_total() {
        var total_akhir = Number($("#total_akhir").val());
        var total_bayar = Number($("#total_bayar").val());

        if(total_bayar > total_akhir) {
            total_bayar = total_akhir;
            $("#total_bayar").val(total_bayar);
        }

        $("#sisa_bayar").val(total_akhir-total_bayar);
    }
    function delete_detail(idtdpembelian) {
        var next = confirm("Apakah Anda Yakin ?");
        if(next) {
            $.ajax({
                url: '/tpembelian/delete_detail/'+idtdpembelian,
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
    function edit_detail(idtdpembelian) {
        $.ajax({
            url: '/tpembelian/edit_detail/'+idtdpembelian,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $("#id_detail").val(data.id);
                $("#id_produk").val(data.id_produk).trigger("change");
                $("#pesan").val(data.pesan);
                $("#qty").val(data.qty);
                $("#harga").val(data.harga);
                $("#subtotal").val(data.subtotal);
                $("#potongan").val(data.potongan);
                $("#grand_total").val(data.grand_total);
            },
            error: function(error) {
                console.log(error);
            }
        })
    }
    function load_produk() {
        var id_produk = $("#id_produk").val();
        $.ajax({
            url: '/tpembelian/load_produk/'+id_produk,
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

        var subtotal = Number($("#subtotal").val());
        var persen = Number($("#potongan").val());
        if(persen > 100) {
            persen = 100;
            $("#potongan").val(100);
        }
        var potongan = subtotal * persen / 100;

        $("#grand_total").val(subtotal - potongan);
    }
</script>
@endsection