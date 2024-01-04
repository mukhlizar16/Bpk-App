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

    <button class="btn btn-primary fs-5 fw-normal mt-2" data-bs-toggle="modal" data-bs-target="#tambahProgram"><i
            class="fa-solid fa-square-plus fs-5 me-2"></i>Tambah</button>
    </button>
    <div class="row mt-3">
        <div class="col">
            <div class="card mt-2">
                <div class="card-body">

                    {{-- Tabel Data User --}}
                    <table id="myTable" class="table responsive nowrap table-bordered table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>KODE</th>
                                <th>KETERANGAN</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($programs as $program)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $program->kode }}</td>
                                    <td>{{ $program->keterangan }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editProgram{{ $loop->iteration }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#hapusProgram{{ $loop->iteration }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal Edit Program --}}
                                <x-form_modal>
                                    @slot('id', "editProgram$loop->iteration")
                                    @slot('title', 'Edit Data Program')
                                    @slot('route', route('program.update', $program->id))
                                    @slot('method') @method('put') @endslot
                                    @slot('btnPrimaryTitle', 'Perbarui')

                                    <div class="mb-3">
                                        <label for="kode" class="form-label">Kode</label>
                                        <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                            id="kode" name="kode" value="{{ old('kode', $program->kode) }}"
                                            autofocus required>
                                        @error('kode')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">keterangan</label>
                                        <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                            id="keterangan" name="keterangan"
                                            value="{{ old('keterangan', $program->keterangan) }}" autofocus required>
                                        @error('keterangan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </x-form_modal>
                                {{-- / Modal Edit Program --}}

                                {{-- Modal Hapus Program --}}
                                <x-form_modal>
                                    @slot('id', "hapusProgram$loop->iteration")
                                    @slot('title', 'Hapus Data Program')
                                    @slot('route', route('program.destroy', $program->id))
                                    @slot('method') @method('delete') @endslot
                                    @slot('btnPrimaryClass', 'btn-outline-danger')
                                    @slot('btnSecondaryClass', 'btn-secondary')
                                    @slot('btnPrimaryTitle', 'Hapus')

                                    <p class="fs-5">Apakah anda yakin akan menghapus data Program
                                        <b>{{ $program->keterangan }}</b>?
                                    </p>

                                </x-form_modal>
                                {{-- / Modal Hapus Program  --}}
                            @endforeach
                        </tbody>
                    </table>
                    {{-- / Tabel Data ... --}}
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Tambah program -->
    <x-form_modal>
        @slot('id', 'tambahProgram')
        @slot('title', 'Tambah Data Program')
        @slot('overflow', 'overflow-auto')
        @slot('route', route('program.store'))

        @csrf
        <div class="row">
            <div class="mb-3">
                <label for="kode" class="form-label">Kode</label>
                <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode"
                    autofocus required>
                @error('kode')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">keterangan</label>
                <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                    name="keterangan" autofocus required>
                @error('keterangan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </x-form_modal>
    <!-- Akhir Modal Tambah Program -->
@endsection
