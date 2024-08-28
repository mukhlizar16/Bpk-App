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

    <button class="btn btn-primary fs-5 fw-normal mt-2" data-bs-toggle="modal" data-bs-target="#tambahBastPho"><i
            class="fa-solid fa-square-plus fs-5 me-2"></i>Tambah</button>
    <div class="row mt-3">
        <div class="col">
            <div class="card mt-2">
                <div class="card-body">

                    {{-- Tabel Data bast --}}
                    <table id="myTable" class="table responsive nowrap table-bordered table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th>NOMOR</th>
                                <th>PAGU</th>
                                <th class="text-center">TANGGAL</th>
                                <th>KETERANGAN</th>
                                <th class="text-center">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($basts as $bast)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $bast->nomor }}</td>
                                    <td>{{ $bast->Pagu->paket }}</td>
                                    <td class="text-center">{{ $bast->tanggal->format('d/m/Y') }}</td>
                                    <td>{{ $bast->keterangan }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editBastPho{{ $loop->iteration }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#hapusBastPho{{ $loop->iteration }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal Edit Bast --}}
                                <x-form_modal>
                                    @slot('id', "editBastPho$loop->iteration")
                                    @slot('class', 'modal-edit')
                                    @slot('title', 'Edit Data Bast Pho')
                                    @slot('route', route('bast-pho.update', $bast->id))
                                    @slot('method') @method('put') @endslot
                                    @slot('btnPrimaryTitle', 'Perbarui')

                                    <div class="mb-3">
                                        <label for="nomor" class="form-label">Nomor</label>
                                        <input type="text" class="form-control @error('nomor') is-invalid @enderror"
                                            id="nomor" name="nomor" value="{{ old('nomor', $bast->nomor) }}" autofocus
                                            required>
                                        @error('nomor')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="pagu_id" class="form-label">Pagu</label>
                                        <select class="form-select pagu-edit @error('pagu_id') is-invalid @enderror"
                                            name="pagu_id" id="pagu_id" required>
                                            @foreach ($pagus as $pagu)
                                                <option value="{{ $pagu->id }}" @selected(old('pagu_id', $bast->pagu_id) == $pagu->id)>
                                                    {{ $pagu->paket }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                            id="tanggal" name="tanggal"
                                            value="{{ old('tanggal', $bast->tanggal->format('Y-m-d')) }}" required>
                                        @error('tanggal')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="ket" class="form-label">Keterangan</label>
                                        <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                            id="ket" name="keterangan"
                                            value="{{ old('keterangan', $bast->keterangan) }}">
                                        @error('keterangan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </x-form_modal>
                                {{-- / Modal Edit Bast --}}

                                {{-- Modal Hapus Bast --}}
                                <x-form_modal>
                                    @slot('id', "hapusBastPho$loop->iteration")
                                    @slot('title', 'Hapus Data Bast')
                                    @slot('route', route('bast-pho.destroy', $bast->id))
                                    @slot('method') @method('delete') @endslot
                                    @slot('btnPrimaryClass', 'btn-outline-danger')
                                    @slot('btnSecondaryClass', 'btn-secondary')
                                    @slot('btnPrimaryTitle', 'Hapus')

                                    <p class="fs-5">Apakah anda yakin akan menghapus data bast pho
                                        <b>{{ $bast->nomor }}</b>?
                                    </p>

                                </x-form_modal>
                                {{-- / Modal Hapus User  --}}
                            @endforeach
                        </tbody>
                    </table>
                    {{-- / Tabel Data ... --}}
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Tambah Bast -->
    <x-form_modal>
        @slot('id', 'tambahBastPho')
        @slot('title', 'Tambah Data Bast Pho')
        @slot('overflow', 'overflow-auto')
        @slot('route', route('bast-pho.store'))

        @csrf
        <div class="mb-3">
            <label for="nomor" class="form-label">Nomor</label>
            <input type="text" class="form-control @error('nomor') is-invalid @enderror" id="nomor" name="nomor"
                autofocus required>
            @error('nomor')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="pagu_id" class="form-label">pagu</label>
            <select class="form-select select2 @error('pagu_id') is-invalid @enderror" name="pagu_id" id="pagu_id"
                style="width: 100%" required>
                <option value="">--pilih--</option>
                @foreach ($pagus as $pagu)
                    <option value="{{ $pagu->id }}">
                        {{ $pagu->paket }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal"
                required>
            @error('tanggal')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="ket" class="form-label">Keterangan</label>
            <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="ket"
                name="keterangan" required>
            @error('keterangan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </x-form_modal>
    <!-- Akhir Modal Tambah User -->

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    dropdownParent: $('#tambahBastPho')
                });
                $('.modal-edit').on('shown.bs.modal', function() {
                    $(this).find('.pagu-edit').select2({
                        dropdownParent: $(this)
                    });
                })
            });
        </script>
    @endpush
@endsection
