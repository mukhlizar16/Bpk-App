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
            <button class="btn btn-primary fs-5 fw-normal mt-2" data-bs-toggle="modal" data-bs-target="#tambahSpmk"><i
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
                                <th>Nomor</th>
                                <th>Tanggal</th>
                                <th>Dokumen</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($spmkses as $spmks)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $spmks->Pagu->paket }}</td>
                                    <td>{{ $spmks->nomor }}</td>
                                    <td>{{ \Carbon\Carbon::parse($spmks->tanggal)->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($spmks->dokumen)
                                            <a class="btn btn-primary" href="{{ asset('storage/' . $spmks->dokumen) }}"
                                                download><i class="fa-solid fa-download me-2"></i> Dokumen</a>
                                        @else
                                            No document available
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editSpmk{{ $loop->iteration }}">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#hapusSpmk{{ $loop->iteration }}">
                                            <i class="fa-regular fa-trash-can fa-lg"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal Edit sppd --}}
                                <x-form_modal>
                                    @slot('id', "editSpmk$loop->iteration")
                                    @slot('title', 'Edit Data Spmk')
                                    @slot('route', route('spmk.update', $spmks->id))
                                    @slot('method') @method('put') @endslot
                                    @slot('btnPrimaryTitle', 'Perbarui')

                                    <input type="hidden" name="oldDokumen" value="{{ $spmks->dokumen }}">
                                    <div class="mb-3">
                                        <label for="pagu_id" class="form-label">Pagu</label>
                                        <select class="form-select @error('pagu_id') is-invalid @enderror" name="pagu_id"
                                            id="pagu_id" value="{{ old('pagu_id', $spmks->pagu_id) }}">
                                            @foreach ($pagus as $pagu)
                                                @if (old('pagu_id', $pagu->pagu_id) == $pagu->id)
                                                    <option value="{{ $pagu->id }}" selected>
                                                        {{ $pagu->paket }}</option>
                                                @else
                                                    <option value="{{ $pagu->id }}">
                                                        {{ $pagu->paket }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor" class="form-label">Nomor</label>
                                        <input type="text" class="form-control @error('nomor') is-invalid @enderror"
                                            id="nomor" name="nomor" value="{{ old('nomor', $spmks->nomor) }}"
                                            autofocus required>
                                        @error('nomor')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                            id="tanggal" name="tanggal" value="{{ old('nomor', $spmks->tanggal) }}"
                                            autofocus required>
                                        @error('tanggal')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="dokumen" class="form-label">Dokumen</label>
                                        <input type="file" class="form-control @error('dokumen') is-invalid @enderror"
                                            id="dokumen" name="dokumen" autofocus>
                                        @error('dokumen')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </x-form_modal>
                                {{-- / Modal Edit sppd --}}

                                {{-- Modal Hapus sppd --}}
                                <x-form_modal>
                                    @slot('id', "hapusSpmk$loop->iteration")
                                    @slot('title', 'Hapus Data Surat Spmk')
                                    @slot('route', route('spmk.destroy', $spmks->id))
                                    @slot('method') @method('delete') @endslot
                                    @slot('btnPrimaryClass', 'btn-outline-danger')
                                    @slot('btnSecondaryClass', 'btn-secondary')
                                    @slot('btnPrimaryTitle', 'Hapus')

                                    <p class="fs-5">Apakah anda yakin akan menghapus data Spmk
                                        <b>{{ $spmks->nomor }}</b>?
                                    </p>

                                </x-form_modal>
                                {{-- / Modal Hapus sppd  --}}
                            @endforeach
                        </tbody>
                    </table>
                    {{-- End Table --}}

                    <x-form_modal>
                        @slot('id', 'tambahSpmk')
                        @slot('title', 'Tambah Data SPMK')
                        @slot('overflow', 'overflow-auto')
                        @slot('route', route('spmk.store'))

                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <label for="pagu_id" class="form-label">Pagu</label>
                                <select class="form-select @error('pagu_id') is-invalid @enderror" name="pagu_id" id="pagu_id"
                                    value="{{ old('pagu_id') }}">
                                    @foreach ($pagus as $pagu)
                                        <option value="{{ $pagu->id }}" selected>
                                            {{ $pagu->paket }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nomor" class="form-label">Nomor</label>
                                <input type="text" class="form-control @error('nomor') is-invalid @enderror"
                                    id="nomor" name="nomor" autofocus required>
                                @error('nomor')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                    id="tanggal" name="tanggal" autofocus required>
                                @error('tanggal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="dokumen" class="form-label">Dokumen</label>
                                <input type="file" class="form-control @error('dokumen') is-invalid @enderror"
                                    id="dokumen" name="dokumen" autofocus required>
                                @error('dokumen')
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
