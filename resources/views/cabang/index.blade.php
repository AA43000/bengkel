@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cabang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Cabang</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="card">
        <div class="card-header">
            <a href="{{ route('cabang.create') }}" class="btn btn-md btn-success mb-3">Tambah Cabang</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Telephone</th>
                            <th>Alamat</th>
                            <th>Logo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @forelse ($cabangs as $cabang)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $cabang->nama }}</td>
                            <td>{{ $cabang->telephone }}</td>
                            <td>{{ $cabang->alamat }}</td>
                            <td><a href="{{ asset('uploads/' . $cabang->logo) }}" target="blank">{{ $cabang->logo }}</a></td>
                            <td class="project-actions text-right">
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('cabang.destroy', $cabang->id) }}" method="post">
                                    <a href="{{ route('cabang.edit', $cabang->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <div class="alert alert-danger">
                            Data cabang belum tersedia.
                        </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</section>
@endsection
