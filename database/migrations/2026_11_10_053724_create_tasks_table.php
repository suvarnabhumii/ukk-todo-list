<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('judul', 150);
            $table->text('deskripsi')->nullable();
            $table->enum('kategori', ['Sekolah', 'Pribadi', 'Pekerjaan', 'Lainnya'])->default('Sekolah');
            $table->enum('prioritas', ['Rendah', 'Sedang', 'Tinggi'])->default('Sedang');
            $table->date('deadline')->nullable();
            $table->enum('status', ['Belum Selesai', 'Sedang Dikerjakan', 'Selesai'])->default('Belum Selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
