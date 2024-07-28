@extends('layouts.app')

@section('title', 'Jadwal Ujian')

@section('content')
    <div class="main-content">
        <div class="row">
            <h4 class="mb-3">Jadwal ujian</h4>
            <div class="col-12 row mb-5">
                <div class="col-3">
                    <form action="{{ route('exams.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari jadwal ujian">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
                <div class="col-9 d-flex justify-content-end p-0">
                    <div>
                        <a href="{{ route('exams.create') }}" class="btn btn-primary float-right">Tambah Data</a>
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
                                <th>Kode Ujian</th>
                                <th>Nama Ujian</th>
                                <th>Terakhir Diubah</th>
                                <th>Dibuat Oleh</th>
                                <th style="width: 14%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($exams as $exam)
                                <tr>
                                    <td>{{ $exam->code }}</td>
                                    <td>{{ $exam->name }}</td>
                                    <td>
                                        {{ $exam->updated_at->format('d M Y') }}
                                    </td>
                                    <td>
                                        {{ $exam->createdBy?->name }}
                                    </td>
                                    <td>
                                        <a href="{{ route('exams.edit', [$exam->id]) }}" class="btn btn-warning"><span
                                                class="far fa-edit"></span>
                                        </a>

                                        <form action="{{ route('exams.destroy', [$exam->id]) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data {{ $exam->name }}?')">
                                                <span class="far fa-trash-alt"></span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($exams->isEmpty())
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
