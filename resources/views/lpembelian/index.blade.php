@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Laporan Pembelian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Laporan Pembelian</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="card">
        <div class="card-header">
            <form id="filter_form">
            @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_date">Tanggal Awal:</label>
                            <input type="date" class="form-control" id="start_date" name="start_date">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end_date">Tanggal Akhir:</label>
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="button" onclick="load_data()" class="btn btn-primary mt-4">Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Transaksi</th>
                            <th>No Pesanan</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th>Total Akhir</th>
                            <th>Total Bayar</th>
                            <th>Sisa Bayar</th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5">Total</th>
                            <th id="total_akhir"></th>
                            <th id="total_bayar"></th>
                            <th id="sisa_bayar"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    

</section>

<script type="text/javascript">
    $(document).ready(function() {
        // Mendapatkan tanggal hari ini dalam format YYYY-MM-DD
        var today = new Date().toISOString().slice(0, 10);
        // Mengatur tanggal default untuk input tanggal mulai dan akhir
        $('#start_date').val(today);
        $('#end_date').val(today);
        load_data();
    })
    function load_data() {
        $.ajax({
            url: '/lpembelian/get_data',
            data: $("#filter_form").serialize(),
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                var html = '';
                var no = 1;
                var total_bayar = 0;
                var sisa_bayar = 0;
                var total_akhir = 0;
                for(var x=0;x<data.thpembelian.length;x++) {
                    html += '<tr>';
                        html += '<td>'+no+'</td>';
                        html += '<td>'+data.thpembelian[x].kode+'</td>';
                        html += '<td>'+data.thpembelian[x].no_pesanan+'</td>';
                        html += '<td>'+data.thpembelian[x].tanggal+'</td>';
                        html += '<td>'+data.thpembelian[x].kode_supplier+' - '+data.thpembelian[x].nama_supplier+'</td>';
                        html += '<td>'+data.thpembelian[x].total_akhir+'</td>';
                        html += '<td>'+data.thpembelian[x].total_bayar+'</td>';
                        html += '<td>'+data.thpembelian[x].sisa_bayar+'</td>';
                    html += '</tr>';
                    no++;

                    total_bayar += data.thpembelian[x].total_bayar;
                    sisa_bayar += data.thpembelian[x].sisa_bayar;
                    total_akhir += data.thpembelian[x].total_akhir;
                }

                $("#total_bayar").html(total_bayar);
                $("#sisa_bayar").html(sisa_bayar);
                $("#total_akhir").html(total_akhir);
                $("#table_body").html(html);
            },
            error: function(error) {
                console.log(error);
            }
        })
    }
</script>
@endsection
