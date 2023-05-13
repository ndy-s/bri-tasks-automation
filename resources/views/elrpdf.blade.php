@extends('layouts.main')

@section('title', $title)

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">ELR to PDF</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('elrpdf-import') }}" onsubmit="location.reload()" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="bulan" class="form-label">Bulan</label>
                        <select class="form-control" name="bulan" required>
                            @foreach($bulan as $bln)
                                <option value="{{ $bln->bulan }}">{{ $bln->bulan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">ELR Excel</label>
                        <input type="file" class="form-control {{ $errors->has('file') ? 'is-invalid' : ''}}" id="exampleInputEmail1" aria-describedby="emailHelp" name="elrpdf" required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="emailHelp" class="form-text">Hanya File ELR hasil export OJL App.</div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                        <label class="form-check-label" for="exampleCheck1">Saya setuju data ingin diolah</label>
                    </div>
                    <button type="submit" formtarget="_blank" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <div class="callout callout-info">
            <h4>Panduan Pengguna</h4>
            Format nama file sebelum diupload harus <b>"ELR {Y-m-d}"</b>.
            <br>Contoh: <b>ELR 2003-12-31</b>, agar sistem dapat mengenali dan memproses penamaan file secara otomatis.
        </div>
    </main>
@endsection
