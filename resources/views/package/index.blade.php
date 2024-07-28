@extends('layouts.app')

@section('content')
    <div class="main-content">
        <div class="row">
            <div class="col-12 row mb-5">
                <div class="col-3">
                    <form action="{{ route('packages.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari paket soal">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
                <div class="col-9 d-flex justify-content-end p-0">
                    <div>
                        <a href="{{ route('packages.create') }}" class="btn btn-primary float-right">Tambah Data</a>
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
                                <th>Kode Paket Soal</th>
                                <th>Nama Paket Soal</th>
                                <th>Terakhir Diubah</th>
                                <th>Dibuat Oleh</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $package)
                                <tr>
                                    <td>{{ $package->code }}</td>
                                    <td>{{ $package->name }}</td>
                                    <td>
                                        {{ $package->updated_at->format('d M Y') }}
                                    </td>
                                    <td>
                                        {{ $package->createdBy?->name }}
                                    </td>
                                    <td>
                                        <a href="{{ route('packages.edit', [$package->id]) }}" class="btn btn-warning"><span
                                                class="far fa-edit"></span>
                                        </a>

                                        <form action="{{ route('packages.destroy', [$package->id]) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data {{ $package->name }}?')">
                                                <span class="far fa-trash-alt"></span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
