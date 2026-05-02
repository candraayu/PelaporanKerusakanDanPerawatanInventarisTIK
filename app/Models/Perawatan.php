<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perawatan extends Model
{
    protected $table = 'perawatan';
    protected $primaryKey = 'id_perawatan';

    protected $fillable = [
        'id_inventaris',
        'id_user',
        'tanggal_perawatan',
        'jenis_perawatan',
        'keterangan'
    ];

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class, 'id_inventaris');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
