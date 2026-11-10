@extends('layouts.app')

@section('title', 'Daftar - TaskFlow UKK')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 p-3">
    <div class="auth-clean-card my-4">
        <div class="text-center mb-4">
            <div class="brand-badge mb-2 mx-auto" style="width: 36px; height: 36px;">
                <i class="bi bi-person-plus fs-5"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Daftar Akun Baru</h5>
            <p class="text-muted small mb-0">Mulai kelola tugas dan jadwal kegiatan Anda</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger border-0 rounded-3 py-2 px-3 mb-3 small" style="background-color: #fef2f2; color: #991b1b;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" autocomplete="off">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label small fw-semibold text-dark">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Budi Santoso" required value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label for="username" class="form-label small fw-semibold text-dark">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Pilih username unik" required value="{{ old('username') }}">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label small fw-semibold text-dark">Password (Min. 6 Karakter)</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" minlength="6" required>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label small fw-semibold text-dark">Ulangi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ketik ulang password" minlength="6" required>
            </div>

            <button type="submit" class="btn btn-action-primary w-100 py-2">
                Selesaikan Pendaftaran
            </button>
        </form>

        <div class="text-center pt-3 mt-3 border-top">
            <span class="small text-muted">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="small fw-semibold text-decoration-none" style="color: var(--primary);">Masuk di sini</a>
        </div>
    </div>
</div>
@endsection
