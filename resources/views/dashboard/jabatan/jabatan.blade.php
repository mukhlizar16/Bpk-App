@extends('dashboard.layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-6 col-md">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif (session()->has('failed'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('failed') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    <button class="btn btn-primary fs-5 fw-normal mt-2" data-bs-toggle="modal" data-bs-target="#tambahJabatan"><i
            class="fa-solid fa-square-plus fs-5 me-2"></i>Tambah</button>
    </button>
    <div class="row mt-3">
        <div class="col">
            <div class="card mt-2">
                <div class="card-body">

                    {{-- Tabel Data Jabatan --}}
                    <table id="myTable" class="table responsive nowrap table-bordered table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>JABATAN</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jabatans as $jabatan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $jabatan->nama }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editJabatan{{ $loop->iteration }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#hapusJabatan{{ $loop->iteration }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal Edit Jabatan --}}
                                <x-form_modal>
                                    @slot('id', "editJabatan$loop->iteration")
                                    @slot('title', 'Edit Data Jabatan')
                                    @slot('route', route('jabatan.update', $jabatan->id))
                                    @slot('method') @method('put') @endslot
                                    @slot('btnPrimaryTitle', 'Perbarui')

                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="name" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{ old('nama', $jabatan->nama) }}"
                                            autofocus required>
                                        @error('nama')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </x-form_modal>
                                {{-- / Modal Edit Jabatan --}}

                                {{-- Modal Hapus Jabatan --}}
                                <x-form_modal>
                                    @slot('id', "hapusJabatan$loop->iteration")
                                    @slot('title', 'Hapus Data Jabatan')
                                    @slot('route', route('jabatan.destroy', $jabatan->id))
                                    @slot('method') @method('delete') @endslot
                                    @slot('btnPrimaryClass', 'btn-outline-danger')
                                    @slot('btnSecondaryClass', 'btn-secondary')
                                    @slot('btnPrimaryTitle', 'Hapus')

                                    <p class="fs-5">Apakah anda yakin akan menghapus data jabatan
                                        <b>{{ $jabatan->nama }}</b>?
                                    </p>
                                </x-form_modal>
                                {{-- / Modal Hapus Jabatan  --}}
                            @endforeach
                        </tbody>
                    </table>
                    {{-- / Tabel Data ... --}}
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Tambah Jabatan -->
    <x-form_modal>
        @slot('id', 'tambahJabatan')
        @slot('title', 'Tambah Data Jabatan')
        @slot('overflow', 'overflow-auto')
        @slot('route', route('jabatan.store'))

        @csrf
        <div class="row">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="name" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                    autofocus required>
                @error('nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </x-form_modal>
    <!-- Akhir Modal Tambah Jabatan -->
@endsection
