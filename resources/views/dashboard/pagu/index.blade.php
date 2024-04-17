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

    <button class="btn btn-primary fs-5 fw-normal mt-2" data-bs-toggle="modal" data-bs-target="#tambahPagu"><i
            class="fa-solid fa-square-plus fs-5 me-2"></i>Tambah
    </button>
    <a class="btn btn-success fs-5 fw-normal mt-2" href="{{ route('pagu.export-all') }}"><i
            class="fa-solid fa-file fs-5 me-2"></i>Download Excel</a>
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
                                <th>SUB KEGIATAN</th>
                                <th>PAKET</th>
                                <th>SUMBER DANA</th>
                                <th>JUMLAH</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pagus as $pagu)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $pagu->Subkegiatan->keterangan }}</td>
                                    <td>{{ $pagu->paket }}</td>
                                    <td class="text-center">{{ $pagu->SumberDana->keterangan }}</td>
                                    <td class="text-end text-nowrap">Rp. {{ number_format($pagu->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editPagu{{ $loop->iteration }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#hapusPagu{{ $loop->iteration }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal Edit Pagu --}}
                                <x-form_modal>
                                    @slot('id', "editPagu$loop->iteration")
                                    @slot('title', 'Edit Data Pagu')
                                    @slot('route', route('pagu.update', $pagu->id))
                                    @slot('method')
                                        @method('put')
                                    @endslot
                                    @slot('btnPrimaryTitle', 'Perbarui')

                                    <div class="mb-3">
                                        <label for="subkegiatan_id" class="form-label">Sub Kegiatan</label>
                                        <select class="form-select @error('subkegiatan_id') is-invalid @enderror"
                                            name="subkegiatan_id" id="subkegiatan_id"
                                            value="{{ old('subkegiatan_id', $pagu->subkegiatan_id) }}">
                                            @foreach ($subs as $sub)
                                                @if (old('subkegiatan_id', $pagu->sub_id) == $sub->id)
                                                    <option value="{{ $sub->id }}" selected>
                                                        {{ $sub->keterangan }}</option>
                                                @else
                                                    <option value="{{ $sub->id }}">
                                                        {{ $sub->keterangan }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="paket" class="form-label">Paket</label>
                                        <input type="text" class="form-control @error('paket') is-invalid @enderror"
                                            id="paket" name="paket" value="{{ old('paket', $pagu->paket) }}"
                                            autofocus required>
                                        @error('paket')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="sumber_dana_id" class="form-label">Sumber Dana</label>
                                        <select class="form-select @error('sumber_dana_id') is-invalid @enderror"
                                            name="sumber_dana_id" id="sumber_dana_id"
                                            value="{{ old('sumber_dana_id', $pagu->sumber_dana_id) }}">
                                            @foreach ($danas as $dana)
                                                @if (old('sumber_dana_id', $pagu->dana_id) == $dana->id)
                                                    <option value="{{ $dana->id }}" selected>
                                                        {{ $dana->keterangan }}</option>
                                                @else
                                                    <option value="{{ $dana->id }}">
                                                        {{ $dana->keterangan }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jumlah" class="form-label">Jumlah</label>
                                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                            id="jumlah" name="jumlah" autofocus
                                            value="{{ old('jumlah', $pagu->jumlah) }}" required>
                                        @error('jumlah')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </x-form_modal>
                                {{-- / Modal Edit Pagu --}}

                                {{-- Modal Hapus pagu --}}
                                <x-form_modal>
                                    @slot('id', "hapusPagu$loop->iteration")
                                    @slot('title', 'Hapus Data Pagu')
                                    @slot('route', route('pagu.destroy', $pagu->id))
                                    @slot('method')
                                        @method('delete')
                                    @endslot
                                    @slot('btnPrimaryClass', 'btn-outline-danger')
                                    @slot('btnSecondaryClass', 'btn-secondary')
                                    @slot('btnPrimaryTitle', 'Hapus')

                                    <p class="fs-5">Apakah anda yakin akan menghapus data pagu
                                        <b>{{ $pagu->paket }}</b>?
                                    </p>

                                </x-form_modal>
                                {{-- / Modal Hapus pagu  --}}

                                {{-- Modal Detail Pagu --}}
                                {{-- <x-form_modal2>
                                @slot('id', "showPagu$loop->iteration")
                                @slot('title', 'Show Data Pagu')

                                <div class="row">
                                    <div class="mb-2 col-lg-4">
                                        <a href="{{ route('keuangan.show', $pagu->id) }}">
                                            <div class="card shadow">
                                                <div class="card-body text-center">
                                                    Keuangan
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="mb-2 col-lg-4">
                                        <a href="{{ route('fisik.show', $pagu->id) }}">
                                            <div class="card shadow">
                                                <div class="card-body text-center">
                                                    Fisik
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="mb-2 col-lg-4">
                                        <a href="{{ route('spmk.show', $pagu->id) }}">
                                            <div class="card shadow">
                                                <div class="card-body text-center">
                                                    SPMK
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                            </x-form_modal2> --}}
                                {{-- / Modal Detail Pagu --}}
                            @endforeach
                        </tbody>
                    </table>
                    {{-- / Tabel Data ... --}}
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Tambah Pagu -->
    <x-form_modal>
        @slot('id', 'tambahPagu')
        @slot('title', 'Tambah Data Pagu')
        @slot('overflow', 'overflow-auto')
        @slot('route', route('pagu.store'))

        @csrf
        <div class="row">
            <div class="mb-3">
                <label for="subkegiatan_id" class="form-label">Sub Kegiatan</label>
                <select class="form-select" id="subkegiatan_id" name="subkegiatan_id">
                    @foreach ($subs as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->keterangan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="paket" class="form-label">Paket</label>
                <input type="text" class="form-control @error('paket') is-invalid @enderror" id="paket"
                    name="paket" autofocus required>
                @error('paket')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="sumber_dana_id" class="form-label">Sumber Dana</label>
                <select class="form-select" id="sumber_dana_id" name="sumber_dana_id">
                    @foreach ($danas as $dana)
                        <option value="{{ $dana->id }}">{{ $dana->keterangan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah"
                    name="jumlah" autofocus required>
                @error('jumlah')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

        </div>
    </x-form_modal>
    <!-- Akhir Modal Tambah Pagu -->
@endsection
