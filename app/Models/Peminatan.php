<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Alokasi;
use App\Models\Kriteria;

/**
 * @property int $id
 * @property string $nama
 * @property int $kuota_maksimal
 * @property int $kuota
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Peminatan extends Model
{
    protected $fillable = ['nama', 'kuota_maksimal'];

    public function alokasis()
    {
        return $this->hasMany(Alokasi::class, 'peminatan_id');
    }

    public function kriterias() // ✅ Tambahkan relasi ini
    {
        return $this->hasMany(Kriteria::class, 'peminatan_id');
    }

    public function jumlahDiterima()
    {
        return $this->alokasis()->where('status', 'diterima')->count();
    }

    public function sisaKursi()
    {
        return max(0, $this->kuota_maksimal - $this->jumlahDiterima());
    }
}