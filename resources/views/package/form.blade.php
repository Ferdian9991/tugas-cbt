@php
    $package ??= null;
@endphp
@extends('layouts.app')

@section('title', @empty($package) ? 'Tambah Paket Soal' : 'Edit Paket Soal')

@section('content')
    <div class="main-content">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="mb-3">{{ empty($package) ? 'Tambah' : 'Edit' }} Paket Soal</h4>
                <form method="POST"
                    action="{{ empty($package) ? route('packages.store') : route('packages.update', [$package->id]) }}">
                    @csrf

                    @if ($package)
                        @method('PUT')
                    @endif

                    <div class="card">
                        <div class="card-body">

                            <div class="form-group row">
                                <label for="code" class="col-12 col-form-label text-md-right">Kode Paket Soal</label>

                                <div class="col-12">
                                    <input id="code" type="text"
                                        class="form-control @error('code') is-invalid @enderror" name="code"
                                        value="{{ old('code', $package?->code) }}" required autocomplete="code" autofocus>

                                    @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-12 col-form-label text-md-right">Nama Paket Soal</label>

                                <div class="col-12">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name', $package?->name) }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="control-label">Acak Soal?</div>
                                <div class="custom-switches-stacked mt-2">
                                    <label class="custom-switch">
                                        <input type="radio" name="is_random_question" value="1"
                                            class="custom-switch-input" @checked($package?->is_random_question ?? true)>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Ya</span>
                                    </label>
                                    <label class="custom-switch">
                                        <input type="radio" name="is_random_question" value="0"
                                            class="custom-switch-input" @checked(!$package?->is_random_question)>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Tidak</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="control-label">Acak Jawaban?</div>
                                <div class="custom-switches-stacked mt-2">
                                    <label class="custom-switch">
                                        <input type="radio" name="is_random_choice" value="1"
                                            class="custom-switch-input" @checked($package?->is_random_choice ?? true)>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Ya</span>
                                    </label>
                                    <label class="custom-switch">
                                        <input type="radio" name="is_random_choice" value="0"
                                            class="custom-switch-input" @checked(!$package?->is_random_choice)>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Tidak</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="control-label">Aktif?</div>
                                <div class="custom-switches-stacked mt-2">
                                    <label class="custom-switch">
                                        <input type="radio" name="is_active" value="1" class="custom-switch-input"
                                            @checked($package?->is_active ?? true)>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Aktif</span>
                                    </label>
                                    <label class="custom-switch">
                                        <input type="radio" name="is_active" value="0" class="custom-switch-input"
                                            @checked(!$package?->is_active)>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Tidak Aktif</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-12 d-flex justify-content-end gap-3">
                            <a href="{{ route('packages.index') }}" class="btn btn-white">
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
