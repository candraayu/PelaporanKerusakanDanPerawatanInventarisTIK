<?php

namespace App\Services;

use App\Models\Kecamatan;
use Illuminate\Pagination\LengthAwarePaginator;

class KecamatanService
{
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = Kecamatan::query();
        if (isset($filters['search']) && $filters['search'] != '') {
            $search = $filters['search'];
            $query->where('nama_kecamatan', 'LIKE', '%' . $search . '%')
                ->orWhere('kode_kecamatan', 'LIKE', '%' . $search . '%');
        }
        return $query->paginate(10);
    }

    public function create(array $data): Kecamatan
    {
        return Kecamatan::create($data);
    }

    public function find(int $id): Kecamatan
    {
        return Kecamatan::findOrFail($id);
    }

    public function update(int $id, array $data): bool
    {
        $kecamatan = $this->find($id);
        return $kecamatan->update($data);
    }

    public function delete(int $id): bool
    {
        $kecamatan = $this->find($id);
        return $kecamatan->delete();
    }
}
