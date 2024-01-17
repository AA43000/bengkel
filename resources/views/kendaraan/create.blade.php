@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Kendaraan Add</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Kendaraan Add</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <form action="{{ route('kendaraan.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">General</h3>
                    </div>
                    <div class="card-body">
                    
                        <div class="form-group">
                            <label for="no_polisi">No Polisi</label>
                            <input type="text" class="form-control @error('no_polisi') is-invalid @enderror" name="no_polisi" id="no_polisi" value="{{ old('no_polisi') }}" placeholder="Masukkan No Polisi">
                            
                                <!-- error message untuk no_polisi -->
                                @error('no_polisi')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="pemilik">Pemilik</label>
                            <input type="text" class="form-control @error('pemilik') is-invalid @enderror" name="pemilik" id="pemilik" value="{{ old('pemilik') }}" placeholder="Masukkan Pemilik">
                            
                                <!-- error message untuk pemilik -->
                                @error('pemilik')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" rows="5" placeholder="Masukkan Alamat">{{ old('alamat') }}</textarea>
                            
                                <!-- error message untuk alamat -->
                                @error('alamat')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="merk">Merk</label>
                            <input type="text" class="form-control @error('merk') is-invalid @enderror" name="merk" id="merk" value="{{ old('merk') }}" placeholder="Masukkan Merk">
                            
                                <!-- error message untuk merk -->
                                @error('merk')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="tipe">Tipe</label>
                            <input type="text" class="form-control @error('tipe') is-invalid @enderror" name="tipe" id="tipe" value="{{ old('tipe') }}" placeholder="Masukkan Tipe">
                            
                                <!-- error message untuk tipe -->
                                @error('tipe')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <input type="text" class="form-control @error('jenis') is-invalid @enderror" name="jenis" id="jenis" value="{{ old('jenis') }}" placeholder="Masukkan Jenis">
                            
                                <!-- error message untuk jenis -->
                                @error('jenis')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="tahun_buat">Tahun Buat</label>
                            <input type="text" class="form-control @error('tahun_buat') is-invalid @enderror" name="tahun_buat" id="tahun_buat" value="{{ old('tahun_buat') }}" placeholder="Masukkan Tahun Buat">
                            
                                <!-- error message untuk tahun_buat -->
                                @error('tahun_buat')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="tahun_rakit">Tahun Rakit</label>
                            <input type="text" class="form-control @error('tahun_rakit') is-invalid @enderror" name="tahun_rakit" id="tahun_rakit" value="{{ old('tahun_rakit') }}" placeholder="Masukkan Tahun Rakit">
                            
                                <!-- error message untuk tahun_rakit -->
                                @error('tahun_rakit')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="silinder">Silinder</label>
                            <input type="text" class="form-control @error('silinder') is-invalid @enderror" name="silinder" id="silinder" value="{{ old('silinder') }}" placeholder="Masukkan Silinder">
                            
                                <!-- error message untuk silinder -->
                                @error('silinder')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="warna">Warna</label>
                            <input type="text" class="form-control @error('warna') is-invalid @enderror" name="warna" id="warna" value="{{ old('warna') }}" placeholder="Masukkan Warna">
                            
                                <!-- error message untuk warna -->
                                @error('warna')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="no_rangka">No Rangka</label>
                            <input type="text" class="form-control @error('no_rangka') is-invalid @enderror" name="no_rangka" id="no_rangka" value="{{ old('no_rangka') }}" placeholder="Masukkan No Rangka">
                            
                                <!-- error message untuk no_rangka -->
                                @error('no_rangka')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="no_mesin">No Msin</label>
                            <input type="text" class="form-control @error('no_mesin') is-invalid @enderror" name="no_mesin" id="no_mesin" value="{{ old('no_mesin') }}" placeholder="Masukkan No Msin">
                            
                                <!-- error message untuk no_mesin -->
                                @error('no_mesin')
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
            <a href="{{ route('kendaraan.index') }}" class="btn btn-secondary">Cancel</a>
            <input type="submit" value="Create Kendaraan" class="btn btn-success float-right">
            </div>
        </div>
    </form>
</section>
@endsection