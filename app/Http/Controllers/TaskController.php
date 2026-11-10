<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Tampilkan halaman dashboard beserta daftar tugas dan ringkasan statistik
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        // 1. Hitung Statistik Tugas Pengguna
        $stats = [
            'total'   => Task::where('user_id', $userId)->count(),
            'belum'   => Task::where('user_id', $userId)->where('status', 'Belum Selesai')->count(),
            'proses'  => Task::where('user_id', $userId)->where('status', 'Sedang Dikerjakan')->count(),
            'selesai' => Task::where('user_id', $userId)->where('status', 'Selesai')->count(),
        ];

        // 2. Query Daftar Tugas dengan Filter & Pencarian
        $query = Task::where('user_id', $userId);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->prioritas);
        }

        // Urutkan tugas: belum selesai di atas, deadline terdekat lebih dulu
        $tasks = $query->orderByRaw("CASE WHEN status = 'Selesai' THEN 2 ELSE 1 END")
                      ->orderBy('deadline', 'asc')
                      ->orderBy('id', 'desc')
                      ->get();

        return view('dashboard', compact('stats', 'tasks'));
    }

    /**
     * Simpan tugas baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'kategori'  => 'required|in:Sekolah,Pribadi,Pekerjaan,Lainnya',
            'prioritas' => 'required|in:Rendah,Sedang,Tinggi',
            'deadline'  => 'nullable|date',
        ], [
            'judul.required' => 'Judul tugas wajib diisi!',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status']  = 'Belum Selesai';

        Task::create($validated);

        return redirect()->route('dashboard')->with('sukses', 'Tugas baru berhasil ditambahkan!');
    }

    /**
     * Perbarui data tugas
     */
    public function update(Request $request, Task $task)
    {
        // Pastikan hanya pemilik tugas yang bisa mengubah
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $validated = $request->validate([
            'judul'     => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'kategori'  => 'required|in:Sekolah,Pribadi,Pekerjaan,Lainnya',
            'prioritas' => 'required|in:Rendah,Sedang,Tinggi',
            'status'    => 'required|in:Belum Selesai,Sedang Dikerjakan,Selesai',
            'deadline'  => 'nullable|date',
        ], [
            'judul.required' => 'Judul tugas wajib diisi!',
        ]);

        $task->update($validated);

        return redirect()->route('dashboard')->with('sukses', 'Tugas berhasil diperbarui!');
    }

    /**
     * Ubah status tugas secara cepat (Quick Status Toggle)
     */
    public function updateStatus(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $validated = $request->validate([
            'status' => 'required|in:Belum Selesai,Sedang Dikerjakan,Selesai',
        ]);

        $task->update(['status' => $validated['status']]);

        return redirect()->route('dashboard')->with('sukses', 'Status tugas berhasil diperbarui!');
    }

    /**
     * Hapus tugas
     */
    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $task->delete();

        return redirect()->route('dashboard')->with('sukses', 'Tugas berhasil dihapus!');
    }
}
