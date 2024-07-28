@php
    $admin ??= null;
@endphp
@extends('layouts.app')

@section('title', @empty($admin) ? 'Tambah Admin Aplikasi' : 'Edit Admin Aplikasi')

@section('content')
    <div class="main-content" style="padding-bottom: 14px">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="mb-3">{{ empty($admin) ? 'Tambah' : 'Edit' }} Admin Aplikasi</h4>
                <form method="POST"
                    action="{{ empty($admin) ? route('admins.store') : route('admins.update', [$admin->id]) }}">
                    @csrf

                    @if ($admin)
                        @method('PUT')
                    @endif

                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-12 col-form-label text-md-right">Nama Admin</label>

                                <div class="col-12">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name', $admin?->name) }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group
                                row">
                                <label for="email" class="col-12 col-form-label text-md-right">Email Admin</label>

                                <div class="col-12">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email', $admin?->email) }}" required autocomplete="email" autofocus>

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
                                        value="{{ old('phone', $admin?->phone) }}" required autocomplete="phone" autofocus>

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            @if (empty($admin))
                                <div class="form-group row">
                                    <label for="password" class="col-12 col-form-label text-md-right">Password</label>

                                    <div class="col-12">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <div class="control-label">Aktif?</div>
                                <div class="custom-switches-stacked mt-2">
                                    <label class="custom-switch">
                                        <input type="radio" name="is_active" value="1" class="custom-switch-input"
                                            @checked($admin?->is_active ?? true)>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Aktif</span>
                                    </label>
                                    <label class="custom-switch">
                                        <input type="radio" name="is_active" value="0" class="custom-switch-input"
                                            @checked(!$admin?->is_active)>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Tidak Aktif</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-12 d-flex justify-content-end gap-3">
                            <a href="{{ route('admins.index') }}" class="btn btn-white">
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
