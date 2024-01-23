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
            <div class="row m-4">
            @forelse ($thservices as $thservice)
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="info-box bg-info" style="cursor: pointer" onclick="window.location.href = '{{ route('service.edit', $thservice->id) }}'">
                        <div class="info-box-content">
                            <span class="info-box-number" style="font-size: 2rem;text-align: center;">{{ $thservice->no_plat }}</span>
                            <span class="progress-description">
                                {{ ($thservice->nama_mekanik != '' ? $thservice->nama_mekanik : 'Waiting') }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-danger">
                    Data antrian belum tersedia.
                </div>
            @endforelse
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

</section>

<script type="text/javascript">
    $(document).ready(function() {
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
    function get_detail(idthservice) {
        $.ajax({
            url: '/service/get_detail/'+idthservice,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $("#kode_transaksi").html(data.thservice.kode);
                $("#total").html(data.thservice.total);
                $("#potongan").html(data.thservice.potongan);
                $("#total_akhir").html(data.thservice.total_akhir);

                var html = '';
                var no = 1;
                for(var x=0;x<data.tdservice.length;x++) {
                    html += '<tr>';
                        html += '<td>'+no+'</td>';
                        html += '<td>'+data.tdservice[x].nama_item+'</td>';
                        html += '<td>'+(data.tdservice[x].pesan != null ? data.tdservice[x].pesan : '')+'</td>';
                        html += '<td>'+data.tdservice[x].qty+'</td>';
                        html += '<td>'+data.tdservice[x].harga+'</td>';
                        html += '<td>'+data.tdservice[x].subtotal+'</td>';
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
