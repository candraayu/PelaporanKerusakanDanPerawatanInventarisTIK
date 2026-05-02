<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    protected $table = 'inventaris';
    protected $primaryKey = 'id_inventaris';

    protected $fillable = [
        'id_kecamatan',
        'kode_inventaris',
        'nama_barang',
        'kategori',
        'merk',
        'tipe',
        'tahun_pengadaan',
        'kondisi',
        'jumlah'
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }

    public function laporan()
    {
        return $this->hasMany(LaporanKerusakan::class, 'id_inventaris');
    }

    public function perawatan()
    {
        return $this->hasMany(Perawatan::class, 'id_inventaris');
    }
}
