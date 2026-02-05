<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Peminatan; // Pastikan ini ada
use App\Models\Alokasi;   // Tambahkan ini

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nis',
        'email',
        'password',
        'role',
        'kelas_asal',
        'pilihan_peminatan_1',
        'pilihan_peminatan_2',
        'pilihan_peminatan_3',
        'nilai_matematika',
        'nilai_fisika',
        'nilai_kimia',
        'nilai_biologi',
        'nilai_tik',
        'nilai_binggris',
        'nilai_sosiologi',
        'nilai_ekonomi',
        'nilai_geografi',
        'file_raport',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ✅ Tambahkan relasi alokasis
    public function alokasis()
    {
        return $this->hasMany(Alokasi::class, 'siswa_id');
    }

    // ✅ Relasi pilihan peminatan
    public function pilihanPeminatan1()
    {
        return $this->belongsTo(Peminatan::class, 'pilihan_peminatan_1');
    }

    public function pilihanPeminatan2()
    {
        return $this->belongsTo(Peminatan::class, 'pilihan_peminatan_2');
    }

    public function pilihanPeminatan3()
    {
        return $this->belongsTo(Peminatan::class, 'pilihan_peminatan_3');
    }
}