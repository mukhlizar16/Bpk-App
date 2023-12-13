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

    <button class="btn btn-primary fs-5 fw-normal mt-2" data-bs-toggle="modal" data-bs-target="#tambahUser"><i
            class="fa-solid fa-square-plus fs-5 me-2"></i>Tambah</button>
    </button>
    <div class="row mt-3">
        <div class="col">
            <div class="card mt-2">
                <ul class="nav nav-pills p-2">
                    <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="{{ route('program.index') }}">Program</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('utama.index') }}">Kegiatan</a>
                    </li>
                </ul>
                <div class="card-body">

                    {{-- Tabel Data User --}}
                    <table id="myTable" class="table responsive nowrap table-bordered table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>KODE</th>
                                <th>KETERANGAN</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($pejabats as $user) --}}
                            <tr>
                                <td>1</td>
                                <td>1</td>
                                <td>Masak</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editUser">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#hapusUser">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            {{-- Modal Edit User --}}
                            {{-- <x-form_modal>
                                    @slot('id', "editUser$loop->iteration")
                                    @slot('title', 'Edit Data User')
                                    @slot('route', route('user.update', $user->id))
                                    @slot('method') @method('put') @endslot
                                    @slot('btnPrimaryTitle', 'Perbarui')

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama</label>
                                        <input type="name" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $user->name) }}" autofocus
                                            required>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                                            id="username" name="username" value="{{ old('username', $user->username) }}"
                                            autofocus required>
                                        @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="isAdmin" class="form-label">Role</label>
                                        <select class="form-select" id="isAdmin" name="isAdmin">
                                            @foreach ([1 => 'Admin', 2 => 'User'] as $bool => $isAdmin)
                                                <option value="{{ $bool }}"
                                                    {{ old('isAdmin', $user->isAdmin) == $bool ? 'selected' : '' }}>
                                                    {{ $isAdmin }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </x-form_modal> --}}
                            {{-- / Modal Edit User --}}

                            {{-- Modal Hapus User --}}
                            {{-- <x-form_modal>
                                    @slot('id', "hapusUser$loop->iteration")
                                    @slot('title', 'Hapus Data User')
                                    @slot('route', route('user.destroy', $user->id))
                                    @slot('method') @method('delete') @endslot
                                    @slot('btnPrimaryClass', 'btn-outline-danger')
                                    @slot('btnSecondaryClass', 'btn-secondary')
                                    @slot('btnPrimaryTitle', 'Hapus')

                                    <p class="fs-5">Apakah anda yakin akan menghapus data user
                                        <b>{{ $user->name }}</b>?
                                    </p>

                                </x-form_modal> --}}
                            {{-- / Modal Hapus User  --}}

                            {{-- @endforeach --}}
                        </tbody>
                    </table>
                    {{-- / Tabel Data ... --}}
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Tambah User -->
    {{-- <x-form_modal>
        @slot('id', 'tambahUser')
        @slot('title', 'Tambah Data User')
        @slot('overflow', 'overflow-auto')
        @slot('route', route('user.store'))

        @csrf
        <div class="row">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="name" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    autofocus required>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                    name="username" autofocus required>
                @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password" autofocus required>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="isAdmin" class="form-label">Role</label>
                <select class="form-select" id="isAdmin" name="isAdmin">
                    <option value="1" selected>Admin</option>
                    <option value="2">User</option>
                </select>
            </div>
        </div>
    </x-form_modal> --}}
    <!-- Akhir Modal Tambah User -->
@endsection
