<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKerusakan extends Model
{
    protected $table = 'laporan_kerusakan';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_inventaris',
        'id_user',
        'tanggal_laporan',
        'deskripsi_kerusakan',
        'foto',
        'status'
    ];

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class, 'id_inventaris');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function catatan()
    {
        return $this->hasMany(CatatanPerbaikan::class, 'id_laporan');
    }
}
