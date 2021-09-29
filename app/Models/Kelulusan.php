<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelulusan extends Model
{
    use HasFactory;
    protected $table = "kelulusan";
    protected $fillable = ['user_id','kelulusan'];
    protected $keyType = 'string';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
