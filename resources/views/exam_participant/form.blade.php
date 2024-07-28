@php
    $participant ??= null;
@endphp
@extends('layouts.app')

@section('title', 'Tambah Peserta')

@section('content')
    <div class="main-content" style="padding-bottom: 14px">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="mb-3">Tambah Peserta</h4>
                <form method="POST" action="{{ route('exam_participants.store', [$examId]) }}">
                    @csrf

                    <div class="card">
                        <div class="card-body">
                            <div class="form-group
                                row">
                                <label for="user_id" class="col-12 col-form-label text-md-right">Peserta</label>
                                <div class="col-12">
                                    <select name="user_id" id="user_id"
                                        class="form-control @error('user_id') is-invalid @enderror">
                                        <option value="">Pilih Peserta</option>
                                        @foreach ($availableParticipants as $participant)
                                            <option value="{{ $participant->id }}">{{ $participant->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
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
                            <a href="{{ route('exam_participants.index', [$examId]) }}" class="btn btn-white">
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
