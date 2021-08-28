<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataAyah extends Model
{
    use HasFactory;
  
    protected $table = "data_ayah";
    protected $fillable = ['nik_ayah','user_id','name_ayah','tempat_lahir_ayah','tanggal_lahir_ayah','pekerjaan_ayah','nomor_telepon_ayah','penghasilan_ayah'];
    protected $keyType = 'string';

    public function calonSiswa()
    {
        return $this->belongsTo(calonSiswa::class);
    }
}
