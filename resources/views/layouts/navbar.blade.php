<!-- Workspace Top Navigation -->
<header class="workspace-navbar sticky-top">
    <div class="container py-2 d-flex align-items-center justify-content-between">
        <a class="d-flex align-items-center gap-2 text-decoration-none" href="{{ route('dashboard') }}">
            <div class="brand-badge">
                <i class="bi bi-check-lg"></i>
            </div>
            <div>
                <span class="fw-bold text-dark fs-6 d-block lh-1">TaskFlow</span>
                <span class="text-muted" style="font-size: 0.72rem; font-weight: 600;">UKK Workspace</span>
            </div>
        </a>

        <div class="d-flex align-items-center gap-2">
            <div class="dropdown">
                <button class="btn btn-sm btn-action-secondary dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle text-muted"></i>
                    <span class="fw-semibold">{{ Auth::user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border p-1 rounded-3 mt-1 small">
                    <li class="px-3 py-2 border-bottom mb-1">
                        <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">{{ '@' . Auth::user()->username }}</div>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2 py-2 rounded-2" onclick="return confirm('Apakah Anda yakin ingin logout?');">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Keluar Akun</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
