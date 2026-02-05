<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Siswa;
use App\Models\Peminatan;

class Alokasi extends Model
{
    protected $fillable = ['siswa_id', 'peminatan_id', 'skor_saw', 'status', 'skor_pilihan_1', 'skor_pilihan_2', 'skor_pilihan_3'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id'); // ✅ GUNAKAN MODEL SISWA
    }

    public function peminatan()
    {
        return $this->belongsTo(Peminatan::class, 'peminatan_id');
    }
}