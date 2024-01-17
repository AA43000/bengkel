@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Supplier Edit</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Supplier Edit</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <form action="{{ route('supplier.update', $supplier->id) }}" method="POST" enctype="multipart/form-data">
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
                            <label for="kode">Kode</label>
                            <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" id="kode" value="{{ old('kode', $supplier->kode) }}" placeholder="Masukkan Kode">
                            
                                <!-- error message untuk kode -->
                                @error('kode')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" value="{{ old('nama', $supplier->nama) }}" placeholder="Masukkan Nama">
                            
                                <!-- error message untuk nama -->
                                @error('nama')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" rows="5" placeholder="Masukkan Alamat">{{ old('alamat', $supplier->alamat) }}</textarea>
                            
                                <!-- error message untuk alamat -->
                                @error('alamat')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="kota">Kota</label>
                            <input type="text" class="form-control @error('kota') is-invalid @enderror" name="kota" id="kota" value="{{ old('kota', $supplier->kota) }}" placeholder="Masukkan Kota">
                            
                                <!-- error message untuk kota -->
                                @error('kota')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="provinsi">Povinsi</label>
                            <input type="text" class="form-control @error('provinsi') is-invalid @enderror" name="provinsi" id="provinsi" value="{{ old('provinsi', $supplier->provinsi) }}" placeholder="Masukkan Povinsi">
                            
                                <!-- error message untuk provinsi -->
                                @error('provinsi')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="kode_pos">Kode Pos</label>
                            <input type="text" class="form-control @error('kode_pos') is-invalid @enderror" name="kode_pos" id="kode_pos" value="{{ old('kode_pos', $supplier->kode_pos) }}" placeholder="Masukkan Kode Pos">
                            
                                <!-- error message untuk kode_pos -->
                                @error('kode_pos')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="negara">Negara</label>
                            <input type="text" class="form-control @error('negara') is-invalid @enderror" name="negara" id="negara" value="{{ old('negara', $supplier->negara) }}" placeholder="Masukkan Negara">
                            
                                <!-- error message untuk negara -->
                                @error('negara')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="telephone">Telephone</label>
                            <input type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" id="telephone" value="{{ old('telephone', $supplier->telephone) }}" placeholder="Masukkan Telephone">
                            
                                <!-- error message untuk telephone -->
                                @error('telephone')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="fax">Fax</label>
                            <input type="text" class="form-control @error('fax') is-invalid @enderror" name="fax" id="fax" value="{{ old('fax', $supplier->fax) }}" placeholder="Masukkan Fax">
                            
                                <!-- error message untuk fax -->
                                @error('fax')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="bank">Bank</label>
                            <input type="text" class="form-control @error('bank') is-invalid @enderror" name="bank" id="bank" value="{{ old('bank', $supplier->bank) }}" placeholder="Masukkan Bank">
                            
                                <!-- error message untuk bank -->
                                @error('bank')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="no_account">No Account</label>
                            <input type="text" class="form-control @error('no_account') is-invalid @enderror" name="no_account" id="no_account" value="{{ old('no_account', $supplier->no_account) }}" placeholder="Masukkan No Account">
                            
                                <!-- error message untuk no_account -->
                                @error('no_account')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="atas_nama">Atas Nama</label>
                            <input type="text" class="form-control @error('atas_nama') is-invalid @enderror" name="atas_nama" id="atas_nama" value="{{ old('atas_nama', $supplier->atas_nama) }}" placeholder="Masukkan Atas Nama">
                            
                                <!-- error message untuk atas_nama -->
                                @error('atas_nama')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="kontak_person">Kontak Person</label>
                            <input type="text" class="form-control @error('kontak_person') is-invalid @enderror" name="kontak_person" id="kontak_person" value="{{ old('kontak_person', $supplier->kontak_person) }}" placeholder="Masukkan Kontak Person">
                            
                                <!-- error message untuk kontak_person -->
                                @error('kontak_person')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email', $supplier->email) }}" placeholder="Masukkan Email">
                            
                                <!-- error message untuk email -->
                                @error('email')
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
            <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Cancel</a>
            <input type="submit" value="Update Supplier" class="btn btn-success float-right">
            </div>
        </div>
    </form>
</section>
@endsection