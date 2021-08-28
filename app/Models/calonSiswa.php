<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class calonSiswa extends Model
{
    use HasFactory;
   
    protected $table = "calon_siswa";
    protected $fillable = ['nik_siswa','jurusan','name_siswa','user_id','tempat_lahir_siswa','tanggal_lahir_siswa','jenis_kelamin','agama','golongan_darah','alamat_siswa','nomor_telepon_siswa','pihak_yg_dihubungi','tinggi_badan','berat_badan','ukuran_baju','cita_cita'];
    protected $keyType = 'string';

    public function pendidikanSebelumnya()
    {
        return $this->hasOne(pendidikanSebelumnya::class);
    }

    public function dataAyah()
    {
        return $this->hasOne(dataAyah::class);
    }

    public function dataIbu()
    {
        return $this->hasOne(dataIbu::class);
    }

    public function dataWali()
    {
        return $this->hasOne(dataWali::class);
    }

    public function prestasiBelajar()
    {
        return $this->hasOne(prestasiBelajar::class);
    }

    public function pendaftaran()
    {
        return $this->hasOne(pendaftaran::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
