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
            class="fa-solid fa-square-plus fs-5 me-2"></i>Tambah</button>
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
                                <th>PAGU</th>
                                <th>PENYEDIA</th>
                                <th>NOMOR</th>
                                <th>TANGGAL</th>
                                <th>JUMLAH</th>
                                <th>JANGKA WAKTU</th>
                                <th>BUKTI</th>
                                <th>HPS</th>
                                <th>DOKUMEN</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kontraks as $kontrak)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kontrak->Pagu->paket }}</td>
                                    <td>{{ $kontrak->penyedia }}</td>
                                    <td>{{ $kontrak->nomor }}</td>
                                    <td>{{ $kontrak->tanggal }}</td>
                                    <td>{{ $kontrak->jumlah }}</td>
                                    <td>{{ $kontrak->jangka_waktu }}</td>
                                    <td>{{ $kontrak->bukti }}</td>
                                    <td>{{ $kontrak->hps }}</td>
                                    <td>{{ $kontrak->dokumen }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#showKontrak{{ $loop->iteration }}">
                                            <i class="fa-solid fa-list"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editKontrak{{ $loop->iteration }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#hapusKontrak{{ $loop->iteration }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal Edit Kontrak --}}
                                <x-form_modal>
                                    @slot('id', "editKontrak$loop->iteration")
                                    @slot('title', 'Edit Data Kontrak')
                                    @slot('route', route('kontrak.update', $kontrak->id))
                                    @slot('method') @method('put') @endslot
                                    @slot('btnPrimaryTitle', 'Perbarui')

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
                                    <div class="mb-3">
                                        <label for="pengadaan_id" class="form-label">Jenis Pengadaan</label>
                                        <select class="form-select @error('pengadaan_id') is-invalid @enderror"
                                            name="pengadaan_id" id="pengadaan_id"
                                            value="{{ old('pengadaan_id', $pagu->pengadaan_id) }}">
                                            @foreach ($jenises as $jenis)
                                                @if (old('pengadaan_id', $pagu->jenis_id) == $jenis->id)
                                                    <option value="{{ $jenis->id }}" selected>
                                                        {{ $jenis->keterangan }}</option>
                                                @else
                                                    <option value="{{ $jenis->id }}">
                                                        {{ $jenis->keterangan }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </x-form_modal>
                                {{-- / Modal Edit Pagu --}}

                                {{-- Modal Hapus pagu --}}
                                <x-form_modal>
                                    @slot('id', "hapusPagu$loop->iteration")
                                    @slot('title', 'Hapus Data Pagu')
                                    @slot('route', route('pagu.destroy', $pagu->id))
                                    @slot('method') @method('delete') @endslot
                                    @slot('btnPrimaryClass', 'btn-outline-danger')
                                    @slot('btnSecondaryClass', 'btn-secondary')
                                    @slot('btnPrimaryTitle', 'Hapus')

                                    <p class="fs-5">Apakah anda yakin akan menghapus data pagu
                                        <b>{{ $pagu->paket }}</b>?
                                    </p>

                                </x-form_modal>
                                {{-- / Modal Hapus pagu  --}}

                                {{-- Modal Detail Pagu --}}
                                <x-form_modal2>
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

                                </x-form_modal2>
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
            <div class="mb-3">
                <label for="pengadaan_id" class="form-label">Jenis Pengadaan</label>
                <select class="form-select" id="pengadaan_id" name="pengadaan_id">
                    @foreach ($jenises as $jenis)
                        <option value="{{ $jenis->id }}">{{ $jenis->keterangan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </x-form_modal>
    <!-- Akhir Modal Tambah Pagu -->
@endsection
