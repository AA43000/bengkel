@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $total_pelanggan }}</h3>
                        <p>Pelanggan</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </div>
                    <a href="{{ route('pelanggan.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $total_produk }}</h3>
                        <p>Produk</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-tag" aria-hidden="true"></i>
                    </div>
                    <a href="{{ route('produk.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $total_transaksi }}</h3>
                        <p>Transaksi</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                    </div>
                    <a href="{{ route('tpenjualan.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ number_format($total_omset) }}</h3>
                        <p>Omset</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-book" aria-hidden="true"></i>
                    </div>
                    <a href="{{ route('tpenjualan.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Chart Transaksi</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
    
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Penjualan Terakhir</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body ">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Pelanggan</th>
                                        <th>Total Akhir</th>
                                        <th>Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($thpenjualans as $thpenjualan)
                                    <tr>
                                        <td><a target="blank" href="/tpenjualan/print/{{ $thpenjualan->id }}">{{ $thpenjualan->kode }}</a></td>
                                        <td>{{ ($thpenjualan->id_pelanggan != 0 ? $thpenjualan->nama_pelanggan : 'Pelanggan Pengunjung') }}</td>
                                        <td>{{ number_format($thpenjualan->total_akhir) }}</td>
                                        <td>{{ $thpenjualan->pembayaran }}</td>
                                    </tr>
                                    @empty
                                    <div class="alert alert-danger">
                                        Data penjualan belum tersedia.
                                    </div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="card-footer clearfix">
                        <a href="{{ route('tpenjualan.create') }}" class="btn btn-sm btn-info float-left">Penjualan Baru</a>
                        <a href="{{ route('tpenjualan.index') }}" class="btn btn-sm btn-secondary float-right">Lihat Semua Penjualan</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ URL::asset('/js/Chart.min.js') }}"></script>
<script>
    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Pembelian',
          'Penjualan',
          'Service',
          'Tukar Tambah',
      ],
      datasets: [
        {
          data: [
            {{ $chart['pembelian'] }},
            {{ $chart['penjualan'] }},
            {{ $chart['service'] }},
            {{ $chart['tukartambah'] }},
          ],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })
</script>
@endsection
