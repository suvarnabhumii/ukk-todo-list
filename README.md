# Aplikasi To-Do List Siswa UKK (Framework Laravel 10)

Aplikasi web manajemen tugas harian berbasis **Framework Laravel 10**, **MySQL (Laragon)**, dan **Bootstrap 5** yang dirancang sesuai standar **Ujian Kompetensi Keahlian (UKK) SMK Rekayasa Perangkat Lunak (RPL)**.

> 📁 *Catatan: Versi PHP Native sebelumnya telah disimpan aman di folder cadangan `d:\PSAJ\UKK_NATIVE_BACKUP`.*

---

## 🚀 Fitur Unggulan

1. **Autentikasi Pengguna Lengkap**:
   - Register Akun (`/register`) dengan validasi password confirmation.
   - Login Akun (`/login`) dengan keamanan Bcrypt bawaan Laravel & fitur intip password.
   - Logout Akun (`/logout`) aman dengan proteksi CSRF.
2. **Manajemen Tugas (CRUD Lengkap)**:
   - **Create**: Tambah tugas (Judul, Kategori, Prioritas, Deadline, Keterangan).
   - **Read**: Tampilan tabel interaktif dilengkapi ringkasan 4 kartu statistik.
   - **Update**: Edit tugas via modal Bootstrap interaktif.
   - **Quick Status**: Ubah status langsung (Belum Selesai / Sedang Dikerjakan / Selesai).
   - **Delete**: Hapus tugas dengan konfirmasi dialog.
3. **Pencarian & Filter**:
   - Pencarian berdasarkan judul atau keterangan.
   - Filter berdasarkan Status, Kategori, dan Prioritas.
4. **Fitur Ekstra Siap Ujian**:
   - Indikator badge otomatis untuk tugas yang melewati deadline.
   - Keamanan data multi-user (data tugas terisolasi per akun user).

---

## 🔑 Akun Uji Coba Penguji UKK

Gunakan akun bawaan yang sudah terisi data contoh:
- **Username**: `siswa`
- **Password**: `password123`

---

## 🛠️ Cara Menjalankan Aplikasi

1. Pastikan **Laragon** sudah menyala (tombol **Start All** aktif, MySQL berjalan).
2. Buka terminal di folder proyek `d:\PSAJ\UKK`, lalu ketik:
   ```bash
   php artisan serve
   ```
3. Buka browser dan buka alamat:
   **`http://localhost:8000`**

---

## 📁 Struktur Arsitektur MVC Laravel

```text
d:/PSAJ/UKK/
│
├── 🚦 Routes (Rute URL)
│   └── routes/web.php                 # Pemetaan URL ke Controller & Middleware
│
├── 🎮 Controllers (Pengendali Logika)
│   ├── app/Http/Controllers/AuthController.php   # Autentikasi (Login, Register, Logout)
│   └── app/Http/Controllers/TaskController.php   # CRUD tugas, filter, & cetak laporan
│
├── 📦 Models (Struktur Data & Relasi)
│   ├── app/Models/User.php            # Model User (HasMany ke Task)
│   └── app/Models/Task.php            # Model Task (BelongsTo ke User)
│
├── 🗄️ Database
│   ├── database/migrations/           # Skema tabel users & tasks
│   └── database/seeders/              # Data awal pengujian (Seeder)
│
├── 🎨 Views (Antarmuka Blade)
│   ├── resources/views/layouts/app.blade.php      # Master layout
│   ├── resources/views/layouts/navbar.blade.php   # Navigasi atas
│   ├── resources/views/auth/login.blade.php       # Tampilan Login
│   ├── resources/views/auth/register.blade.php    # Tampilan Register
│   └── resources/views/dashboard.blade.php        # Tampilan To-Do List & Modal
│
└── 💅 Public Assets
    └── public/assets/css/style.css    # Styling kustom Bootstrap 5 & modern utility
```

---

## 🎓 Kisi-Kisi Pertanyaan Penguji UKK (Laravel) & Jawabannya

### 1. *Apa itu arsitektur MVC pada Laravel?*
> **Jawaban:** *"MVC adalah pola desain perangkat lunak yang membagi aplikasi menjadi 3 komponen:*
> - *Model (`app/Models/`): Mengelola struktur data dan logika bisnis database.*
> - *View (`resources/views/`): Mengelola antarmuka tampilan pengguna menggunakan Blade.*
> - *Controller (`app/Http/Controllers/`): Menghubungkan Model dan View serta memproses input dari pengguna."*

### 2. *Apa fungsi `@csrf` pada setiap form Blade?*
> **Jawaban:** *"Untuk melindungi aplikasi dari serangan **CSRF (Cross-Site Request Forgery)**. Laravel secara otomatis memvalidasi token rahasia ini di setiap request POST/PUT/DELETE agar request benar-benar berasal dari pengguna sah di aplikasi kita."*

### 3. *Apa keunggulan menggunakan Migration dan Seeder?*
> **Jawaban:** *"Migration bertindak sebagai version control untuk skema database sehingga struktur tabel dapat dibuat secara otomatis tanpa perlu import SQL manual. Seeder digunakan untuk mengisi data awal (seperti akun uji coba penguji) secara konsisten dengan perintah `php artisan db:seed`."*

### 4. *Bagaimana relasi antara User dan Task dibuat?*
> **Jawaban:** *"Menggunakan **Eloquent ORM**. Pada model `User` terdapat relasi `hasMany(Task::class)`, dan pada model `Task` terdapat relasi `belongsTo(User::class)`. Relasi fisik di database dilindungi oleh foreign key dengan constraint `cascadeOnDelete()`."*

### 5. *Apa fungsi Middleware `auth` dan `guest` di `routes/web.php`?*
> **Jawaban:** *"Middleware bertindak sebagai gerbang penyaring. Middleware `guest` memastikan halaman login/register hanya bisa diakses oleh pengunjung yang belum login. Sementara middleware `auth` memastikan halaman dashboard dan manajemen tugas hanya bisa dibuka setelah pengguna berhasil login."*
