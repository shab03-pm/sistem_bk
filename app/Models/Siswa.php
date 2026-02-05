<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Peminatan;

/**
 * @property int $id
 * @property string $nama
 * @property string $nis
 * @property string $email
 * @property string $password
 * @property string $kelas_asal
 */
class Siswa extends Authenticatable
{
    protected $fillable = [
        'nama',
        'nis',
        'email',
        'password',
        'role',
        'kelas_asal',
        'nilai_matematika',
        'nilai_fisika',
        'nilai_kimia',
        'nilai_biologi',
        'nilai_tik',
        'nilai_binggris',
        'nilai_sosiologi',
        'nilai_ekonomi',
        'nilai_geografi',
        'pilihan_peminatan_1',
        'pilihan_peminatan_2',
        'pilihan_peminatan_3',
        'file_raport',
    ];

    protected $hidden = ['password'];

    protected $appends = ['name'];

    // Accessor untuk name (gunakan nama siswa)
    public function getNameAttribute()
    {
        return $this->attributes['nama'] ?? null;
    }

    // ✅ TAMBAHKAN RELASI INI
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

    public function alokasi()
    {
        return $this->hasOne(Alokasi::class, 'siswa_id');
    }

    /**
     * Get file raport URL
     */
    public function getFileRaportUrlAttribute()
    {
        if (!$this->file_raport) {
            return null;
        }

        // Jika path sudah mengandung 'storage/', gunakan langsung
        if (strpos($this->file_raport, 'storage/') === 0) {
            return asset($this->file_raport);
        }

        // Jika path relative dari app/public
        return asset('storage/' . $this->file_raport);
    }
}