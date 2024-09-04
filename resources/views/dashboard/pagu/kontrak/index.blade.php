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
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
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
                        <table id="kontrakTable" class="table table-bordered table-striped align-middle">
                            <thead class="align-middle">
                                <tr>
                                    <th>NO</th>
                                    <th>PAGU</th>
                                    <th>CARA PENGADAAN</th>
                                    <th>PENYEDIA</th>
                                    <th>NOMOR</th>
                                    <th class="text-center">TANGGAL</th>
                                    <th class="text-center">NILAI KONTRAK</th>
                                    <th class="text-center">JANGKA WAKTU</th>
                                    <th>BUKTI</th>
                                    <th class="text-center">HPS</th>
                                    <th class="text-center">DOKUMEN</th>
                                    <th class="text-center">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
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
        <div class="mb-3">
            <label for="pagu" class="form-label">Pagu</label>
            <select class="form-select @error('pagu_id') is-invalid @enderror" name="pagu_id" id="pagu"
                style="width: 100%">
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
            <input type="text" class="form-control @error('nomor') is-invalid @enderror" id="nomor" name="nomor"
                value="{{ old('nomor') }}" required>
            @error('nomor')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal"
                value="{{ old('tanggal') }}" required>
            @error('tanggal')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Nilai Kontrak</label>
            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah"
                value="{{ old('jumlah') }}" required>
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
            <input type="number" class="form-control @error('hps') is-invalid @enderror" id="hps" name="hps"
                value="{{ old('hps') }}" required>
            @error('hps')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="dokumen" class="form-label">Dokumen</label>
            <input type="file" class="form-control @error('dokumen') is-invalid @enderror" id="dokumen"
                name="dokumen" value="{{ old('dokumen') }}" required>
            @error('dokumen')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </x-form_modal>
    <!-- Akhir Modal Tambah Pagu -->

    {{-- Modal Edit --}}
    <x-modal-kosong>
        @slot('id', 'editModal')
        @slot('title', 'Edit Data Kontrak')
        @slot('overflow', 'overflow-auto')
        <form id="formEdit" method="post">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="mb-3">
                    <label for="pagu_edit" class="form-label">Pagu</label>
                    <select class="form-select" name="pagu_id" id="pagu_edit" style="width: 100%">
                        @foreach ($pagus as $pagu)
                            <option value="{{ $pagu->id }}">{{ $pagu->paket }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="pengadaan_edit" class="form-label">Jenis Pengadaan</label>
                    <select class="form-select" name="pengadaan_id" id="pengadaan_edit">
                        @foreach ($jenises as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->keterangan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="penyedia_edit" class="form-label">penyedia</label>
                    <input type="text" class="form-control" id="penyedia_edit" name="penyedia" required>
                    @error('penyedia')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="nomor_edit" class="form-label">Nomor</label>
                    <input type="text" class="form-control" id="nomor_edit" name="nomor" required>
                    @error('nomor')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="tanggal_edit" class="form-label">Tanggal</label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal_edit"
                        name="tanggal" required>
                    @error('tanggal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="jumlah_edit" class="form-label">Nilai Kontrak</label>
                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah_edit"
                        name="jumlah">
                    @error('jumlah')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="jangka_waktu_edit" class="form-label">Jangka Waktu</label>
                    <input type="number" class="form-control" id="jangka_waktu_edit" name="jangka_waktu" required>
                    @error('jangka_waktu')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="bukti_edit" class="form-label">Bukti</label>
                    <select class="form-select" id="bukti_edit" name="bukti">
                        <option value="1">Ya</option>
                        <option value="0">Tidak</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="hps_edit" class="form-label">HPS</label>
                    <input type="number" class="form-control" id="hps_edit" name="hps" required>
                    @error('hps')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="dokumen_edit" class="form-label">Dokumen</label>
                    <input type="file" class="form-control" id="dokumen_edit" name="dokumen">
                    @error('dokumen')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary"
                    data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>

    </x-modal-kosong>
    {{-- End Modal Edit --}}

    {{-- Modal Hapus Kontrak --}}
    <x-form_modal>
        @slot('id', 'modalHapus')
        @slot('title', 'Hapus Data Kontrak')
        @slot('formId', 'formDelete')
        @slot('method')
            @method('delete')
        @endslot
        @slot('btnPrimaryClass', 'btn-outline-danger')
        @slot('btnSecondaryClass', 'btn-secondary')
        @slot('btnPrimaryTitle', 'Hapus')

        <p class="fs-5" id="text">
        </p>
    </x-form_modal>
    {{-- / Modal Hapus Kontrak  --}}

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $('document').ready(function() {
                $('#pagu').select2({
                    dropdownParent: $('#tambahKontrak'),
                    allowClear: true,
                    placeholder: '--pilih--',
                });
                $('#pagu_edit').select2({
                    dropdownParent: $('#editModal'),
                    allowClear: true,
                    placeholder: '--pilih--',
                });

                var table = $('#kontrakTable').DataTable({
                    serverSide: true,
                    processing: true,
                    lengthMenu: [
                        [5, 10, 25, 50, 100, 250, -1],
                        [5, 10, 25, 50, 100, 250, "All"]
                    ],
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/2.1.4/i18n/id.json',
                    },
                    ajax: '{{ route('kontrak.index') }}',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            className: 'text-center'
                        },
                        {
                            data: 'pagu.paket',
                            name: 'pagu.paket'
                        },
                        {
                            data: 'jenis_pengadaan.keterangan',
                            name: 'jenis_pengadaan.keterangan'
                        },
                        {
                            data: 'penyedia',
                            name: 'penyedia',
                            className: 'text-nowrap'
                        },
                        {
                            data: 'nomor',
                            name: 'nomor'
                        },
                        {
                            data: 'tanggal',
                            name: 'tanggal',
                            render: function(data, type, row) {
                                return moment(data).format('DD/MM/YYYY');
                            },
                            className: 'text-center'
                        },
                        {
                            data: 'jumlah',
                            name: 'jumlah',
                            render: $.fn.dataTable.render.number('.', ',', 0, 'Rp '),
                            className: 'text-end text-nowrap'
                        },
                        {
                            data: 'jangka_waktu',
                            name: 'jangka_waktu',
                            className: 'text-center'
                        },
                        {
                            data: 'bukti',
                            name: 'bukti',
                            className: 'text-center',
                            render: function(data, type, row) {
                                if (data == 1) {
                                    return 'Ya';
                                } else {
                                    return 'Tidak';
                                }
                            }
                        },
                        {
                            data: 'hps',
                            name: 'hps',
                            render: function(data, type, row) {
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
                            data: 'dokumen',
                            name: 'dokumen',
                            className: 'text-center'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            className: 'text-center'
                        }
                    ]
                });

                // edit
                $('#kontrakTable').on('click', '.btn-edit', function() {
                    const id = $(this).data('id');
                    $.ajax({
                        url: `/dashboard/kontrak/${id}/edit`, // URL endpoint untuk mengambil data kontrak
                        method: 'GET',
                        success: function(data) {
                            $('#editModal #pagu_edit').val(data.pagu_id).trigger('change');
                            $('#editModal #pengadaan_edit').val(data.pengadaan_id);
                            $('#editModal #penyedia_edit').val(data.penyedia);
                            $('#editModal #nomor_edit').val(data.nomor);
                            $('#editModal #tanggal_edit').val(moment(data.tanggal).format(
                                'YYYY-MM-DD'));
                            $('#editModal #jumlah_edit').val(data.jumlah);
                            $('#editModal #jangka_waktu_edit').val(data.jangka_waktu);
                            $('#editModal #bukti_edit').val(data.bukti);
                            $('#editModal #hps_edit').val(data.hps);

                            // Update action form pada modal
                            $('#formEdit').attr('action', `/dashboard/kontrak/${id}`);

                            // Tampilkan modal
                            $('#editModal').modal('show');
                        }
                    });
                });

                // hapus
                $('#kontrakTable').on('click', '.btn-delete', function() {
                    const id = $(this).data('id');
                    const nomor = $(this).data('nomor');
                    $('#formDelete').attr('action', `kontrak/${id}`);
                    $('#text').html(
                        `Apakah anda yakin akan menghapus data kontrak dengan nomor: <b>${nomor}</b>`);
                    $('#modalHapus').modal('show');
                });
            });
        </script>
    @endpush
@endsection
