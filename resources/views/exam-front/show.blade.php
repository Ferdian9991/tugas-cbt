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
            <div class="question-container">
                <div class="question">
                    <p>1. Manakah yang termasuk hari kemerdekaan Indonesia?</p>
                    <label><input type="radio" name="q1"> 17 Agustus 1922</label>
                    <label><input type="radio" name="q1"> 19 Agustus 1922</label>
                    <label><input type="radio" name="q1"> 17 Agustus 1945</label>
                </div>
                <div class="question">
                    <p>2. Manakah yang termasuk buah-buahan?</p>
                    <label><input type="radio" name="q2"> Apel</label>
                    <label><input type="radio" name="q2"> Kucing</label>
                    <label><input type="radio" name="q2"> Hantu</label>
                </div>
                <div class="question">
                    <p>3. Pilihlah kotak yang bentuknya mirip dengan kotak yang dibentuk dari lembaran kertas yang diberikan
                    </p>
                    <img src="image.png" alt="shape question">
                    <label><input type="radio" name="q3"> 1, 2 and 3</label>
                    <label><input type="radio" name="q3"> 1, 3 and 4</label>
                    <label><input type="radio" name="q3"> 2 and 3</label>
                </div>
                <div class="question">
                    <p>4. Apa alat yang digunakan untuk mendesain aplikasi?</p>
                    <label><input type="radio" name="q4"> Figma</label>
                    <label><input type="radio" name="q4"> Filmora</label>
                    <label><input type="radio" name="q4"> Adobe Audition</label>
                </div>
            </div>
            <aside class="sidebar">
                <div class="user-info">
                    <img src="{{ asset('img/avatar/avatar-1.png') }}" alt="user avatar">
                    <p>Aditya Chandra</p>
                    <p>22033771211</p>
                </div>
                <div class="timer">
                    <p>Durasi Ujian</p>
                    <p class="time">00:10:19</p>
                </div>
                <button class="submit-button">Kumpulkan Jawaban</button>
            </aside>
        </main>
    </div>
@endsection
