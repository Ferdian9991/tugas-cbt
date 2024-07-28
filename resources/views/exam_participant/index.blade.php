@extends('layouts.app')

@section('title', $exam->name)

@section('content')
    <div class="main-content">
        <div class="row">
            <h4 class="mb-3">Peserta Ujian ({{ $exam->name }})</h4>
            <div class="col-12 row mb-5">
                <div class="col-3">
                    <form action="{{ route('participants.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari peserta ujian">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
                <div class="col-9 d-flex justify-content-end p-0">
                    <div>
                        <a href="{{ route('exam_participants.create', [$exam->id]) }}"
                            class="btn btn-primary float-right">Tambah Data</a>
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
                                <th>Nama Peserta</th>
                                <th>Email Peserta</th>
                                <th>Terakhir Diubah</th>
                                <th>Dibuat Oleh</th>
                                <th style="width: 14%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($participants as $participant)
                                @php
                                    $participant = $participant->user;
                                @endphp
                                <tr>
                                    <td>{{ $participant->name }}</td>
                                    <td>{{ $participant->email }}</td>
                                    <td>
                                        {{ $participant->updated_at->format('d M Y') }}
                                    </td>
                                    <td>
                                        {{ $participant->createdBy?->name }}
                                    </td>
                                    <td>
                                        <form action="{{ route('exam_participants.destroy', [$exam->id, $participant->id]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data {{ $participant->name }}?')">
                                                <span class="far fa-trash-alt"></span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($participants->isEmpty())
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
