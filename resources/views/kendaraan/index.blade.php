@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Kendaraan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Kendaraan</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="card">
        <div class="card-header">
            <a href="{{ route('kendaraan.create') }}" class="btn btn-md btn-success mb-3">Tambah Kendaraan</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Polisi</th>
                            <th>Pemilik</th>
                            <th>Alamat</th>
                            <th>Merk</th>
                            <th>Tipe</th>
                            <th>Jenis</th>
                            <th>Tahun Buat</th>
                            <th>Tahun Rakit</th>
                            <th>Silinder</th>
                            <th>Warna</th>
                            <th>No Rangka</th>
                            <th>No Mesin</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @forelse ($kendaraans as $kendaraan)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $kendaraan->no_polisi }}</td>
                            <td>{{ $kendaraan->pemilik }}</td>
                            <td>{{ $kendaraan->alamat }}</td>
                            <td>{{ $kendaraan->merk }}</td>
                            <td>{{ $kendaraan->tipe }}</td>
                            <td>{{ $kendaraan->jenis }}</td>
                            <td>{{ $kendaraan->tahun_buat }}</td>
                            <td>{{ $kendaraan->tahun_rakit }}</td>
                            <td>{{ $kendaraan->silinder }}</td>
                            <td>{{ $kendaraan->warna }}</td>
                            <td>{{ $kendaraan->no_rangka }}</td>
                            <td>{{ $kendaraan->no_mesin }}</td>
                            <td class="project-actions text-right">
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('kendaraan.destroy', $kendaraan->id) }}" method="post">
                                    <a href="{{ route('kendaraan.edit', $kendaraan->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <div class="alert alert-danger">
                            Data kendaraan belum tersedia.
                        </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</section>
@endsection
