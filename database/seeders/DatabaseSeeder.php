<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Default Penguji UKK
        $user = User::updateOrCreate(
            ['username' => 'siswa'],
            [
                'name' => 'Siswa Peserta UKK',
                'email' => 'siswa@ukk.local',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Data Contoh Tugas Awal
        Task::updateOrCreate(
            ['id' => 1],
            [
                'user_id' => $user->id,
                'judul' => 'Membuat Laporan UKK RPL (Laravel)',
                'deskripsi' => 'Menyusun dokumentasi proyek to-do list berbasis Laravel dari model, controller hingga blade view.',
                'kategori' => 'Sekolah',
                'prioritas' => 'Tinggi',
                'deadline' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'status' => 'Sedang Dikerjakan',
            ]
        );

        Task::updateOrCreate(
            ['id' => 2],
            [
                'user_id' => $user->id,
                'judul' => 'Belajar Alur MVC & Route Sidang Penguji',
                'deskripsi' => 'Memahami fungsi route web.php, controller, middleware auth, dan migration.',
                'kategori' => 'Sekolah',
                'prioritas' => 'Tinggi',
                'deadline' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'status' => 'Belum Selesai',
            ]
        );

        Task::updateOrCreate(
            ['id' => 3],
            [
                'user_id' => $user->id,
                'judul' => 'Membeli perlengkapan seragam ujian',
                'deskripsi' => 'Beli dasi hitam dan kemeja putih di toko seragam.',
                'kategori' => 'Pribadi',
                'prioritas' => 'Sedang',
                'deadline' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'status' => 'Selesai',
            ]
        );
    }
}
