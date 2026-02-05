<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Peminatan;

class Kriteria extends Model
{
    protected $fillable = ['peminatan_id', 'mapel', 'bobot'];

    public function peminatan()
    {
        return $this->belongsTo(Peminatan::class);
    }
}