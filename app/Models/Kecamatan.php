<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';
    protected $primaryKey = 'id_kecamatan';

    protected $fillable = [
        'kode_kecamatan',
        'nama_kecamatan',
        'alamat',
        'kontak',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_kecamatan');
    }

    public function inventaris()
    {
        return $this->hasMany(Inventaris::class, 'id_kecamatan');
    }
}
