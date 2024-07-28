@php
    $exam ??= null;
@endphp
@extends('layouts.app')

@section('title', @empty($exam) ? 'Tambah Jadwal Ujian' : 'Edit Jadwal Ujian')

@section('content')
    <div class="main-content" style="padding-bottom: 14px">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="mb-3">{{ empty($exam) ? 'Tambah' : 'Edit' }} Jadwal Ujian</h4>
                <form method="POST" action="{{ empty($exam) ? route('exams.store') : route('exams.update', [$exam->id]) }}">
                    @csrf

                    @if ($exam)
                        @method('PUT')
                    @endif

                    <div class="card">
                        <div class="card-body">

                            <div class="form-group row">
                                <label for="code" class="col-12 col-form-label text-md-right">Kode Ujian</label>

                                <div class="col-12">
                                    <input id="code" type="text"
                                        class="form-control @error('code') is-invalid @enderror" name="code"
                                        value="{{ old('code', $exam?->code) }}" required autocomplete="code" autofocus>

                                    @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-12 col-form-label text-md-right">Nama Ujian</label>

                                <div class="col-12">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name', $exam?->name) }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group
                                row">
                                <label for="start_date" class="col-12 col-form-label text-md-right">Tanggal Mulai
                                    Ujian</label>

                                <div class="col-12">
                                    <input id="start_date" type="date"
                                        class="form-control @error('start_date') is-invalid @enderror" name="start_date"
                                        value="{{ old('start_date', \Carbon\Carbon::parse($exam?->start_date)->format('Y-m-d')) }}"
                                        required autocomplete="start_date" autofocus>

                                    @error('start_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group
                                row">
                                <label for="end_date" class="col-12 col-form-label text-md-right">Tanggal Selesai
                                    Ujian</label>

                                <div class="col-12">
                                    <input id="end_date" type="date"
                                        class="form-control @error('end_date') is-invalid @enderror" name="end_date"
                                        value="{{ old('end_date', \Carbon\Carbon::parse($exam?->end_date)->format('Y-m-d')) }}"
                                        required autocomplete="end_date" autofocus>

                                    @error('end_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- // select package --}}
                            <div class="form-group
                                row">
                                <label for="package_id"
                                    class="col-12 col
                                    -form-label text-md-right">Paket
                                    Soal</label>

                                <div class="col-12">
                                    <select id="package_id" class="form-control @error('package_id') is-invalid @enderror"
                                        name="package_id" required>
                                        <option value="">Pilih Paket Soal</option>
                                        @foreach ($packages as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ old('package_id', $exam?->package_id) == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('package_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group
                                row">
                                <label for="duration"
                                    class="col-12 col
                                    -form-label text-md-right">Durasi
                                    Ujian (menit)</label>

                                <div class="col-12">
                                    <input id="duration" type="number"
                                        class="form-control @error('duration') is-invalid @enderror" name="duration"
                                        value="{{ old('duration', $exam?->duration) }}" required autocomplete="duration"
                                        autofocus>

                                    @error('duration')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group
                                row">
                                <label for="quota"
                                    class="col-12 col
                                    -form-label text-md-right">Kuota
                                    Peserta</label>

                                <div class="col-12">
                                    <input id="quota" type="number"
                                        class="form-control @error('quota') is-invalid @enderror" name="quota"
                                        value="{{ old('quota', $exam?->quota) }}" required autocomplete="quota" autofocus>

                                    @error('quota')
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
                                            @checked($exam?->is_active ?? true)>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Aktif</span>
                                    </label>
                                    <label class="custom-switch">
                                        <input type="radio" name="is_active" value="0"
                                            class="custom-switch-input" @checked(!$exam?->is_active)>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Tidak Aktif</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-12 d-flex justify-content-end gap-3">
                            <a href="{{ route('exams.index') }}" class="btn btn-white">
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
