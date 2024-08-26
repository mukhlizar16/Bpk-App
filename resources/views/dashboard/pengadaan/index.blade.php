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
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible" role="alert">
                    @foreach ($errors->all() as $error)
                        <p class="mb-1">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <div class="card mt-2">
                <div class="card-body">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalTambah"
                        class="btn btn-primary">Tambah</button>
                    <div class="table-resposive mt-3">
                        <table id="myTable" class="table responsive nowrap table-bordered table-striped align-middle"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%">NO</th>
                                    <th>KETERANGAN</th>
                                    <th class="text-center" style="width: 10%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengadaans as $pengadaan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pengadaan->keterangan }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" data-bs-target="#modalEdit{{ $loop->iteration }}"
                                                    data-bs-toggle="modal" class="btn btn-sm btn-warning">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    data-bs-target="#modalHapus{{ $loop->iteration }}"
                                                    data-bs-toggle="modal">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                        {{-- Edit modal --}}
                                        <x-form_modal id="modalEdit{{ $loop->iteration }}">
                                            @slot('title', 'Edit Data Jenis Pengadaan')
                                            @slot('route', route('pengadaan.update', $pengadaan))
                                            @slot('method')
                                                @method('PUT')
                                            @endslot
                                            <div class="form-group">
                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                <input type="text" name="keterangan" id="keterangan" class="form-control"
                                                    value="{{ $pengadaan->keterangan }}" autofocus>
                                            </div>
                                        </x-form_modal>
                                        {{-- End edit modal --}}

                                        {{-- Hapus modal --}}
                                        <x-form_modal>
                                            @slot('id', "modalHapus$loop->iteration")
                                            @slot('title', 'Hapus Data')
                                            @slot('route', route('pengadaan.destroy', $pengadaan))
                                            @slot('method')
                                                @method('delete')
                                            @endslot
                                            @slot('btnPrimaryClass', 'btn-outline-danger')
                                            @slot('btnSecondaryClass', 'btn-secondary')
                                            @slot('btnPrimaryTitle', 'Hapus')

                                            <p class="fs-5">
                                                Yakin akan menghapus data <b>{{ $pengadaan->keterangan }}</b>?
                                            </p>
                                        </x-form_modal>
                                        {{-- End Hapus modal --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-form_modal id="modalTambah">
        @slot('title', 'Data Jenis Pengadaan')
        @slot('route', route('pengadaan.store'))
        <div class="form-group">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" name="keterangan" id="keterangan" class="form-control"
                placeholder="masukkan keterangan dana" autofocus>
        </div>
    </x-form_modal>
@endsection
