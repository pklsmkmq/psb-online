<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataWali extends Model
{
    use HasFactory;
   
    protected $table = "data_wali";
    protected $fillable = ['nik_wali','user_id','name_wali','tempat_lahir_wali','tanggal_lahir_wali','pekerjaan_wali','nomor_telepon_wali','penghasilan_wali'];
    protected $keyType = 'string';

    public function calonSiswa()
    {
        return $this->belongsTo(calonSiswa::class);
    }
}
