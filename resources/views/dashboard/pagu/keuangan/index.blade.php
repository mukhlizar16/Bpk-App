@extends('dashboard.layouts.main')

@section('content')
    <div class="row">
        <div class="col">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session()->has('failed'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('failed') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            <a class="btn btn-outline-secondary fs-5 fw-normal mt-2" href="{{ route('pagu.index') }}">
                <i class="fa-regular fa-chevron-left me-2"></i>
                Kembali
            </a>
            <button class="btn btn-primary fs-5 fw-normal mt-2" data-bs-toggle="modal" data-bs-target="#tambahKeuangan"><i
                    class="fa-solid fa-square-plus fs-5 me-2"></i>Tambah</button>

            <div class="mt-3 card">
                <div class="card-body">
                    {{-- Table --}}
                    <table id="myTable" class="table align-middle responsive nowrap table-bordered table-striped"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pagu</th>
                                <th>Nilai</th>
                                <th>Bobot</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($keuangans as $keuangan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $keuangan->Pagu->paket }}</td>
                                    <td>{{ $keuangan->nilai }}</td>
                                    <td>{{ $keuangan->bobot }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editKeuangan{{ $loop->iteration }}">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#hapusKeuangan{{ $loop->iteration }}">
                                            <i class="fa-regular fa-trash-can fa-lg"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal Edit sppd --}}
                                <x-form_modal>
                                    @slot('id', "editKeuangan$loop->iteration")
                                    @slot('title', 'Edit Data Keuangan')
                                    @slot('route', route('keuangan.update', $keuangan->id))
                                    @slot('method') @method('put') @endslot
                                    @slot('btnPrimaryTitle', 'Perbarui')

                                    <div class="mb-3">
                                        <label for="nilai" class="form-label">Nilai</label>
                                        <input type="number" class="form-control @error('nilai') is-invalid @enderror"
                                            id="nilai" name="nilai" value="{{ old('nilai', $keuangan->nilai) }}"
                                            autofocus required>
                                        @error('nilai')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="bobot" class="form-label">Bobot</label>
                                        <input type="text" class="form-control @error('bobot') is-invalid @enderror"
                                            id="bobot" name="bobot" value="{{ old('nomor', $keuangan->bobot) }}"
                                            autofocus required>
                                        @error('bobot')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </x-form_modal>
                                {{-- / Modal Edit sppd --}}

                                {{-- Modal Hapus sppd --}}
                                <x-form_modal>
                                    @slot('id', "hapusKeuangan$loop->iteration")
                                    @slot('title', 'Hapus Data Surat Keuangan')
                                    @slot('route', route('keuangan.destroy', $keuangan->id))
                                    @slot('method') @method('delete') @endslot
                                    @slot('btnPrimaryClass', 'btn-outline-danger')
                                    @slot('btnSecondaryClass', 'btn-secondary')
                                    @slot('btnPrimaryTitle', 'Hapus')

                                    <p class="fs-5">Apakah anda yakin akan menghapus data Keuangan
                                        <b>{{ $keuangan->nilai }}</b>?
                                    </p>

                                </x-form_modal>
                                {{-- / Modal Hapus sppd  --}}
                            @endforeach
                        </tbody>
                    </table>
                    {{-- End Table --}}

                    <x-form_modal>
                        @slot('id', 'tambahKeuangan')
                        @slot('title', 'Tambah Data Keuangan')
                        @slot('overflow', 'overflow-auto')
                        @slot('route', route('keuangan.store'))

                        @csrf
                        <div class="row">
                            <input type="hidden" name="pagu_id" value="{{ $keuangan->id }}">
                            <div class="mb-3">
                                <label for="nilai" class="form-label">Nilai</label>
                                <input type="number" class="form-control @error('nilai') is-invalid @enderror"
                                    id="nilai" name="nilai" autofocus required>
                                @error('nilai')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="bobot" class="form-label">Bobot</label>
                                <input type="number" step="any" class="form-control @error('bobot') is-invalid @enderror"
                                    id="bobot" name="bobot" autofocus required>
                                @error('bobot')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </x-form_modal>

                </div>
            </div>
        </div>
    </div>
@endsection
