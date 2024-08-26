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
                    <div class="table-responsive">
                        <table id="paguTable" class="table nowrap table-bordered table-striped align-middle"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">SUB KEGIATAN</th>
                                <th class="text-center">PAKET</th>
                                <th class="text-center">SUMBER DANA</th>
                                <th class="text-center">JUMLAH</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
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
                <label for="subkegiatan" class="form-label">Sub Kegiatan</label>
                <select class="form-select" id="subkegiatan" name="subkegiatan_id" style="width: 100%">
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
                <input type="number" min="0" step="1" class="form-control @error('jumlah') is-invalid @enderror"
                       id="jumlah"
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

    <x-modal-kosong id="editModal">
        @slot('title', 'Edit Data Pagu')
        <form id="editForm" method="post">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="mb-3">
                    <label for="subkegiatanEdit" class="form-label">Sub Kegiatan</label>
                    <select class="form-select @error('subkegiatan_id') is-invalid @enderror"
                            name="subkegiatan_id" id="subkegiatanEdit" style="width: 100%">
                        @foreach ($subs as $sub)
                            <option value="{{ $sub->id }}" selected>
                                {{ $sub->keterangan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="paketEdit" class="form-label">Paket</label>
                    <input type="text" class="form-control @error('paket') is-invalid @enderror"
                           id="paketEdit" name="paket" required>
                    @error('paket')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="sumberEdit" class="form-label">Sumber Dana</label>
                    <select class="form-select @error('sumber_dana_id') is-invalid @enderror"
                            name="sumber_dana_id" id="sumberEdit">
                        @foreach ($danas as $dana)
                            <option value="{{ $dana->id }}">
                                {{ $dana->keterangan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jumlahEdit" class="form-label">Jumlah</label>
                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                           id="jumlahEdit" name="jumlah" required>
                    @error('jumlah')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn {{ $btnSecondaryClass ?? 'btn-outline-secondary' }}"
                        data-bs-dismiss="modal">{{ $btnSecondaryTitle ?? 'Batal' }}</button>
                <button type="submit"
                        class="btn {{ $btnPrimaryClass ?? 'btn-primary' }}">
                    {{ $btnPrimaryTitle ?? 'Simpan' }}
                </button>
            </div>
        </form>
    </x-modal-kosong>

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    @endpush
    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function () {
                const table = $('#paguTable');
                $('#subkegiatan').select2({
                    dropdownParent: $('#tambahPagu')
                });
                $('#subkegiatanEdit').select2({
                    dropdownParent: $('#editModal')
                });
                table.DataTable({
                    serverSide: true,
                    processing: true,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/2.1.4/i18n/id.json',
                    },
                    ajax: '{{ route('pagu.index') }}',
                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            className: 'text-center'
                        },
                        {
                            data: 'subkegiatan.keterangan',
                            name: 'subkegiatan'
                        },
                        {
                            data: 'paket',
                            name: 'paket'

                        },
                        {
                            data: 'sumber_dana.keterangan',
                            name: 'sumber',
                            className: 'text-center'
                        },
                        {
                            data: 'jumlah',
                            name: 'jumlah',
                            render: function (data, type, row) {
                                return new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0,
                                }).format(data);
                            },
                            className: 'text-end'
                        },
                        {
                            data: 'aksi',
                            name: 'aksi'
                        },
                    ],
                    columnDefs: [{orderable: false, targets: 0}]
                });

                table.on('click', '.btn-edit', function () {
                    var id = $(this).data('id');
                    var paket = $(this).data('paket');
                    var sumber = $(this).data('sumber');
                    var subkegiatan = $(this).data('subkegiatan');
                    var jumlah = $(this).data('jumlah');

                    console.log(id, paket, sumber, subkegiatan, jumlah)

                    // Isi form di dalam modal dengan data yang diambil
                    $('#editForm').attr('action', '/pagu/' + id);  // Sesuaikan dengan route update Anda
                    $('#paketEdit').val(paket);
                    $('#jumlahEdit').val(jumlah);
                    $('#subkegiatanEdit').val(subkegiatan);
                    $('#sumberEdit').val(sumber);
                    // Tampilkan modal
                    $('#editModal').modal('show');
                });
            });
        </script>
    @endpush
@endsection
