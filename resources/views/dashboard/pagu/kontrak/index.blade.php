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
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            @endif
        </div>
    </div>

    <button class="btn btn-primary fs-5 fw-normal mt-2" data-bs-toggle="modal" data-bs-target="#tambahKontrak"><i
            class="fa-solid fa-square-plus fs-5 me-2"></i>Tambah
    </button>
    <div class="row mt-3">
        <div class="col">
            <div class="card mt-2">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered table-striped align-middle"
                               style="width:100%">
                            <thead class="text-center align-middle">
                            <tr>
                                <th>NO</th>
                                <th>PAGU</th>
                                <th>CARA PENGADAAN</th>
                                <th>PENYEDIA</th>
                                <th>NOMOR</th>
                                <th>TANGGAL</th>
                                <th>NILAI KONTRAK</th>
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
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $kontrak->Pagu->paket }}</td>
                                    <td>{{ $kontrak->JenisPengadaan->keterangan }}</td>
                                    <td>{{ $kontrak->penyedia }}</td>
                                    <td>{{ $kontrak->nomor }}</td>
                                    <td class="text-center">{{ $kontrak->tanggal->format('d/m/Y') }}</td>
                                    <td>Rp. {{ number_format($kontrak->jumlah, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $kontrak->jangka_waktu }}</td>
                                    @php
                                        if ($kontrak->bukti == 1) {
                                            $bukti = 'YA';
                                        } else {
                                            $bukti = 'TIDAK';
                                        }
                                    @endphp
                                    <td>{{ $bukti }}</td>
                                    <td class="text-end text-nowrap">
                                        Rp. {{ number_format($kontrak->hps, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($kontrak->dokumen)
                                            <a class="btn btn-outline-primary text-nowrap"
                                               data-bs-toggle="tooltip" title="Unduh"
                                               href="{{ asset('storage/' . $kontrak->dokumen) }}"
                                               download><i class="fa-solid fa-download me-1"></i></a>
                                        @else
                                            No document available
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editKontrak{{ $loop->iteration }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#hapusKontrak{{ $loop->iteration }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal Edit Kontrak --}}
                                <x-form_modal>
                                    @slot('id', "editKontrak$loop->iteration")
                                    @slot('title', 'Edit Data Kontrak')
                                    @slot('route', route('kontrak.update', $kontrak->id))
                                    @slot('method')
                                        @method('put')
                                    @endslot
                                    @slot('btnPrimaryTitle', 'Perbarui')
                                    @csrf
                                    <input type="hidden" name="oldDokumen" value="{{ $kontrak->dokumen }}">
                                    <div class="mb-3">
                                        <label for="pagu_id" class="form-label">Pagu</label>
                                        <select class="form-select @error('pagu_id') is-invalid @enderror"
                                                name="pagu_id"
                                                id="pagu_id" value="{{ old('pagu_id', $kontrak->pagu_id) }}">
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
                                        <label for="pengadaan_id" class="form-label">Jenis Pengadaan</label>
                                        <select class="form-select @error('pengadaan_id') is-invalid @enderror"
                                                name="pengadaan_id" id="pengadaan_id"
                                                value="{{ old('pengadaan_id', $kontrak->pengadaan_id) }}">
                                            @foreach ($jenises as $jenis)
                                                @if (old('pengadaan_id', $kontrak->jenis_id) == $jenis->id)
                                                    <option value="{{ $jenis->id }}" selected>
                                                        {{ $jenis->keterangan }}</option>
                                                @else
                                                    <option value="{{ $jenis->id }}">
                                                        {{ $jenis->keterangan }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="penyedia" class="form-label">penyedia</label>
                                        <input type="text" class="form-control @error('penyedia') is-invalid @enderror"
                                               id="penyedia" name="penyedia"
                                               value="{{ old('penyedia', $kontrak->penyedia) }}" required>
                                        @error('penyedia')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor" class="form-label">Nomor</label>
                                        <input type="text" class="form-control @error('nomor') is-invalid @enderror"
                                               id="nomor" name="nomor" value="{{ old('nomor', $kontrak->nomor) }}"
                                               required>
                                        @error('nomor')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                               id="tanggal" name="tanggal"
                                               value="{{ old('tanggal', $kontrak->tanggal->format('Y-m-d')) }}"
                                               required>
                                        @error('tanggal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="jumlah" class="form-label">Nilai Kontrak</label>
                                        <input type="number"
                                               class="form-control @error('jumlah') is-invalid @enderror"
                                               id="jumlah" name="jumlah"
                                               value="{{ old('jumlah', $kontrak->jumlah) }}">
                                        @error('jumlah')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="jangka_waktu" class="form-label">Jangka Waktu</label>
                                        <input type="number"
                                               class="form-control @error('jangka_waktu') is-invalid @enderror"
                                               id="jangka_waktu" name="jangka_waktu"
                                               value="{{ old('jangka_waktu', $kontrak->jangka_waktu) }}"
                                               required>
                                        @error('jangka_waktu')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="bukti" class="form-label">Bukti</label>
                                        <select class="form-select" id="bukti" name="bukti">
                                            <option value="1"
                                                {{ old('bukti', $kontrak->bukti) === 'ya' ? 'selected' : '' }}>Ya
                                            </option>
                                            <option value="0"
                                                {{ old('bukti', $kontrak->bukti) === 'tidak' ? 'selected' : '' }}>Tidak
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="hps" class="form-label">HPS</label>
                                        <input type="number" class="form-control @error('hps') is-invalid @enderror"
                                               id="hps" name="hps" value="{{ old('hps', $kontrak->hps) }}"
                                               required>
                                        @error('hps')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="dokumen" class="form-label">Dokumen</label>
                                        <input type="file" class="form-control @error('dokumen') is-invalid @enderror"
                                               id="dokumen" name="dokumen"
                                               value="{{ old('dokumen', $kontrak->dokumen) }}">
                                        @error('dokumen')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                </x-form_modal>
                                {{-- / Modal Edit Kontrak --}}

                                {{-- Modal Hapus Kontrak --}}
                                <x-form_modal>
                                    @slot('id', "hapusKontrak$loop->iteration")
                                    @slot('title', 'Hapus Data Kontrak')
                                    @slot('route', route('kontrak.destroy', $kontrak->id))
                                    @slot('method')
                                        @method('delete')
                                    @endslot
                                    @slot('btnPrimaryClass', 'btn-outline-danger')
                                    @slot('btnSecondaryClass', 'btn-secondary')
                                    @slot('btnPrimaryTitle', 'Hapus')

                                    <p class="fs-5">Apakah anda yakin akan menghapus data Kontrak
                                        <b>{{ $kontrak->penyedia }}</b>?
                                    </p>
                                </x-form_modal>
                                {{-- / Modal Hapus Kontrak  --}}

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- / Tabel Data ... --}}
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Tambah Kontrak -->
    <x-form_modal>
        @slot('id', 'tambahKontrak')
        @slot('title', 'Tambah Data Kontrak')
        @slot('overflow', 'overflow-auto')
        @slot('route', route('kontrak.store'))

        @csrf
        <div class="row">
            <div class="mb-3">
                <label for="pagu_id" class="form-label">Pagu</label>
                <select class="form-select @error('pagu_id') is-invalid @enderror" name="pagu_id" id="pagu_id"
                        value="{{ old('pagu_id') }}">
                    <option value="">--pilih--</option>
                    @foreach ($pagus as $pagu)
                        <option value="{{ $pagu->id }}">
                            {{ $pagu->paket }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="pengadaan_id" class="form-label">Jenis Pengadaan</label>
                <select class="form-select" id="pengadaan_id" name="pengadaan_id">
                    <option value="">--pilih--</option>
                    @foreach ($jenises as $jenis)
                        <option value="{{ $jenis->id }}">{{ $jenis->keterangan }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="penyedia" class="form-label">penyedia</label>
                <input type="text" class="form-control @error('penyedia') is-invalid @enderror" id="penyedia"
                       name="penyedia" value="{{ old('penyedia') }}" required>
                @error('penyedia')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nomor" class="form-label">Nomor</label>
                <input type="text" class="form-control @error('nomor') is-invalid @enderror" id="nomor"
                       name="nomor" value="{{ old('nomor') }}" required>
                @error('nomor')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                       name="tanggal" value="{{ old('tanggal') }}" required>
                @error('tanggal')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Nilai Kontrak</label>
                <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                       id="jumlah"
                       name="jumlah" value="{{ old('jumlah') }}" required>
                @error('jumlah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jangka_waktu" class="form-label">Jangka Waktu</label>
                <input type="number" class="form-control @error('jangka_waktu') is-invalid @enderror" id="jangka_waktu"
                       name="jangka_waktu" value="{{ old('jangka_waktu') }}" required>
                @error('jangka_waktu')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="bukti" class="form-label">Bukti</label>
                <select class="form-select" id="bukti" name="bukti">
                    <option value="1">Ya</option>
                    <option value="0">Tidak</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="hps" class="form-label">HPS</label>
                <input type="number" class="form-control @error('hps') is-invalid @enderror" id="hps"
                       name="hps" value="{{ old('hps') }}" required>
                @error('hps')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="dokumen" class="form-label">Dokumen</label>
                <input type="file" class="form-control @error('dokumen') is-invalid @enderror"
                       id="dokumen" name="dokumen" value="{{ old('dokumen') }}" required>
                @error('dokumen')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
    </x-form_modal>
    <!-- Akhir Modal Tambah Pagu -->
@endsection
