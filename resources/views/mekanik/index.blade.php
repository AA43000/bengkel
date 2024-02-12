@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Mekanik</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Mekanik</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="card">
        <div class="card-header">
            <a href="{{ route('mekanik.create') }}" class="btn btn-md btn-success mb-3">Tambah Mekanik</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Keahlian</th>
                            <th>Alamat</th>
                            <th>Kota</th>
                            <th>Provinsi</th>
                            <th>Telephone</th>
                            <th>Note</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @forelse ($mekaniks as $mekanik)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $mekanik->kode }}</td>
                            <td>{{ $mekanik->nama }}</td>
                            <td>{{ $mekanik->keahlian }}</td>
                            <td>{{ $mekanik->alamat }}</td>
                            <td>{{ $mekanik->kota }}</td>
                            <td>{{ $mekanik->provinsi }}</td>
                            <td>{{ $mekanik->telephone }}</td>
                            <td>{{ $mekanik->note }}</td>
                            <td class="project-actions text-right">
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('mekanik.destroy', $mekanik->id) }}" method="post">
                                    <a href="{{ route('mekanik.edit', $mekanik->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <div class="alert alert-danger">
                            Data mekanik belum tersedia.
                        </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</section>
@endsection
