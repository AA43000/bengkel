@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Produk Edit</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Produk Edit</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">General</h3>
                    </div>
                    <div class="card-body">
                    
                    <div class="form-group">
                            <label for="kode_item">Kode Item</label>
                            <input type="text" class="form-control @error('kode_item') is-invalid @enderror" name="kode_item" id="kode_item" value="{{ old('kode_item', $produk->kode_item) }}" placeholder="Masukkan Kode Item">
                            
                                <!-- error message untuk kode_item -->
                                @error('kode_item')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="kode_barcode">Kode Barcode</label>
                            <input type="text" class="form-control @error('kode_barcode') is-invalid @enderror" name="kode_barcode" id="kode_barcode" value="{{ old('kode_barcode', $produk->kode_barcode) }}" placeholder="Masukkan Kode Barcode">
                            
                                <!-- error message untuk kode_barcode -->
                                @error('kode_barcode')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama_item">Nama Item</label>
                            <input type="text" class="form-control @error('nama_item') is-invalid @enderror" name="nama_item" id="nama_item" value="{{ old('nama_item', $produk->nama_item) }}" placeholder="Masukkan Nama Item">
                            
                                <!-- error message untuk nama_item -->
                                @error('nama_item')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <input type="text" class="form-control @error('jenis') is-invalid @enderror" name="jenis" id="jenis" value="{{ old('jenis', $produk->jenis) }}" placeholder="Masukkan Jenis">
                            
                                <!-- error message untuk jenis -->
                                @error('jenis')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <input type="text" class="form-control @error('kategori') is-invalid @enderror" name="kategori" id="kategori" value="{{ old('kategori', $produk->kategori) }}" placeholder="Masukkan Kategori">
                            
                                <!-- error message untuk kategori -->
                                @error('kategori')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="text" class="form-control @error('stok') is-invalid @enderror" name="stok" id="stok" value="{{ old('stok', $produk->stok) }}" placeholder="Masukkan Stok">
                            
                                <!-- error message untuk stok -->
                                @error('stok')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <input type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" id="satuan" value="{{ old('satuan', $produk->satuan) }}" placeholder="Masukkan Satuan">
                            
                                <!-- error message untuk satuan -->
                                @error('satuan')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="rak">Rak</label>
                            <input type="text" class="form-control @error('rak') is-invalid @enderror" name="rak" id="rak" value="{{ old('rak', $produk->rak) }}" placeholder="Masukkan Rak">
                            
                                <!-- error message untuk rak -->
                                @error('rak')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="harga_pokok">Harga Pokok</label>
                            <input type="text" class="form-control @error('harga_pokok') is-invalid @enderror" name="harga_pokok" id="harga_pokok" value="{{ old('harga_pokok', $produk->harga_pokok) }}" placeholder="Masukkan Harga Pokok">
                            
                                <!-- error message untuk harga_pokok -->
                                @error('harga_pokok')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="harga_jual">Harga Jual</label>
                            <input type="text" class="form-control @error('harga_jual') is-invalid @enderror" name="harga_jual" id="harga_jual" value="{{ old('harga_jual', $produk->harga_jual) }}" placeholder="Masukkan Harga Jual">
                            
                                <!-- error message untuk harga_jual -->
                                @error('harga_jual')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-12">
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">Cancel</a>
            <input type="submit" value="Update Produk" class="btn btn-success float-right">
            </div>
        </div>
    </form>
</section>
@endsection