@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cabang Edit</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Cabang Edit</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <form action="{{ route('cabang.update', $cabang->id) }}" method="POST" enctype="multipart/form-data">
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
                            <label for="logo">Logo</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" id="logo" value="{{ old('logo', $cabang->logo) }}">
                            
                                <!-- error message untuk logo -->
                                @error('logo')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>
                    
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" value="{{ old('nama', $cabang->nama) }}" placeholder="Masukkan Nama">
                            
                                <!-- error message untuk nama -->
                                @error('nama')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="telephone">Telephone</label>
                            <input type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" id="telephone" value="{{ old('telephone', $cabang->telephone) }}" placeholder="Masukkan Telephone">
                            
                                <!-- error message untuk telephone -->
                                @error('telephone')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" rows="5" placeholder="Masukkan Alamat">{{ old('alamat', $cabang->alamat) }}</textarea>
                            
                                <!-- error message untuk alamat -->
                                @error('alamat')
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
            <a href="{{ route('cabang.index') }}" class="btn btn-secondary">Cancel</a>
            <input type="submit" value="Update Cabang" class="btn btn-success float-right">
            </div>
        </div>
    </form>
</section>
@endsection