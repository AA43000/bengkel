@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Pelanggan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Pelanggan</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="card">
        <div class="card-header">
            <a href="{{ route('pelanggan.create') }}" class="btn btn-md btn-success mb-3">Tambah Pelanggan</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Kota</th>
                            <th>Provinsi</th>
                            <th>Kode Pos</th>
                            <th>Negara</th>
                            <th>Telephone</th>
                            <th>Fax</th>
                            <th>Kontak Person</th>
                            <th>Note</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @forelse ($pelanggans as $pelanggan)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $pelanggan->kode }}</td>
                            <td>{{ $pelanggan->nama }}</td>
                            <td>{{ $pelanggan->alamat }}</td>
                            <td>{{ $pelanggan->kota }}</td>
                            <td>{{ $pelanggan->provinsi }}</td>
                            <td>{{ $pelanggan->kode_pos }}</td>
                            <td>{{ $pelanggan->negara }}</td>
                            <td>{{ $pelanggan->telephone }}</td>
                            <td>{{ $pelanggan->fax }}</td>
                            <td>{{ $pelanggan->kontak_person }}</td>
                            <td>{{ $pelanggan->note }}</td>
                            <td class="project-actions text-right">
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('pelanggan.destroy', $pelanggan->id) }}" method="post">
                                    <a href="{{ route('pelanggan.edit', $pelanggan->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <div class="alert alert-danger">
                            Data pelanggan belum tersedia.
                        </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</section>
@endsection
