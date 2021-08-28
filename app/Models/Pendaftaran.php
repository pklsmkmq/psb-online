<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;
   
    protected $table = "pendaftaran";
    protected $fillable = ['no_pendaftaran','no_peserta','nik_siswa','jadwal_tes','jenis_tes'];
    protected $keyType = 'string';

    public function calonSiswa()
    {
        return $this->belongsTo(calonSiswa::class);
    }
}
