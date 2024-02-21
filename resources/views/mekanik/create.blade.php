@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Mekanik Add</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Mekanik Add</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <form action="{{ route('mekanik.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">General</h3>
                    </div>
                    <div class="card-body">
                    
                        <div class="form-group">
                            <label for="kode">Kode</label>
                            <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" id="kode" value="{{ old('kode') }}" placeholder="Masukkan Kode">
                            
                                <!-- error message untuk kode -->
                                @error('kode')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama">
                            
                                <!-- error message untuk nama -->
                                @error('nama')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="keahlian">Keahlian</label>
                            <input type="text" class="form-control @error('keahlian') is-invalid @enderror" name="keahlian" id="keahlian" value="{{ old('keahlian') }}" placeholder="Masukkan Keahlian">
                            
                                <!-- error message untuk keahlian -->
                                @error('keahlian')
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
                            <label for="kota">Kota</label>
                            <input type="text" class="form-control @error('kota') is-invalid @enderror" name="kota" id="kota" value="{{ old('kota') }}" placeholder="Masukkan Kota">
                            
                                <!-- error message untuk kota -->
                                @error('kota')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="provinsi">Povinsi</label>
                            <input type="text" class="form-control @error('provinsi') is-invalid @enderror" name="provinsi" id="provinsi" value="{{ old('provinsi') }}" placeholder="Masukkan Povinsi">
                            
                                <!-- error message untuk provinsi -->
                                @error('provinsi')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="telephone">Telephone</label>
                            <input type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" id="telephone" value="{{ old('telephone') }}" placeholder="Masukkan Telephone">
                            
                                <!-- error message untuk telephone -->
                                @error('telephone')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="note">Note</label>
                            <textarea class="form-control @error('note') is-invalid @enderror" name="note" id="note" rows="5" placeholder="Masukkan Note">{{ old('note') }}</textarea>
                            
                                <!-- error message untuk note -->
                                @error('note')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="id_user">User</label>
                            <select name="id_user" id="id_user" class="form-control select2">
                                <option value="0" selected>Select One</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            
                                <!-- error message untuk id_user -->
                                @error('id_user')
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
            <a href="{{ route('mekanik.index') }}" class="btn btn-secondary">Cancel</a>
            <input type="submit" value="Create Mekanik" class="btn btn-success float-right">
            </div>
        </div>
    </form>
</section>
@endsection