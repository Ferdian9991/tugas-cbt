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
                @foreach ($questions as $question)
                    @php
                        $choices = json_decode($question->choices ?? '[]');
                    @endphp
                    <div class="question">
                        <div class="d-flex">
                            <p style="margin-right: 8px; font-weight: bold">{{ $question->number }}. </p>
                            <div class="question-text">
                                @if (!empty($question->header))
                                    <p style="font-weight: bold">{{ $question->header }}</p>
                                @endif

                                @if (!empty($question->text))
                                    <p>{{ $question->text }}</p>
                                @endif
                            </div>
                        </div>
                        @foreach ($choices as $choice)
                            <label>
                                <input class="answer" value="{{ $choice?->number }}" type="radio"
                                    name="q_num_{{ $question->number }}">
                                {{ $choice?->text }}
                            </label>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <aside class="sidebar">
                <div class="user-info">
                    <img src="{{ asset('img/avatar/avatar-1.png') }}" alt="user avatar">
                    <p>{{ auth()->user()->name }}</p>
                    <p>{{ auth()->user()?->participant_number }}</p>
                </div>
                <div class="timer">
                    <p>Durasi Ujian</p>
                    <p class="time"></p>
                </div>
                <button class="submit-button">Kumpulkan Jawaban</button>
            </aside>
        </main>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            startTimer();
        });

        const startTimer = () => {
            const timerElement = document.querySelector('.time');
            let timeInSeconds = Math.floor('{{ $availableTime }}' * 60);

            function formatTime(seconds) {
                const hours = Math.floor(seconds / 3600);
                const minutes = Math.floor((seconds % 3600) / 60);
                const remainingSeconds = seconds % 60;
                return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(remainingSeconds).padStart(2, '0')}`;
            }

            function updateTimer() {
                if (timeInSeconds > 0) {
                    timeInSeconds--;
                    timerElement.textContent = formatTime(timeInSeconds);
                } else {
                    clearInterval(timerInterval);
                    alert("Waktu ujian telah habis!");
                }
            }

            const timerInterval = setInterval(updateTimer, 1000);
            timerElement.textContent = formatTime(timeInSeconds);
        }
    </script>
@endpush
