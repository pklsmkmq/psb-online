<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bukti extends Model
{
    use HasFactory;
    protected $table = "bukti";
    protected $fillable = ['user_id','url_img','status', 'upload_ulang' , 'nominal'];
    protected $keyType = 'string';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
