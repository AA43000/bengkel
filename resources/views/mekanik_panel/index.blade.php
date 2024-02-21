@extends('mekanik_panel.app')

@section('content')
<!-- Wallet Card -->
<div class="section wallet-card-section pt-1">
    <div class="wallet-card">
        <!-- Balance -->
        <div class="balance">
        @php
            // Array untuk nama hari dalam bahasa Indonesia
            $hari = [
                'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
            ];

            // Array untuk nama bulan dalam bahasa Indonesia
            $bulan = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            // Mendapatkan tanggal, hari, bulan, dan tahun saat ini
            $tanggal = date('d');
            $nama_hari = $hari[date('w')];
            $nama_bulan = $bulan[date('n') - 1];
            $tahun = date('Y');

            // Format tanggal dalam bahasa Indonesia
            $tanggal_indonesia = $nama_hari . ', ' . $tanggal . ' ' . $nama_bulan . ' ' . $tahun;
        @endphp
        <h1 class="total">{{ $tanggal_indonesia }}</h1>
        </div>
        <div class="wallet-footer">
            <div class="left">
                <span class="title">Total Service</span>
                <h1 class="total">{{ $total_service }}</h1>
            </div>
            <div class="right">
                <span class="title">Total Selesai</span>
                <h1 class="total">{{ $total_selesai }}</h1>
            </div>
        </div>
        <!-- * Balance -->
    </div>
</div>
<!-- Wallet Card -->

<!-- Stats -->
<div class="section mb-3">
    <div class="row mt-2">
        @foreach($thservices as $thservice)
        @php
            $status = '';
            if($thservice->status == 1) {
                $status = 'text-primary';
            } else if($thservice->status == 2) {
                $status = 'text-success';
            }
        @endphp
        <div class="col-6 mt-2 antrian" data-id="{{ $thservice->id }}">
            <div class="stat-box">
                <div class="value text-center {{ $status }}">{{ $thservice->no_plat }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- * Stats -->

<script type="text/javascript">
    $(document).ready(function() {
        // Menggunakan event click untuk menangani klik pada elemen dengan class "col-6"
        $(".antrian").click(function() {
            // Mengambil nilai data-id dari elemen yang diklik
            var dataId = $(this).data('id');
            var next = confirm('Yakin ingin mengambil antrian ini?');
            // Memanggil fungsi href dan meneruskan nilai data-id sebagai parameter
            if(next) {
                window.location.href = '/mekanik_panel/edit/' + dataId;
            }
        });
    })
</script>
@endsection
