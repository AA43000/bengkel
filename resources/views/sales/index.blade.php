@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sales</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Sales</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="card">
        <div class="card-header">
            <a href="{{ route('sales.create') }}" class="btn btn-md btn-success mb-3">Tambah Sales</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Komisi</th>
                            <th>Komisi Nominal</th>
                            <th>Alamat</th>
                            <th>Kota</th>
                            <th>Telephone</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @forelse ($sales as $sls)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $sls->kode }}</td>
                            <td>{{ $sls->nama }}</td>
                            <td>{{ $sls->komisi }}</td>
                            <td>{{ number_format($sls->komisi_nominal) }}</td>
                            <td>{{ $sls->alamat }}</td>
                            <td>{{ $sls->kota }}</td>
                            <td>{{ $sls->telephone }}</td>
                            <td class="project-actions text-right">
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('sales.destroy', $sls->id) }}" method="post">
                                    <a href="{{ route('sales.edit', $sls->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <div class="alert alert-danger">
                            Data sales belum tersedia.
                        </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</section>
@endsection
