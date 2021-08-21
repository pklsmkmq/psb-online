<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prestasiBelajar extends Model
{
    use HasFactory;
    protected $table = "prestasi_belajar";
    protected $fillable = ['nik_siswa','mata_pelajaran','nilai_kelas1_semester1','nilai_kelas1_semester2','nilai_kelas2_semester1','nilai_kelas2_semester2','nilai_kelas3_semester1'];
    protected $keyType = 'string';

    public function calonSiswa()
    {
        return $this->belongsTo(calonSiswa::class);
    }
}
