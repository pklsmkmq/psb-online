<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataIbu extends Model
{
    use HasFactory;
    protected $primaryKey = 'nik_ibu';
    protected $table = "data_ibu";
    protected $fillable = ['nik_ibu','nik_siswa','name_ibu','tempat_lahir_ibu','tanggal_lahir_ibu','pekerjaan_ibu','nomor_telepon_ibu','penghasilan_ibu'];
    protected $keyType = 'string';

    public function calonSiswa()
    {
        return $this->belongsTo(calonSiswa::class);
    }
}
