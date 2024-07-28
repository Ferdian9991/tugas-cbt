@php
    $participant ??= null;
@endphp
@extends('layouts.app')

@section('title', @empty($participant) ? 'Tambah Peserta' : 'Edit Peserta')

@section('content')
    <div class="main-content" style="padding-bottom: 14px">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="mb-3">{{ empty($participant) ? 'Tambah' : 'Edit' }} Peserta</h4>
                <form method="POST"
                    action="{{ empty($participant) ? route('participants.store') : route('participants.update', [$participant->id]) }}">
                    @csrf

                    @if ($participant)
                        @method('PUT')
                    @endif

                    <div class="card">
                        <div class="card-body">
                            <div class="form-group
                                row">
                                <label for="participant_number" class="col-12 col-form-label text-md-right">Nomor
                                    Peserta</label>

                                <div class="col-12">
                                    <input id="participant_number" type="text"
                                        class="form-control @error('participant_number') is-invalid @enderror"
                                        name="participant_number"
                                        value="{{ old('participant_number', $participant?->participant_number) }}" required
                                        autocomplete="participant_number" autofocus>

                                    @error('participant_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-12 col-form-label text-md-right">Nama Peserta</label>

                                <div class="col-12">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name', $participant?->name) }}" required autocomplete="name"
                                        autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group
                                row">
                                <label for="email" class="col-12 col-form-label text-md-right">Email Peserta</label>

                                <div class="col-12">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email', $participant?->email) }}" required autocomplete="email"
                                        autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-12 col-form-label text-md-right">Nomor HP</label>

                                <div class="col-12">
                                    <input id="phone" type="number"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ old('phone', $participant?->phone) }}" required autocomplete="phone"
                                        autofocus>

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="control-label">Aktif?</div>
                                <div class="custom-switches-stacked mt-2">
                                    <label class="custom-switch">
                                        <input type="radio" name="is_active" value="1" class="custom-switch-input"
                                            @checked($participant?->is_active ?? true)>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Aktif</span>
                                    </label>
                                    <label class="custom-switch">
                                        <input type="radio" name="is_active" value="0" class="custom-switch-input"
                                            @checked(!$participant?->is_active)>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Tidak Aktif</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-12 d-flex justify-content-end gap-3">
                            <a href="{{ route('participants.index') }}" class="btn btn-white">
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
