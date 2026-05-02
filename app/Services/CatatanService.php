<?php

namespace App\Services;

use App\Models\CatatanPerbaikan;
use Illuminate\Support\Facades\Auth;

class CatatanService
{
    public function create(array $data): CatatanPerbaikan
    {
        $data['id_user'] = Auth::id();
        return CatatanPerbaikan::create($data);
    }
}
