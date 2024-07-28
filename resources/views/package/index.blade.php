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
                        <a class="btn btn-primary float-right">Tambah Data</a>
                    </div>
                </div>
            </div>
            <div class="col-12">
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
                            <tr>
                                @foreach ($packages as $package)
                                    <td>{{ $package->code }}</td>
                                    <td>{{ $package->name }}</td>
                                    <td>
                                        {{ $package->updated_at->format('d M Y') }}
                                    </td>
                                    <td>
                                        {{ $package->createdBy?->name }}
                                    </td>
                                    <td>
                                        <a class="btn btn-warning"><span class="far fa-edit"></span></a>
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
