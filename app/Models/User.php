<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'id_kecamatan',
        'nama',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }

    public function laporan()
    {
        return $this->hasMany(LaporanKerusakan::class, 'id_user');
    }

    public function perawatan()
    {
        return $this->hasMany(Perawatan::class, 'id_user');
    }
}
