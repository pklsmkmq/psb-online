<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prestasiSmp extends Model
{
    use HasFactory;
    protected $table = "prestasi_smp";
    protected $fillable = ['user_id','cabang_lomba','peringkat_tingkat_kab','peringkat_tingkat_provinsi','peringkat_tingkat_nasional'];
    protected $keyType = 'string';

    public function calonSiswa()
    {
        return $this->belongsTo(calonSiswa::class);
    }
}
