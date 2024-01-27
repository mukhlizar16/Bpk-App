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
            <button class="btn btn-primary fs-5 fw-normal mt-2" data-bs-toggle="modal" data-bs-target="#tambahAdendum">
                <i
                    class="fa-solid fa-square-plus fs-5 me-2"></i>Tambah
            </button>

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
                            <th>Keterangan</th>
                            <th>Dokumen</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($adendumses as $adendums)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $adendums->Kontrak->Pagu->paket }}</td>
                                <td>{{ $adendums->nomor }}</td>
                                <td>{{ \Carbon\Carbon::parse($adendums->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ $adendums->keterangan }}</td>
                                <td>
                                    @if ($adendums->dokumen)
                                        <a class="btn btn-primary" href="{{ asset('storage/' . $adendums->dokumen) }}"
                                           download><i class="fa-solid fa-download me-2"></i> Dokumen</a>
                                    @else
                                        No document available
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAdendum{{ $loop->iteration }}">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#hapusAdendum{{ $loop->iteration }}">
                                        <i class="fa-regular fa-trash-can fa-lg"></i>
                                    </button>
                                </td>
                            </tr>

                            {{-- Modal Edit adendum --}}
                            <x-form_modal>
                                @slot('id', "editAdendum$loop->iteration")
                                @slot('title', 'Edit Data Adendum')
                                @slot('route', route('adendum.update', $adendums->id))
                                @slot('method')
                                    @method('put')
                                @endslot
                                @slot('btnPrimaryTitle', 'Perbarui')

                                <input type="hidden" name="oldDokumen" value="{{ $adendums->dokumen }}">

                                <div class="mb-3">
                                    <label for="kontrak_id" class="form-label">Kontrak</label>
                                    <select class="form-select @error('kontrak_id') is-invalid @enderror"
                                            name="kontrak_id" id="kontrak_id"
                                            value="{{ old('kontrak_id', $adendums->kontrak_id) }}">
                                        @foreach ($kontraks as $kontrak)
                                            @if (old('kontrak_id', $adendums->kontrak_id) == $kontrak->id)
                                                <option value="{{ $kontrak->id }}" selected>
                                                    {{ $kontrak->nomor }}</option>
                                            @else
                                                <option value="{{ $kontrak->id }}">
                                                    {{ $kontrak->nomor }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="nomor" class="form-label">Nomor</label>
                                    <input type="text" class="form-control @error('nomor') is-invalid @enderror"
                                           id="nomor" name="nomor" value="{{ old('nomor', $adendums->nomor) }}"
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
                                           id="tanggal" name="tanggal" value="{{ old('tanggal', $adendums->tanggal) }}"
                                           autofocus required>
                                    @error('tanggal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                           id="keterangan" name="keterangan"
                                           value="{{ old('keterangan', $adendums->keterangan) }}" autofocus required>
                                    @error('keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="dokumen" class="form-label">Dokumen</label>
                                    <input type="file" class="form-control @error('dokumen') is-invalid @enderror"
                                           id="dokumen" name="dokumen" value="{{ old('dokumen', $adendums->dokumen) }}"
                                           autofocus>
                                    @error('dokumen')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </x-form_modal>
                            {{-- / Modal Edit adendum --}}

                            {{-- Modal Hapus adendum --}}
                            <x-form_modal>
                                @slot('id', "hapusAdendum$loop->iteration")
                                @slot('title', 'Hapus Data Surat Adendum')
                                @slot('route', route('adendum.destroy', $adendums->id))
                                @slot('method')
                                    @method('delete')
                                @endslot
                                @slot('btnPrimaryClass', 'btn-outline-danger')
                                @slot('btnSecondaryClass', 'btn-secondary')
                                @slot('btnPrimaryTitle', 'Hapus')

                                <p class="fs-5">Apakah anda yakin akan menghapus data Adendum
                                    <b>{{ $adendums->nomor }}</b>?
                                </p>

                            </x-form_modal>
                            {{-- / Modal Hapus adendum  --}}
                        @endforeach
                        </tbody>
                    </table>
                    {{-- End Table --}}

                    <x-form_modal>
                        @slot('id', 'tambahAdendum')
                        @slot('title', 'Tambah Data Adendum')
                        @slot('overflow', 'overflow-auto')
                        @slot('route', route('adendum.store'))

                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <label for="kontrak_id" class="form-label">Kontrak</label>
                                <select class="form-select @error('kontrak_id') is-invalid @enderror"
                                        name="kontrak_id" id="kontrak_id">
                                    @foreach ($kontraks as $kontrak)
                                        <option value="{{ $kontrak->id }}" selected>
                                            {{ $kontrak->nomor }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nomor" class="form-label">Nomor</label>
                                <input type="text" class="form-control @error('nomor') is-invalid @enderror"
                                       id="nomor" name="nomor" value="{{ old('nomor') }}" autofocus required>
                                @error('nomor')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                       id="tanggal" name="tanggal" value="{{ old('tanggal') }}" autofocus required>
                                @error('tanggal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                       id="keterangan" name="keterangan" value="{{ old('keterangan') }}" autofocus
                                       required>
                                @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="dokumen" class="form-label">Dokumen</label>
                                <input type="file" class="form-control @error('dokumen') is-invalid @enderror"
                                       id="dokumen" name="dokumen" value="{{ old('dokumen') }}" autofocus required>
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
