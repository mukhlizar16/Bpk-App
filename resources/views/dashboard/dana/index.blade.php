@extends('dashboard.layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-6 col-md">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif(session()->has('failed'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('failed') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible" role="alert">
                    @foreach($errors->all() as $error)
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
                    <button class="btn btn-primary mb-3" data-bs-target="#modalTambah" data-bs-toggle="modal">Tambah
                    </button>

                    {{-- Tabel Data Pejabat --}}
                    <table id="myTable" class="table responsive nowrap table-bordered table-striped align-middle"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th>NO</th>
                            <th>KETERANGAN</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($danas as $dana)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $dana->keterangan }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{-- / Tabel Data ... --}}
                </div>
            </div>
        </div>
    </div>

    <x-form_modal id="modalTambah">
        @slot('title', 'Data Sumber Dana')
        @slot('route', route('dana.store'))
        <div class="form-group">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" name="keterangan" id="keterangan" class="form-control"
                   placeholder="masukkan keterangan dana" autofocus>
        </div>
    </x-form_modal>
@endsection
