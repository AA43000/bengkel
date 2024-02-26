@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Transaksi Service</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Transaksi Service</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_create">Tambah Antrian Service</button>
        </div>
        <div class="card-body p-0">
            <form id="formfilter" class="mx-3 my-3 row">
                <div class="input-group mb-3 col-lg-3">
                    <input type="text" class="form-control rounded-0" id="filter" name="filter">
                    <span class="input-group-append">
                        <button type="button" onclick="get_data()" class="btn btn-info btn-flat">Go!</button>
                        <button type="button" onclick="$('#filter').val(''); get_data()" class="btn btn-warning btn-flat">Clear</button>
                    </span>
                </div>
            </form>
            <div class="row m-4" id="panel_service">
            
            </div>
        </div>

    </div>

    <div class="modal fade" id="modal_create">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Antrian</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_antrian">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="no_plat">No Plat</label>
                            <input type="text" class="form-control" name="no_plat" id="no_plat" required>
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

    <div class="modal fade" id="modal_riwayat">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">No Plat: <span id="no_plat_view"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="tabel_body">
    
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" onclick="$('#form_antrian').submit()" class="btn btn-primary">Buat Transaksi</button>
            </div>
        </div>

    </div>

</section>

<script type="text/javascript">
    $(document).ready(function() {
        @if(session('idthservice'))
            var next = confirm("Apakah anda ingin mencetak nota?");
            if(next) {
                window.open('/service/print/'+{{ session('idthservice') }});
            }
        @endif
        get_data();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#form_antrian").on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "/service/store",
                dataType: "json",
                data: $(this).serialize(),
                type: "post",
                success: function(data) {
                    if(data.status == 200) {
                        window.location.href = "{{ route('service.index') }}";
                    } else {
                        alert(data.message);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            })
        })
    });
    function get_data() {
        $.ajax({
            url: "{{ route('service.get_data', 1) }}",
            dataType: "json",
            data: $("#formfilter").serialize(),
            type: "GET",
            success: function(data) {
                var html = '';
                for(var x = 0;x<data.thservices.length;x++) {
                    var bg = 'bg-secondary';
                    if(data.thservices[x].status == 3) {
                        bg = 'bg-warning';
                    } else if(data.thservices[x].status == 2) {
                        bg = 'bg-success';
                    } else if(data.thservices[x].status == 1) {
                        bg = 'bg-info';
                    }
                    html += '<div class="col-md-2 col-sm-4 col-6">';
                        html += '<div class="info-box '+bg+'" style="cursor: pointer" onclick="edit('+data.thservices[x].id+', '+data.thservices[x].status+')">';
                            html += '<div class="info-box-content">';
                                html += '<span class="info-box-number" style="font-size: 1.8rem;text-align: center;">'+data.thservices[x].no_plat+'</span>';
                                html += '<span class="progress-description">'+(data.thservices[x].nama_mekanik != null ? data.thservices[x].nama_mekanik : 'Waiting')+'</span>';
                            html += '</div>';
                        html += '</div>';
                    html += '</div>';
                }
                $("#panel_service").html(html);
            }
        })
    }
    function edit(id, sts) {
        if(sts == 1 || sts == 2) {
            window.location.href = 'service/'+id+'/edit/';
        } else if(sts == 3) {
            show_riwayat(id);
        }
    }
    function show_riwayat(id) {
        $.ajax({
            url: '/service/get_riwayat/'+id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $("#no_plat_view").html(data.thservice.no_plat);
                $("#no_plat").val(data.thservice.no_plat);

                var html = '';
                var no = 1;
                for(var x=0;x<data.thservices.length;x++) {
                    html += '<tr>';
                        html += '<td>'+data.thservices[x].kode+'</td>';
                        html += '<td>'+data.thservices[x].tanggal+'</td>';
                        html += '<td>'+data.thservices[x].total_akhir+'</td>';
                    html += '</tr>';
                    no++;
                }
                $("#tabel_body").html(html);
                $("#modal_riwayat").modal('show');
            },
            error: function(error) {
                console.log(error);
            }
        })
    }
</script>
@endsection
