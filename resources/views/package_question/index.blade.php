@extends('layouts.app')

@section('title', $package->name)

@section('content')
    <div class="main-content">
        <h4 class="mb-3">Paket ({{ $package->name }})</h4>
        <div class="row">
            <div class="col-12 row mb-5">
                <div class="col-3">
                    <form action="{{ route('questions.index', [$package->id]) }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari pertanyaan">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
                <div class="col-9 d-flex justify-content-end p-0">
                    <div class="me-3">
                        <a href="{{ route('packages.index') }}" class="btn btn-light float-right">Kembali</a>
                    </div>
                    <div>
                        <a href="{{ route('questions.create', [$package->id]) }}" class="btn btn-primary float-right">Tambah Data</a>
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
                                <th>Nomor Soal</th>
                                <th>Pertanyaan</th>
                                <th>Terakhir Diubah</th>
                                <th>Dibuat Oleh</th>
                                <th style="width: 14%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questions as $question)
                                <tr>
                                    <td>{{ $question->number }}</td>
                                    <td>{{ $question->text }}</td>
                                    <td>
                                        {{ $question->updated_at->format('d M Y') }}
                                    </td>
                                    <td>
                                        {{ $question->createdBy?->name }}
                                    </td>
                                    <td>
                                        <a href="{{ route('questions.edit', [$package->id, $question->id]) }}"
                                            class="btn btn-warning"><span class="far fa-edit"></span>
                                        </a>
                                        <form action="{{ route('questions.destroy', [$package->id, $question->id]) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data {{ $question->name }}?')">
                                                <span class="far fa-trash-alt"></span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($questions->isEmpty())
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
