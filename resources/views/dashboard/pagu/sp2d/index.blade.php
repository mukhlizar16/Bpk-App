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
            <a class="btn btn-outline-secondary fs-5 fw-normal mt-2" href="{{ route('kontrak.index') }}">
                <i class="fa-regular fa-chevron-left me-2"></i>
                Kembali
            </a>
            <button class="btn btn-primary fs-5 fw-normal mt-2" data-bs-toggle="modal" data-bs-target="#tambahSp2d"><i
                    class="fa-solid fa-square-plus fs-5 me-2"></i>Tambah</button>

            <div class="mt-3 card">
                <div class="card-body">
                    {{-- Table --}}
                    <table id="myTable" class="table align-middle responsive nowrap table-bordered table-striped"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kontrak</th>
                                <th>Nomor</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Dokumen</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sp2dses as $sp2ds)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sp2ds->Kontrak->penyedia }}</td>
                                    <td>{{ $sp2ds->nomor }}</td>
                                    <td>{{ $sp2ds->tanggal }}</td>
                                    <td>{{ $sp2ds->jumlah }}</td>
                                    <td>
                                        @if ($sp2ds->dokumen)
                                            <a class="btn btn-primary" href="{{ asset('storage/' . $sp2ds->dokumen) }}"
                                                download><i class="fa-solid fa-download me-2"></i> Dokumen</a>
                                        @else
                                            No document available
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editSp2d{{ $loop->iteration }}">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#hapusSp2d{{ $loop->iteration }}">
                                            <i class="fa-regular fa-trash-can fa-lg"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal Edit Sp2d --}}
                                <x-form_modal>
                                    @slot('id', "editSp2d$loop->iteration")
                                    @slot('title', 'Edit Data Sp2d')
                                    @slot('route', route('sp2d.update', $sp2ds->id))
                                    @slot('method') @method('put') @endslot
                                    @slot('btnPrimaryTitle', 'Perbarui')

                                    <input type="hidden" name="oldDokumen" value="{{ $sp2ds->dokumen }}">
                                    <div class="mb-3">
                                        <label for="nomor" class="form-label">Nomor</label>
                                        <input type="text" class="form-control @error('nomor') is-invalid @enderror"
                                            id="nomor" name="nomor" value="{{ old('nomor', $sp2ds->nomor) }}"
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
                                            id="tanggal" name="tanggal" value="{{ old('tanggal', $sp2ds->tanggal) }}"
                                            autofocus required>
                                        @error('tanggal')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="jumlah" class="form-label">jumlah</label>
                                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                            id="jumlah" name="jumlah" value="{{ old('jumlah', $sp2ds->jumlah) }}"
                                            autofocus required>
                                        @error('jumlah')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="dokumen" class="form-label">Dokumen</label>
                                        <input type="file" class="form-control @error('dokumen') is-invalid @enderror"
                                            id="dokumen" name="dokumen" value="{{ old('dokumen', $sp2ds->dokumen) }}"
                                            autofocus required>
                                        @error('dokumen')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </x-form_modal>
                                {{-- / Modal Edit sp2d --}}

                                {{-- Modal Hapus Sp2d --}}
                                <x-form_modal>
                                    @slot('id', "hapusSp2d$loop->iteration")
                                    @slot('title', 'Hapus Data Surat Sp2d')
                                    @slot('route', route('sp2d.destroy', $sp2ds->id))
                                    @slot('method') @method('delete') @endslot
                                    @slot('btnPrimaryClass', 'btn-outline-danger')
                                    @slot('btnSecondaryClass', 'btn-secondary')
                                    @slot('btnPrimaryTitle', 'Hapus')

                                    <p class="fs-5">Apakah anda yakin akan menghapus data Sp2d
                                        <b>{{ $sp2ds->nomor }}</b>?
                                    </p>

                                </x-form_modal>
                                {{-- / Modal Hapus Sp2d  --}}
                            @endforeach
                        </tbody>
                    </table>
                    {{-- End Table --}}

                    <x-form_modal>
                        @slot('id', 'tambahSp2d')
                        @slot('title', 'Tambah Data Sp2d')
                        @slot('overflow', 'overflow-auto')
                        @slot('route', route('sp2d.store'))

                        @csrf
                        <div class="row">
                            <input type="hidden" name="kontrak_id" value="{{ $sp2d->id }}">
                            <div class="mb-3">
                                <label for="nomor" class="form-label">Nomor</label>
                                <input type="text" class="form-control @error('nomor') is-invalid @enderror"
                                    id="nomor" name="nomor" value="{{ old('nomor') }}"
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
                                    id="tanggal" name="tanggal" value="{{ old('tanggal') }}"
                                    autofocus required>
                                @error('tanggal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">jumlah</label>
                                <input type="text" class="form-control @error('jumlah') is-invalid @enderror"
                                    id="jumlah" name="jumlah" value="{{ old('jumlah') }}"
                                    autofocus required>
                                @error('jumlah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="dokumen" class="form-label">Dokumen</label>
                                <input type="file" class="form-control @error('dokumen') is-invalid @enderror"
                                    id="dokumen" name="dokumen" value="{{ old('dokumen') }}"
                                    autofocus required>
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
