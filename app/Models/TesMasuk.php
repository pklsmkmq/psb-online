<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TesMasuk extends Model
{
    use HasFactory;
    protected $table = "tes_masuk";
    protected $fillable = ['user_id','kode_mapel','nilai','ulangi'];
    protected $keyType = 'string';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}