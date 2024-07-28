@extends('layouts.app')

@section('title', 'Admin Aplikasi')

@section('content')
    <div class="main-content">
        <div class="row">
            <div class="col-12 row mb-5">
                <div class="col-3">
                    <form action="{{ route('admins.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari admin aplikasi">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
                <div class="col-9 d-flex justify-content-end p-0">
                    <div>
                        <a href="{{ route('admins.create') }}" class="btn btn-primary float-right">Tambah Data</a>
                    </div>
                </div>
            </div>
            <div class="col-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible show fade">
                        <div class="alert-body d-flex justify-content-between p-0 align-items-center">
                            {{ session('success') }}
                            <button style="background: none; border:none; color:white; font-size: 18px" class="close"
                                data-dismiss="alert">
                                <span>×</span>
                            </button>
                        </div>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-md">
                        <thead>
                            <tr>
                                <th>Nama Admin</th>
                                <th>Email Admin</th>
                                <th>Terakhir Diubah</th>
                                <th>Dibuat Oleh</th>
                                <th style="width: 14%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        {{ $admin->updated_at->format('d M Y') }}
                                    </td>
                                    <td>
                                        {{ $admin->updatedBy?->name }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admins.edit', [$admin->id]) }}" class="btn btn-warning"><span
                                                class="far fa-edit"></span>
                                        </a>

                                        <form action="{{ route('admins.destroy', [$admin->id]) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data {{ $admin->name }}?')">
                                                <span class="far fa-trash-alt"></span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($admins->isEmpty())
                                <tr>
                                    <td colspan="100" class="text-center">Tidak ada Data</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
