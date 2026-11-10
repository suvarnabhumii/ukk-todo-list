@extends('layouts.app')

@section('title', 'Workspace - TaskFlow UKK')
@section('body-class', 'pb-5')

@section('content')
@include('layouts.navbar')

<main class="container mt-4">

    <!-- Notifikasi Alert -->
    @if (session('sukses'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 border shadow-none rounded-3 py-2 px-3 mb-3 small" role="alert" style="background-color: #f0fdf4; border-color: #bbf7d0 !important; color: #166534;">
            <i class="bi bi-check-circle-fill"></i>
            <span class="fw-semibold">{{ session('sukses') }}</span>
            <button type="button" class="btn-close ms-auto py-2" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border shadow-none rounded-3 py-2 px-3 mb-3 small" role="alert" style="background-color: #fef2f2; border-color: #fecaca !important; color: #991b1b;">
            <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Perhatian:</div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close ms-auto py-2" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Workspace Header Bar -->
    <div class="workspace-header">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
            <div>
                <h4 class="fw-bold text-dark mb-0 tracking-tight">Catatan Tugas</h4>
                <div class="text-muted small fw-medium">Kelola aktivitas dan target penyelesaian harian Anda</div>
            </div>
            <div>
                <button class="btn btn-action-primary d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-lg"></i>
                    <span>Tambah Tugas Baru</span>
                </button>
            </div>
        </div>

        <!-- Segmented Filter Tabs -->
        <div class="d-flex flex-wrap align-items-center gap-2 pt-2 border-top">
            <a href="{{ route('dashboard') }}" class="stat-chip {{ !request('status') ? 'active' : '' }}">
                <span>Semua</span>
                <span class="chip-count">{{ $stats['total'] }}</span>
            </a>
            <a href="{{ route('dashboard', array_merge(request()->except('status'), ['status' => 'Belum Selesai'])) }}" class="stat-chip {{ request('status') === 'Belum Selesai' ? 'active' : '' }}">
                <i class="bi bi-circle text-muted" style="font-size: 0.65rem;"></i>
                <span>Belum Selesai</span>
                <span class="chip-count">{{ $stats['belum'] }}</span>
            </a>
            <a href="{{ route('dashboard', array_merge(request()->except('status'), ['status' => 'Sedang Dikerjakan'])) }}" class="stat-chip {{ request('status') === 'Sedang Dikerjakan' ? 'active' : '' }}">
                <i class="bi bi-arrow-repeat text-warning" style="font-size: 0.75rem;"></i>
                <span>Sedang Dikerjakan</span>
                <span class="chip-count">{{ $stats['proses'] }}</span>
            </a>
            <a href="{{ route('dashboard', array_merge(request()->except('status'), ['status' => 'Selesai'])) }}" class="stat-chip {{ request('status') === 'Selesai' ? 'active' : '' }}">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 0.75rem;"></i>
                <span>Selesai</span>
                <span class="chip-count">{{ $stats['selesai'] }}</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="card card-modern p-2 px-3 mb-3">
        <form method="GET" action="{{ route('dashboard') }}" class="row g-2 align-items-center">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="col-12 col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 py-1 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari nama tugas..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <select name="prioritas" class="form-select">
                    <option value="">Semua Prioritas</option>
                    <option value="Tinggi" {{ request('prioritas') === 'Tinggi' ? 'selected' : '' }}>Prioritas Tinggi</option>
                    <option value="Sedang" {{ request('prioritas') === 'Sedang' ? 'selected' : '' }}>Prioritas Sedang</option>
                    <option value="Rendah" {{ request('prioritas') === 'Rendah' ? 'selected' : '' }}>Prioritas Rendah</option>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    <option value="Sekolah" {{ request('kategori') === 'Sekolah' ? 'selected' : '' }}>Sekolah</option>
                    <option value="Pribadi" {{ request('kategori') === 'Pribadi' ? 'selected' : '' }}>Pribadi</option>
                    <option value="Pekerjaan" {{ request('kategori') === 'Pekerjaan' ? 'selected' : '' }}>Pekerjaan</option>
                    <option value="Lainnya" {{ request('kategori') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <div class="col-12 col-md-1 d-flex gap-1">
                <button type="submit" class="btn btn-action-primary w-100 py-2 d-flex align-items-center justify-content-center" title="Filter">
                    <i class="bi bi-filter"></i>
                </button>
                @if (request()->hasAny(['search', 'kategori', 'prioritas']) && (request('search') || request('kategori') || request('prioritas')))
                    <a href="{{ route('dashboard', request()->only('status')) }}" class="btn btn-action-secondary py-2 px-2" title="Reset">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tasks List Container with 100% Guaranteed Strict Table Column Alignment -->
    <div class="tasks-table-container">
        <div class="table-responsive" style="overflow: visible;">
            <table class="table-tasks">
                <colgroup>
                    <col style="width: 48px;">
                    <col> <!-- Flexible task title & desc -->
                    <col style="width: 125px;">
                    <col style="width: 110px;">
                    <col style="width: 110px;">
                    <col style="width: 168px;">
                    <col style="width: 80px;">
                </colgroup>
                <thead>
                    <tr>
                        <th class="text-center"><i class="bi bi-check2"></i></th>
                        <th>Tugas & Catatan</th>
                        <th>Kategori</th>
                        <th>Prioritas</th>
                        <th>Deadline</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($tasks as $task)
                    @php
                        $isDone = ($task->status === 'Selesai');
                        $today = date('Y-m-d');
                        $isOverdue = (!$isDone && !empty($task->deadline) && $task->deadline->format('Y-m-d') < $today);
                    @endphp
                    <tr class="{{ $isDone ? 'task-row-done' : '' }}">
                        <!-- Column 1: Checkbox Toggle -->
                        <td class="text-center">
                            <form action="{{ route('tasks.status', $task) }}" method="POST" class="m-0 p-0">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="{{ $isDone ? 'Belum Selesai' : 'Selesai' }}">
                                <button type="submit" class="btn-task-toggle {{ $isDone ? 'active' : '' }}" title="{{ $isDone ? 'Tandai belum selesai' : 'Tandai selesai' }}">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                        </td>

                        <!-- Column 2: Title & Description -->
                        <td>
                            <div class="task-title {{ $isDone ? 'task-title-done' : '' }}">{{ $task->judul }}</div>
                            @if (!empty($task->deskripsi))
                                <div class="task-desc" title="{{ $task->deskripsi }}">{{ $task->deskripsi }}</div>
                            @endif
                        </td>

                        <!-- Column 3: Category Badge -->
                        <td>
                            <span class="badge-clean">
                                @if ($task->kategori === 'Sekolah')
                                    <i class="bi bi-mortarboard text-muted"></i>
                                @elseif ($task->kategori === 'Pribadi')
                                    <i class="bi bi-person text-muted"></i>
                                @elseif ($task->kategori === 'Pekerjaan')
                                    <i class="bi bi-briefcase text-muted"></i>
                                @else
                                    <i class="bi bi-tag text-muted"></i>
                                @endif
                                <span>{{ $task->kategori }}</span>
                            </span>
                        </td>

                        <!-- Column 4: Priority Indicator -->
                        <td>
                            @if ($task->prioritas === 'Tinggi')
                                <span class="priority-indicator high" title="Prioritas Tinggi">
                                    <i class="bi bi-flag-fill"></i>
                                    <span>Tinggi</span>
                                </span>
                            @elseif ($task->prioritas === 'Sedang')
                                <span class="priority-indicator med" title="Prioritas Sedang">
                                    <i class="bi bi-flag-fill"></i>
                                    <span>Sedang</span>
                                </span>
                            @else
                                <span class="priority-indicator low" title="Prioritas Rendah">
                                    <i class="bi bi-flag"></i>
                                    <span>Rendah</span>
                                </span>
                            @endif
                        </td>

                        <!-- Column 5: Deadline Date -->
                        <td>
                            @if (!empty($task->deadline))
                                <div class="small fw-semibold {{ $isOverdue ? 'text-danger' : 'text-muted' }}" style="font-size: 0.82rem;">
                                    <i class="bi bi-calendar3 me-1"></i>{{ $task->deadline->format('d M') }}
                                </div>
                                @if ($isOverdue)
                                    <span class="badge bg-danger rounded-pill px-2 py-0 fw-bold" style="font-size: 0.65rem;">Terlewat</span>
                                @endif
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>

                        <!-- Column 6: Status Selector with 100% Solid Opaque Dropdown -->
                        <td class="text-center position-relative">
                            @php
                                $statusClass = 'status-belum';
                                $statusIcon = 'bi-circle text-muted';
                                if ($task->status === 'Selesai') {
                                    $statusClass = 'status-selesai';
                                    $statusIcon = 'bi-check-circle-fill text-success';
                                } elseif ($task->status === 'Sedang Dikerjakan') {
                                    $statusClass = 'status-proses';
                                    $statusIcon = 'bi-arrow-repeat text-warning';
                                }
                            @endphp
                            <div class="dropdown">
                                <button class="status-pill-btn {{ $statusClass }} dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-offset="0,6" aria-expanded="false">
                                    <span class="d-inline-flex align-items-center gap-1">
                                        <i class="bi {{ $statusIcon }}" style="font-size: 0.72rem;"></i>
                                        <span>{{ $task->status }}</span>
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end status-dropdown-menu">
                                    <li class="px-3 py-1 text-muted fw-bold" style="font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.05em;">Ubah Status:</li>
                                    <li>
                                        <form action="{{ route('tasks.status', $task) }}" method="POST" class="m-0 p-0">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Belum Selesai">
                                            <button type="submit" class="dropdown-item {{ $task->status === 'Belum Selesai' ? 'active-status' : '' }}">
                                                <i class="bi bi-circle text-muted" style="font-size: 0.75rem;"></i>
                                                <span>Belum Selesai</span>
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('tasks.status', $task) }}" method="POST" class="m-0 p-0">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Sedang Dikerjakan">
                                            <button type="submit" class="dropdown-item {{ $task->status === 'Sedang Dikerjakan' ? 'active-status' : '' }}">
                                                <i class="bi bi-arrow-repeat text-warning" style="font-size: 0.85rem;"></i>
                                                <span>Sedang Dikerjakan</span>
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('tasks.status', $task) }}" method="POST" class="m-0 p-0">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Selesai">
                                            <button type="submit" class="dropdown-item {{ $task->status === 'Selesai' ? 'active-status' : '' }}">
                                                <i class="bi bi-check-circle-fill text-success" style="font-size: 0.85rem;"></i>
                                                <span>Selesai</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>

                        <!-- Column 7: Action Buttons -->
                        <td class="text-end pe-3">
                            <div class="d-inline-flex align-items-center gap-1">
                                <button type="button" class="btn btn-sm btn-outline-secondary border-0 btn-edit p-1"
                                    data-id="{{ $task->id }}"
                                    data-action="{{ route('tasks.update', $task) }}"
                                    data-judul="{{ $task->judul }}"
                                    data-deskripsi="{{ $task->deskripsi }}"
                                    data-kategori="{{ $task->kategori }}"
                                    data-prioritas="{{ $task->prioritas }}"
                                    data-status="{{ $task->status }}"
                                    data-deadline="{{ !empty($task->deadline) ? $task->deadline->format('Y-m-d') : '' }}"
                                    title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline m-0 p-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0 p-1" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 p-4">
                            <div class="text-muted mb-2">
                                <i class="bi bi-check2-circle fs-1"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">Tidak ada tugas pada filter ini</h6>
                            <p class="text-muted small mb-3">Semua target tugas sudah beres atau belum ditambahkan.</p>
                            <button class="btn btn-action-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Tugas Sekarang
                            </button>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Modal Tambah Tugas (Clean) -->
<div class="modal fade modal-clean" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-dark fs-6 mb-0">Tambah Tugas Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold small text-dark">Judul Tugas <span class="text-danger">*</span></label>
                        <input type="text" name="judul" id="judul" class="form-control" placeholder="Contoh: Belajar Praktik Database UKK" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label for="kategori" class="form-label fw-semibold small text-dark">Kategori</label>
                            <select name="kategori" id="kategori" class="form-select">
                                <option value="Sekolah">Sekolah</option>
                                <option value="Pribadi">Pribadi</option>
                                <option value="Pekerjaan">Pekerjaan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="prioritas" class="form-label fw-semibold small text-dark">Prioritas</label>
                            <select name="prioritas" id="prioritas" class="form-select">
                                <option value="Rendah">Rendah</option>
                                <option value="Sedang" selected>Sedang</option>
                                <option value="Tinggi">Tinggi</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="deadline" class="form-label fw-semibold small text-dark">Batas Waktu (Deadline)</label>
                        <input type="date" name="deadline" id="deadline" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="mb-2">
                        <label for="deskripsi" class="form-label fw-semibold small text-dark">Keterangan / Catatan Tambahan</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" placeholder="Tuliskan catatan penting atau instruksi tugas..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-action-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-action-primary btn-sm">
                        Simpan Tugas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Tugas (Clean) -->
<div class="modal fade modal-clean" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-dark fs-6 mb-0">Edit Catatan Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_judul" class="form-label fw-semibold small text-dark">Judul Tugas <span class="text-danger">*</span></label>
                        <input type="text" name="judul" id="edit_judul" class="form-control" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label for="edit_kategori" class="form-label fw-semibold small text-dark">Kategori</label>
                            <select name="kategori" id="edit_kategori" class="form-select">
                                <option value="Sekolah">Sekolah</option>
                                <option value="Pribadi">Pribadi</option>
                                <option value="Pekerjaan">Pekerjaan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="edit_prioritas" class="form-label fw-semibold small text-dark">Prioritas</label>
                            <select name="prioritas" id="edit_prioritas" class="form-select">
                                <option value="Rendah">Rendah</option>
                                <option value="Sedang">Sedang</option>
                                <option value="Tinggi">Tinggi</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label for="edit_status" class="form-label fw-semibold small text-dark">Status</label>
                            <select name="status" id="edit_status" class="form-select">
                                <option value="Belum Selesai">Belum Selesai</option>
                                <option value="Sedang Dikerjakan">Sedang Dikerjakan</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="edit_deadline" class="form-label fw-semibold small text-dark">Batas Waktu (Deadline)</label>
                            <input type="date" name="deadline" id="edit_deadline" class="form-control">
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="edit_deskripsi" class="form-label fw-semibold small text-dark">Keterangan / Catatan</label>
                        <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-action-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-action-primary btn-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'));
        const formEdit = document.getElementById('formEdit');
        const editButtons = document.querySelectorAll('.btn-edit');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                formEdit.action = this.dataset.action;
                document.getElementById('edit_judul').value = this.dataset.judul;
                document.getElementById('edit_deskripsi').value = this.dataset.deskripsi;
                document.getElementById('edit_kategori').value = this.dataset.kategori;
                document.getElementById('edit_prioritas').value = this.dataset.prioritas;
                document.getElementById('edit_status').value = this.dataset.status;
                document.getElementById('edit_deadline').value = this.dataset.deadline;

                modalEdit.show();
            });
        });
    });
</script>
@endpush
