@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Produk</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Produk</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="card">
        <div class="card-header">
            <a href="{{ route('produk.create') }}" class="btn btn-md btn-success mb-3">Tambah Produk</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Item</th>
                        <th>Kode Barcode</th>
                        <th>Nama Item</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Rak</th>
                        <th>Harga Pokok</th>
                        <th>Harga Jual</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produks as $produk)
                    <tr>
                        <td>#</td>
                        <td>{{ $produk->kode_item }}</td>
                        <td>{{ $produk->kode_barcode }}</td>
                        <td>{{ $produk->nama_item }}</td>
                        <td>{{ $produk->jenis }}</td>
                        <td>{{ $produk->kategori }}</td>
                        <td>{{ $produk->stok }}</td>
                        <td>{{ $produk->satuan }}</td>
                        <td>{{ $produk->rak }}</td>
                        <td>{{ number_format($produk->harga_pokok) }}</td>
                        <td>{{ number_format($produk->harga_jual) }}</td>
                        <td class="project-actions text-right">
                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('produk.destroy', $produk->id) }}" method="post">
                                <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <div class="alert alert-danger">
                        Data produk belum tersedia.
                    </div>
                    @endforelse
                </tbody>
            </table>
            {{ $produks->links() }}
        </div>

    </div>

</section>
@endsection
