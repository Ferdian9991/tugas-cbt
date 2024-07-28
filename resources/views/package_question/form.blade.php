@php
    $question ??= null;
@endphp
@extends('layouts.app')

@section('title', @empty($question) ? 'Tambah Paket Soal' : 'Edit Paket Soal')

@section('content')
    <div class="main-content" style="padding-bottom: 14px">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="mb-3">{{ empty($question) ? 'Tambah' : 'Edit' }} Paket Soal</h4>
                <form method="POST"
                    action="{{ empty($question) ? route('questions.store', [$packageId]) : route('questions.update', [$packageId, $question->id]) }}">
                    @csrf

                    @if ($question)
                        @method('PUT')
                    @endif

                    <div class="card">
                        <div class="card-body">
                            <div class="form-group
                                row">
                                <label for="number" class="col-12 col-form-label text-md-right">Nomor Soal</label>

                                <div class="col-12">
                                    <input id="number" type="number"
                                        class="form-control @error('number') is-invalid @enderror" name="number"
                                        value="{{ old('number', $question?->number) }}" required autocomplete="number"
                                        autofocus>

                                    @error('number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group
                                row">
                                <label for="header" class="col-12 col-form-label text-md-right">Header</label>

                                <div class="col-12">
                                    <input id="header" type="text"
                                        class="form-control @error('header') is-invalid @enderror" name="header"
                                        value="{{ old('header', $question?->header) }}" required autocomplete="header"
                                        autofocus>

                                    @error('header')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group
                                row">
                                <label for="question" class="col-12 col-form-label text-md-right">Pertanyaan</label>

                                <div class="col-12">
                                    <input id="question" type="textarea"
                                        class="form-control @error('question') is-invalid @enderror" name="question"
                                        value="{{ old('question', $question?->question) }}" required autocomplete="question"
                                        autofocus>

                                    @error('question')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-12 d-flex justify-content-end gap-3">
                            <a href="{{ route('questions.index', [$packageId]) }}" class="btn btn-white">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
