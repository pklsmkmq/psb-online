<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'device',
        'tahun_ajar',
        'token_reset',
        'wa_count'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function calonSiswa()
    {
        return $this->hasOne(calonSiswa::class);
    }

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

    public function prestasiSmp()
    {
        return $this->hasOne(prestasiSmp::class);
    }

    public function bukti()
    {
        return $this->hasOne(bukti::class);
    }

    public function tesDiniyyah()
    {
        return $this->hasOne(TesDiniyyah::class);
    }

    public function tesMasuk()
    {
        return $this->hasMany(TesMasuk::class);
    }

    public function kelulusan()
    {
        return $this->hasOne(Kelulusan::class);
    }
}
