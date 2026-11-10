<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'kategori',
        'prioritas',
        'deadline',
        'status',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    /**
     * Relasi ke model User (Tugas milik satu user)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
