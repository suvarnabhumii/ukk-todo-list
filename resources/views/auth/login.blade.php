@extends('layouts.app')

@section('title', 'Masuk - TaskFlow UKK')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 p-3">
    <div class="auth-clean-card">
        <div class="text-center mb-4">
            <div class="brand-badge mb-2 mx-auto" style="width: 36px; height: 36px;">
                <i class="bi bi-check-lg fs-5"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Masuk ke TaskFlow</h5>
            <p class="text-muted small mb-0">Kelola catatan dan tugas harian UKK Anda</p>
        </div>

        @if (session('sukses'))
            <div class="alert alert-success border-0 rounded-3 py-2 px-3 mb-3 small d-flex align-items-center gap-2" style="background-color: #f0fdf4; color: #166534;">
                <i class="bi bi-check-circle-fill"></i>
                <div>{{ session('sukses') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger border-0 rounded-3 py-2 px-3 mb-3 small" style="background-color: #fef2f2; color: #991b1b;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" autocomplete="off">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label small fw-semibold text-dark">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required autofocus value="{{ old('username') }}">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label small fw-semibold text-dark">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                    <button class="btn btn-outline-secondary border" type="button" id="togglePassword">
                        <i class="bi bi-eye text-muted" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-action-primary w-100 py-2 mt-2">
                Masuk
            </button>
        </form>

        <div class="text-center pt-3 mt-3 border-top">
            <span class="small text-muted">Belum punya akun?</span>
            <a href="{{ route('register') }}" class="small fw-semibold text-decoration-none" style="color: var(--primary);">Daftar di sini</a>
        </div>

        <div class="mt-4 p-3 bg-light rounded-3 border small">
            <span class="fw-bold text-dark d-block mb-1">Akun Penguji UKK:</span>
            <span class="text-muted">Username: <code class="text-dark">siswa</code> &bull; Password: <code class="text-dark">password123</code></span>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const toggleBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            toggleIcon.classList.toggle('bi-eye');
            toggleIcon.classList.toggle('bi-eye-slash');
        });
    }
</script>
@endpush
