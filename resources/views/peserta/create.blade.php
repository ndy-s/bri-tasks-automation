@extends('layouts.main')

@section('title', $title)

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Create Daftar Peserta</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('peserta.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="bulan">Bulan</label>
                        <select class="form-control {{ $errors->has('bulan') ? 'is-invalid' : ''}}" name="bulan" required>
                            <option value="" disabled selected>Select bulan..</option>
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April">April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="Juli">Juli</option>
                            <option value="Agustus">Agustus</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
                        </select>
                        @error('bulan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleInputPassword1">PN</label>
                        <input type="text" name="pn" class="form-control {{ $errors->has('pn') ? 'is-invalid' : ''}}" value="{{ old('pn') }}" placeholder="Enter pn" required>
                        @error('pn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleInputPassword1">Nama</label>
                        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" value="{{ old('name') }}" placeholder="Enter name" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleInputPassword1">Uker</label>
                        <input type="text" name="uker" class="form-control {{ $errors->has('uker') ? 'is-invalid' : ''}}" value="{{ old('uker') }}" placeholder="Enter uker" required>
                        @error('uker')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleInputPassword1">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control {{ $errors->has('keterangan') ? 'is-invalid' : ''}}" value="{{ old('keterangan') }}" placeholder="Enter keterangan">
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleInputPassword1">Status</label>
                        <input type="text" name="status" class="form-control {{ $errors->has('status') ? 'is-invalid' : ''}}" value="{{ old('status') }}" placeholder="Enter status">
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <a href="{{ route('peserta.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </main>
@endsection
