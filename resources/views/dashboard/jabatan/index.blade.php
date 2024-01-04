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


    <button class="btn btn-primary fs-5 fw-normal mt-2" data-bs-toggle="modal" data-bs-target="#tambahPejabat"><i
            class="fa-solid fa-square-plus fs-5 me-2"></i>Tambah</button>
    <div class="row mt-3">
        <div class="col">
            <div class="card mt-2">
                <div class="card-body">

                    {{-- Tabel Data Pejabat --}}
                    <table id="myTable" class="table responsive nowrap table-bordered table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NAMA</th>
                                <th>JABATAN</th>
                                <th>HP</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pejabats as $pejabat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pejabat->nama }}</td>
                                    <td>{{ $pejabat->Jabatan->nama }}</td>
                                    <td>{{ $pejabat->hp }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editPejabat{{ $loop->iteration }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#hapusPejabat{{ $loop->iteration }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal Edit Pejabat --}}
                                <x-form_modal>
                                    @slot('id', "editPejabat$loop->iteration")
                                    @slot('title', 'Edit Data Pejabat')
                                    @slot('route', route('pejabat.update', $pejabat->id))
                                    @slot('method') @method('put') @endslot
                                    @slot('btnPrimaryTitle', 'Perbarui')

                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="name" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{ old('nama', $pejabat->nama) }}"
                                            autofocus required>
                                        @error('nama')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="jabatan_id" class="form-label">Jabatan</label>
                                        <select class="form-select @error('jabatan_id') is-invalid @enderror"
                                            name="jabatan_id" id="jabatan_id"
                                            value="{{ old('jabatan_id', $pejabat->jabatan_id) }}">
                                            @foreach ($jabatans as $jabatan)
                                                @if (old('jabatan_id', $pejabat->jabatan_id) == $jabatan->id)
                                                    <option value="{{ $jabatan->id }}" selected>
                                                        {{ $jabatan->nama }}</option>
                                                @else
                                                    <option value="{{ $jabatan->id }}">
                                                        {{ $jabatan->nama }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="hp" class="form-label">HP</label>
                                        <input type="text" class="form-control @error('hp') is-invalid @enderror"
                                            id="hp" name="hp" value="{{ old('hp', $pejabat->hp) }}" autofocus
                                            required>
                                        @error('hp')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </x-form_modal>
                                {{-- / Modal Edit Pejabat --}}

                                {{-- Modal Hapus Pejabat --}}
                                <x-form_modal>
                                    @slot('id', "hapusPejabat$loop->iteration")
                                    @slot('title', 'Hapus Data Pejabat')
                                    @slot('route', route('pejabat.destroy', $pejabat->id))
                                    @slot('method') @method('delete') @endslot
                                    @slot('btnPrimaryClass', 'btn-outline-danger')
                                    @slot('btnSecondaryClass', 'btn-secondary')
                                    @slot('btnPrimaryTitle', 'Hapus')

                                    <p class="fs-5">Apakah anda yakin akan menghapus data pejabat
                                        <b>{{ $pejabat->nama }}</b>?
                                    </p>

                                </x-form_modal>
                                {{-- / Modal Hapus Pejabat  --}}
                            @endforeach
                        </tbody>
                    </table>
                    {{-- / Tabel Data ... --}}
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Tambah Pejabat -->
    <x-form_modal>
        @slot('id', 'tambahPejabat')
        @slot('title', 'Tambah Data Pejabat')
        @slot('overflow', 'overflow-auto')
        @slot('route', route('pejabat.store'))

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
            <div class="mb-3">
                <label for="jabatan_id" class="form-label">Jabatan</label>
                <select class="form-select" id="jabatan_id" name="jabatan_id">
                    @foreach ($jabatans as $jabatan)
                        <option value="{{ $jabatan->id }}">{{ $jabatan->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="hp" class="form-label">HP</label>
                <input type="text" class="form-control @error('hp') is-invalid @enderror" id="hp" name="hp"
                    autofocus required>
                @error('hp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </x-form_modal>
    <!-- Akhir Modal Tambah Pejabat -->
@endsection
