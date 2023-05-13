@extends('layouts.main')

@section('title', $title)

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Quick E-Learning</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <form action="{{ route('elearning-trash')}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                        <span data-feather="trash" class="align-text-bottom"></span>
                        Clear
                    </button>
                </form>
            </div>
        </div>

        @if ($Elearning)
            <div class="alert alert-warning" role="alert">
                Sistem mendeteksi data di dalam Database, mohon untuk klik tombol <b>Clear</b> jika belum memulai import.
                <br>
                Abaikan pesan ini jika kamu sedang memproses data.
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('elearning-import') }}" onsubmit="location.reload()" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">E-learning Excel</label>
                        <input type="file" class="form-control {{ $errors->has('file[]') ? 'is-invalid' : ''}}" id="exampleInputEmail1" aria-describedby="emailHelp" name="file[]" multiple required>
                        @error('file[]')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="emailHelp" class="form-text">Hanya File E-learning Divisi Scc Untuk Uko Selindo.</div>
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
            Nama file harus mengandung kata-kata berikut agar dapat diolah oleh sistem.
            <ul>
                <li>Soal SOP UKO Simpanan</li>
                <li>Penegasan Penamaan UKO BRI</li>
                <li>Penyesuaian SMART New Normal Pasca Pencabutan PPKM</li>
                <li>Petunjuk Penggunaan IST</li>
                <li>Risk Awareness - Kegiatan Operasional dan Layanan</li>
            </ul>
            <br>
            Format data excel yang dikenali sistem.
            <br>
            <img src="{{ asset('img/format_raw_1.png') }}" class="mb-3">
            <img src="{{ asset('img/format_raw_2.png') }}">
        </div>
    </main>

@endsection
