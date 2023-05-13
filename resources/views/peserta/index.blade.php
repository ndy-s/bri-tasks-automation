@extends('layouts.main')

@section('title', $title)

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Daftar Peserta UUCK atau Resign</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a class="btn btn-sm btn-outline-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        All Data
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        @foreach($bulan as $bln)
                            <li>
                                <form action="{{ route('peserta.index') }}" method="get" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" value="{{ $bln->bulan }}" name="bulan">
                                    <button class="dropdown-item" type="submit">{{ $bln->bulan }}</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#deleteModal">
                        <span data-feather="user-x" class="align-text-bottom"></span>
                        Multi Delete
                    </button>
                </div>
                <div class="btn-group me-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#uploadModal">
                        <span data-feather="upload" class="align-text-bottom"></span>
                        Upload
                    </button>
                    <a href="{{ route('peserta.create') }}" type="button" class="btn btn-sm btn-outline-secondary">
                        <span data-feather="plus-circle" class="align-text-bottom"></span>
                        Tambah
                    </a>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="text-center">Bulan</th>
                    <th scope="col" class="text-center">PN</th>
                    <th scope="col" class="text-center">Nama</th>
                    <th scope="col" class="text-center">Uker</th>
                    <th scope="col" class="text-center">Keterangan</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($peserta as $index => $p1)
                    <tr>
                        <td class="text-center">{{ $index+1 }}</td>
                        <td class="text-center">{{ $p1->bulan }}</td>
                        <td class="text-center">{{ $p1->pn }}</td>
                        <td>{{ $p1->name }}</td>
                        <td>{{ $p1->uker }}</td>
                        <td class="text-center">{{ $p1->keterangan }}</td>
                        <td class="text-center">{{ $p1->status }}</td>
                        <td class="d-flex item-center justify-content-center">
                            <a href="{{ route('peserta.edit', $p1->id) }}" type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
                                <span data-feather="edit" class="align-text-bottom"></span>
                            </a>
                            <form action="{{ route('peserta.destroy', $p1->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-secondary" type="submit" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
                                    <span data-feather="trash" class="align-text-bottom"></span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Upload Data Peserta</h5>
                    <input type="button" class="close" data-dismiss="modal" aria-label="Close" value="&times;">
                </div>
                <div class="modal-body">
                    <form action="{{ route('peserta-import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select class="form-control" name="bulan" required>
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
                        </div>
                        <div class="mb-3">
                            <label for="DaftarPeserta" class="form-label">Daftar Peserta</label>
                            <input type="file" class="form-control" name="daftarPeserta" aria-describedby="DaftarPeserta" required>
                            <div id="DaftarPeserta" class="form-text">We'll never share your data with anyone else.</div>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                            <label class="form-check-label" for="exampleCheck1">Saya setuju data akan disimpan</label>
                        </div>
                        <div class="callout callout-info">
                            <h4>Panduan Pengguna</h4>
                            Format data excel harus berupa gambar dibawah ini. Judul kolom dimulai dari baris ke-4.
                            <br><img src="{{ asset('img/format_peserta.png') }}" width="100%">
                            <br>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Data Peserta</h5>
                    <input type="button" class="close" data-dismiss="modal" aria-label="Close" value="&times;">
                </div>
                <div class="modal-body">
                    <form action="{{ route('peserta-multidelete') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select class="form-control" name="bulan" required>
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
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                            <label class="form-check-label" for="exampleCheck1">Saya setuju data akan dihapus</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
