@extends('mekanik_panel.app')

@section('content')
<div class="row mx-3 my-3 justify-content-">
    <div class="col">
        <h3>Form Service</h3>
    </div>
    <div class="col text-end">
        <button type="button" onclick="simpan_data()" class="btn btn-primary">Simpan</button>
    </div>
</div>
<input type="hidden" name="id" id="id" value="{{ $thservice->id }}">
<div class="section mt-2">
    <div class="section-title">General</div>
    <div class="card">
        <div class="card-body">
            <div class="form-group basic">
                <div class="input-wrapper">
                    <label class="label" for="no_plat">No Plat</label>
                    <input type="text" class="form-control" id="no_plat" placeholder="{{ $thservice->no_plat }}" readonly>
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
            </div>

            <div class="form-group basic">
                <div class="input-wrapper">
                    <label class="label" for="tanggal">Tanggal</label>
                    <input type="text" class="form-control" id="tanggal" placeholder="{{ date('Y-m-d') }}" readonly>
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section mt-2">
    <div class="section-title">Kerusakan</div>
    <div class="card">
        <div class="card-body">
            <form id="formkerusakan">
                @csrf
                <input type="hidden" name="idthservice" value="{{ $thservice->id }}">
                <input type="hidden" name="id" id="id_detail_kerusakan" value="0">
                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="bagian">Bagian</label>
                        <input type="text" class="form-control" id="bagian" name="bagian" placeholder="Masukkan Bagian">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
    
                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="kerusakan">Kerusakan</label>
                        <textarea id="kerusakan" name="kerusakan" rows="2" class="form-control" placeholder="Masukkan Kerusakan"></textarea>
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                <button type="reset" onclick="$('#id_detail_kerusakan').val('0')" class="btn btn-danger me-1 mb-1">Reset</button>
            </form>
            <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Bagian</th>
                                <th scope="col">Kerusakan</th>
                                <th scope="col" class="text-end">Config</th>
                            </tr>
                        </thead>
                        <tbody id="tabel_kerusakan">
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>

<div class="section mt-2">
    <div class="section-title">Perbaikan</div>
    <div class="card">
        <div class="card-body">
            <form id="formperbaikan">
                @csrf
                <input type="hidden" name="idthservice" value="{{ $thservice->id }}">
                <input type="hidden" name="id" id="id_detail_perbaikan" value="0">
                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="bagian2">Bagian</label>
                        <input type="text" class="form-control" id="bagian2" name="bagian" placeholder="Masukkan Bagian">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
    
                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="keterangan">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" rows="2" class="form-control" placeholder="Masukkan Keterangan"></textarea>
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                <button type="reset" onclick="$('#id_detail_perbaikan').val('0')" class="btn btn-danger me-1 mb-1">Reset</button>
            </form>
            <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Bagian</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col" class="text-end">Config</th>
                            </tr>
                        </thead>
                        <tbody id="tabel_perbaikan">
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>

<div class="section mt-2">
    <div class="section-title">Pergantian</div>
    <div class="card">
        <div class="card-body">
            <form id="formpergantian">
                @csrf
                <input type="hidden" name="idthservice" value="{{ $thservice->id }}">
                <input type="hidden" name="id" id="id_detail_pergantian" value="0">
                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="id_produk">Part</label>
                        <select name="id_produk" id="id_produk" class="form-control select2">
                            <option value="0">Select One</option>
                            @foreach($produks as $produk)
                            <option value="{{ $produk->id }}">{{ $produk->nama_item }}</option>
                            @endforeach
                        </select>
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
    
                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="qty">Qty</label>
                        <input type="number" name="qty" id="qty" class="form-control">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                <button type="reset" onclick="$('#id_detail_pergantian').val('0')" class="btn btn-danger me-1 mb-1">Reset</button>
            </form>
            <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Part</th>
                                <th scope="col">Qty</th>
                                <th scope="col" class="text-end">Config</th>
                            </tr>
                        </thead>
                        <tbody id="tabel_pergantian">
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        load_kerusakan();
        load_perbaikan();
        load_pergantian();
        $("#formkerusakan").on("submit", function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('mekanik_panel.action_kerusakan') }}",
                data: $(this).serialize(),
                type: "post",
                dataType: "json",
                success: function(data) {
                    if(data.status == 200) {
                        load_kerusakan();
                        $("#id_detail_kerusakan").val('0');
                        $("#bagian").val('');
                        $("#kerusakan").val('');
                    } else {
                        alert(data.message);
                    }
                }

            })
        })

        $("#formperbaikan").on("submit", function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('mekanik_panel.action_perbaikan') }}",
                data: $(this).serialize(),
                type: "post",
                dataType: "json",
                success: function(data) {
                    if(data.status == 200) {
                        load_perbaikan();
                        $("#id_detail_perbaikan").val('0');
                        $("#bagian2").val('');
                        $("#keterangan").val('');
                    } else {
                        alert(data.message);
                    }
                }

            })
        })

        $("#formpergantian").on("submit", function(e) {
            e.preventDefault();

            var next = true;
            if(Number($("#id_produk").val()) <= 0) {
                next = false;
                alert("Part tidak boleh kosong");
            }
            if(Number($("#qty").val()) <= 0) {
                next = false;
                alert("Qty harus lebih dari 0");
            }
            if(next) {
                $.ajax({
                    url: "{{ route('mekanik_panel.action_pergantian') }}",
                    data: $(this).serialize(),
                    type: "post",
                    dataType: "json",
                    success: function(data) {
                        if(data.status == 200) {
                            load_pergantian();
                            $("#id_detail_pergantian").val('0');
                            $("#id_produk").val('0').trigger("change");
                            $("#qty").val('');
                        } else {
                            alert(data.message);
                        }
                    }
    
                })
            }
        })
    })
    function simpan_data() {
        var id = $("#id").val();
        var next = confirm('Anda yakin ingin menyelesaikan service ini??');
        if(next) {
            $.ajax({
                url: "/mekanik_panel/simpan_data/"+id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    window.location.href = "{{ route('mekanik_panel.index') }}";
                }
            })
        }
    }
    function load_kerusakan() {
        var id = $("#id").val();
        $.ajax({
            url: "/mekanik_panel/get_kerusakan/"+id,
            dataType: "json",
            type: "GET",
            success: function(data) {
                var html = '';
                for(var x = 0;x<data.data.length;x++) {
                    html += '<tr>';
                        html += '<td>'+data.data[x].bagian+'</td>';
                        html += '<td>'+data.data[x].kerusakan+'</td>';
                        html += '<td>'+'<button type="button" class="btn btn-icon btn-success btn-sm me-1" onclick="edit_kerusakan('+data.data[x].id+')"><ion-icon name="create"></ion-icon></button> <button type="button" class="btn btn-icon btn-danger btn-sm me-1" onclick="delete_kerusakan('+data.data[x].id+')"><ion-icon name="trash"></ion-icon></button>'+'</td>';
                    html += '</tr>';
                }
                if(html == '') {
                    html = '<tr><td colspan="3">Data belum tersedia</td></tr>';
                }
                $("#tabel_kerusakan").html(html);
            }
        })
    }

    function edit_kerusakan(id) {
        $.ajax({
            url: "/mekanik_panel/edit_kerusakan/"+id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $("#id_detail_kerusakan").val(data.id);
                $("#bagian").val(data.bagian);
                $("#kerusakan").val(data.kerusakan);
            }
        })
    }

    function delete_kerusakan(id) {
        var next = confirm('Apakah anda yakin??');
        if(next) {
            $.ajax({
                url: "/mekanik_panel/delete_kerusakan/"+id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    load_kerusakan();
                }
            })
        }
    }

    function load_perbaikan() {
        var id = $("#id").val();
        $.ajax({
            url: "/mekanik_panel/get_perbaikan/"+id,
            dataType: "json",
            type: "GET",
            success: function(data) {
                var html = '';
                for(var x = 0;x<data.data.length;x++) {
                    html += '<tr>';
                        html += '<td>'+data.data[x].bagian+'</td>';
                        html += '<td>'+data.data[x].keterangan+'</td>';
                        html += '<td>'+'<button type="button" class="btn btn-icon btn-success btn-sm me-1" onclick="edit_perbaikan('+data.data[x].id+')"><ion-icon name="create"></ion-icon></button> <button type="button" class="btn btn-icon btn-danger btn-sm me-1" onclick="delete_perbaikan('+data.data[x].id+')"><ion-icon name="trash"></ion-icon></button>'+'</td>';
                    html += '</tr>';
                }
                if(html == '') {
                    html = '<tr><td colspan="3">Data belum tersedia</td></tr>';
                }
                $("#tabel_perbaikan").html(html);
            }
        })
    }

    function edit_perbaikan(id) {
        $.ajax({
            url: "/mekanik_panel/edit_perbaikan/"+id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $("#id_detail_perbaikan").val(data.id);
                $("#bagian2").val(data.bagian);
                $("#keterangan").val(data.keterangan);
            }
        })
    }

    function delete_perbaikan(id) {
        var next = confirm('Apakah anda yakin??');
        if(next) {
            $.ajax({
                url: "/mekanik_panel/delete_perbaikan/"+id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    load_perbaikan();
                }
            })
        }
    }

    function load_pergantian() {
        var id = $("#id").val();
        $.ajax({
            url: "/mekanik_panel/get_pergantian/"+id,
            dataType: "json",
            type: "GET",
            success: function(data) {
                var html = '';
                for(var x = 0;x<data.data.length;x++) {
                    html += '<tr>';
                        html += '<td>'+data.data[x].nama_item+'</td>';
                        html += '<td>'+data.data[x].qty+'</td>';
                        html += '<td>'+'<button type="button" class="btn btn-icon btn-success btn-sm me-1" onclick="edit_pergantian('+data.data[x].id+')"><ion-icon name="create"></ion-icon></button> <button type="button" class="btn btn-icon btn-danger btn-sm me-1" onclick="delete_pergantian('+data.data[x].id+')"><ion-icon name="trash"></ion-icon></button>'+'</td>';
                    html += '</tr>';
                }
                if(html == '') {
                    html = '<tr><td colspan="3">Data belum tersedia</td></tr>';
                }
                $("#tabel_pergantian").html(html);
            }
        })
    }

    function edit_pergantian(id) {
        $.ajax({
            url: "/mekanik_panel/edit_pergantian/"+id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $("#id_detail_pergantian").val(data.id);
                $("#id_produk").val(data.id_produk).trigger("change");
                $("#qty").val(data.qty);
            }
        })
    }

    function delete_pergantian(id) {
        var next = confirm('Apakah anda yakin??');
        if(next) {
            $.ajax({
                url: "/mekanik_panel/delete_pergantian/"+id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    load_pergantian();
                }
            })
        }
    }
</script>
@endsection