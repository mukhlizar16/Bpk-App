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

    <a class="btn btn-outline-secondary fs-5 fw-normal mt-2" href="{{ route('utama.index') }}"><i
            class="fa-solid fa-chevron-left fs-5 me-2"></i>Kembali</a>
    <button class="btn btn-primary fs-5 fw-normal mt-2" data-bs-toggle="modal" data-bs-target="#tambahSub"><i
            class="fa-solid fa-square-plus fs-5 me-2"></i>Tambah</button>
    </button>
    <div class="row mt-3">
        <div class="col">
            <div class="card mt-2">
                <div class="card-body">

                    {{-- Tabel Data Sub Kegiatan --}}
                    <table id="myTable" class="table responsive nowrap table-bordered table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>KEGIATAN</th>
                                <th>KODE</th>
                                <th>KETERANGAN</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subkegiatans as $sub)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sub->kegiatan->keterangan }}</td>
                                    <td>{{ $sub->kode }}</td>
                                    <td>{{ $sub->keterangan }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editSub{{ $loop->iteration }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#hapusSub{{ $loop->iteration }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal Edit Sub Kegiatan --}}
                                <x-form_modal>
                                    @slot('id', "editSub$loop->iteration")
                                    @slot('title', 'Edit Data Sub Kegiatan')
                                    @slot('route', route('sub-kegiatan.update', $sub->id))
                                    @slot('method') @method('put') @endslot
                                    @slot('btnPrimaryTitle', 'Perbarui')

                                    <input type="hidden" name="kegiatan_id" id="" value="{{ $utama->id }}">
                                    <div class="mb-3">
                                        <label for="kode" class="form-label">Kode</label>
                                        <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                            id="kode" name="kode" value="{{ old('kode', $sub->kode) }}" autofocus
                                            required>
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
                                            value="{{ old('keterangan', $sub->keterangan) }}" autofocus required>
                                        @error('keterangan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </x-form_modal>
                                {{-- / Modal Edit Sub Kegiatan --}}

                                {{-- Modal Hapus Sub Kegiatan --}}
                                <x-form_modal>
                                    @slot('id', "hapusSub$loop->iteration")
                                    @slot('title', 'Hapus Data Sub Kegiatan')
                                    @slot('route', route('sub-kegiatan.destroy', $sub->id))
                                    @slot('method') @method('delete') @endslot
                                    @slot('btnPrimaryClass', 'btn-outline-danger')
                                    @slot('btnSecondaryClass', 'btn-secondary')
                                    @slot('btnPrimaryTitle', 'Hapus')

                                    <p class="fs-5">Apakah anda yakin akan menghapus data sub kegiatan
                                        <b>{{ $sub->keterangan }}</b>?
                                    </p>

                                </x-form_modal>
                                {{-- / Modal Hapus Sub Kegiatan  --}}
                            @endforeach
                        </tbody>
                    </table>
                    {{-- / Tabel Data ... --}}
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Tambah Sub Kegiatan -->
    <x-form_modal>
        @slot('id', 'tambahSub')
        @slot('title', 'Tambah Data Sub Kegiatan')
        @slot('overflow', 'overflow-auto')
        @slot('route', route('sub-kegiatan.store'))

        @csrf
        <div class="row">
            <input type="hidden" name="kegiatan_id" id="" value="{{ $utama->id }}">
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
                <label for="keterangan" class="form-label">Keterangan</label>
                <input type="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                    name="keterangan" autofocus required>
                @error('keterangan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </x-form_modal>
    <!-- Akhir Modal Tambah Sub Kegiatan -->
@endsection
