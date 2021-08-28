<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pendidikanSebelumnya extends Model
{
    use HasFactory;
    protected $table = "pendidikan_sebelumnya";
    protected $fillable = ['user_id','asal_sekolah','alamat_sekolah','nomor_telepon_sekolah','nisn','npsn'];
    protected $keyType = 'string';

    public function calonSiswa()
    {
        return $this->belongsTo(calonSiswa::class);
    }
}
