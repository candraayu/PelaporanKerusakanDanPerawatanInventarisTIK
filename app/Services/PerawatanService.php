<?php

namespace App\Services;

use App\Models\Perawatan;
use Illuminate\Support\Facades\Auth;

class PerawatanService
{
    public function getAll(array $filters = [], int $idKecamatan = null)
    {
        $query = Perawatan::with(['inventaris.kecamatan', 'user']);

        if ($idKecamatan) {
            $query->whereHas('inventaris', function ($q) use ($idKecamatan) {
                $q->where('id_kecamatan', $idKecamatan);
            });
        }

        if (isset($filters['search']) && $filters['search'] != '') {
            $search = $filters['search'];

            $query->where(function ($q) use ($search) {
                //dari inventaris
                $q->whereHas('inventaris', function ($qi) use ($search) {
                    $qi->where('nama_barang', 'LIKE', '%' . $search . '%')
                        ->orWhere('kode_inventaris', 'LIKE', '%' . $search . '%');
                })

                    //dari kecamatan
                    ->orWhereHas('inventaris.kecamatan', function ($q2) use ($search) {
                        $q2->where('nama_kecamatan', 'LIKE', '%' . $search . '%');
                    });
            });
        }
        return $query->latest()->paginate(10);
    }

    public function create(array $data): Perawatan
    {
        $data['id_user'] = Auth::id();
        return Perawatan::create($data);
    }

    public function find(int $id): Perawatan
    {
        return Perawatan::findOrFail($id);
    }

    public function update(int $id, array $data): bool
    {
        $perawatan = $this->find($id);
        return $perawatan->update($data);
    }

    public function delete(int $id): bool
    {
        $perawatan = $this->find($id);
        return $perawatan->delete();
    }

    public function getRekap(array $filters = [], int $paginate = 10, int $idKecamatan = null)
    {
        $query = \App\Models\Perawatan::with(['inventaris.kecamatan', 'user']);

        // filter kecamatan
        if ($idKecamatan) {
            $query->whereHas('inventaris', function ($q) use ($idKecamatan) {
                $q->where('id_kecamatan', $idKecamatan);
            });
        }

        // filter tanggal
        if (!empty($filters['tanggal_awal'])) {
            $query->whereDate('tanggal_perawatan', '>=', $filters['tanggal_awal']);
        }

        if (!empty($filters['tanggal_akhir'])) {
            $query->whereDate('tanggal_perawatan', '<=', $filters['tanggal_akhir']);
        }

        return $paginate === 0
            ? $query->latest()->get()
            : $query->latest()->paginate($paginate);
    }
}
