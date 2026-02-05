<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    protected $fillable = [
        'user_id','kelas','matematika','fisika','kimia','biologi','tik',
        'bahasa_inggris','sosiologi','geografi','ekonomi','rapor_file'
    ];

}
