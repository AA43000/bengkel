@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Supplier</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Supplier</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="card">
        <div class="card-header">
            <a href="{{ route('supplier.create') }}" class="btn btn-md btn-success mb-3">Tambah Supplier</a>
        </div>
        <div class="card-body p-0">
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
                        <th>Bank</th>
                        <th>No Account</th>
                        <th>Atas Nama</th>
                        <th>Kontak Person</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $supplier)
                    <tr>
                        <td>#</td>
                        <td>{{ $supplier->kode }}</td>
                        <td>{{ $supplier->nama }}</td>
                        <td>{{ $supplier->alamat }}</td>
                        <td>{{ $supplier->kota }}</td>
                        <td>{{ $supplier->provinsi }}</td>
                        <td>{{ $supplier->kode_pos }}</td>
                        <td>{{ $supplier->negara }}</td>
                        <td>{{ $supplier->telephone }}</td>
                        <td>{{ $supplier->fax }}</td>
                        <td>{{ $supplier->bank }}</td>
                        <td>{{ $supplier->no_acount }}</td>
                        <td>{{ $supplier->atas_nama }}</td>
                        <td>{{ $supplier->kontak_person }}</td>
                        <td>{{ $supplier->email }}</td>
                        <td class="project-actions text-right">
                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('supplier.destroy', $supplier->id) }}" method="post">
                                <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <div class="alert alert-danger">
                        Data supplier belum tersedia.
                    </div>
                    @endforelse
                </tbody>
            </table>
            {{ $suppliers->links() }}
        </div>

    </div>

</section>
@endsection
