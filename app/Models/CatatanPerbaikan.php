<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatatanPerbaikan extends Model
{
    protected $table = 'catatan_perbaikan';
    protected $primaryKey = 'id_catatan';

    protected $fillable = [
        'id_laporan',
        'id_user',
        'catatan',
        'tanggal'
    ];

    public function laporan()
    {
        return $this->belongsTo(LaporanKerusakan::class, 'id_laporan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
