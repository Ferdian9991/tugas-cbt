@extends('layouts.app')

@section('title', @empty($exam) ? 'Tambah Jadwal Ujian' : 'Edit Jadwal Ujian')
@push('php')
    @php
        $isBlank = true;
    @endphp
@endpush

@push('head')
    @vite(['resources/sass/exam_front.scss'])
@endpush

@section('content')
    <div class="container">
        <header class="header">
            <h1>CBT</h1>
        </header>
        <main class="main-content">
            <div style="width: 100%">
                <div class="d-flex justify-content-center align-items-center">
                    <div>
                        <img alt="image" src="{{ asset('img/check.png') }}" style="width:6rem" class="rounded-circle me-3">
                    </div>
                    <div>
                        <h2>Terima kasih telah mengikuti ujian ini</h2>
                        <p style="margin: 0">Nilai ujian tidak ditampilkan oleh Admin, Silakan ditunggu
                            pengumuman nilai dikemudian hari.
                        </p>
                        <a href="{{ route('exam-front.index') }}" class="btn btn-light mt-3">Kembali</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
