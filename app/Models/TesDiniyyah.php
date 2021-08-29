<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TesDiniyyah extends Model
{
    use HasFactory;
    protected $table = "tes_diniyyah";
    protected $fillable = ['user_id','tanggal','status', 'metode' , 'catatan', 'jadwal_ulang'];
}
