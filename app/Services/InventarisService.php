<?php

namespace App\Services;

use App\Models\Inventaris;
use App\Models\Kecamatan;

class InventarisService
{
    public function getAll(array $filters = [], int $idKecamatan = null)
    {
        $query = Inventaris::with('kecamatan');

        if ($idKecamatan) {
            $query->where('id_kecamatan', $idKecamatan);
        }

        if (isset($filters['search']) && $filters['search'] != '') {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('kode_inventaris', 'LIKE', '%' . $search . '%')
                    ->orWhere('nama_barang', 'LIKE', '%' . $search . '%')
                    ->orWhere('kategori', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('kecamatan', function ($q2) use ($search) {
                        $q2->where('nama_kecamatan', 'LIKE', '%' . $search . '%');
                    });
            });
        }

        return $query->latest()->paginate(10);
    }

    public function generateKodeInventaris(): string
    {
        $lastInventaris = Inventaris::where('kode_inventaris', 'LIKE', 'INV-TIK-%')
            ->orderBy('kode_inventaris', 'desc')
            ->first();

        $newNumber = $lastInventaris ? intval(substr($lastInventaris->kode_inventaris, -3)) + 1 : 1;
        return 'INV-TIK-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function create(array $data): Inventaris
    {
        $data['kode_inventaris'] = $this->generateKodeInventaris();
        return Inventaris::create($data);
    }

    public function find(int $id): Inventaris
    {
        return Inventaris::findOrFail($id);
    }

    public function update(int $id, array $data): bool
    {
        $inventaris = $this->find($id);
        return $inventaris->update($data);
    }

    public function delete(int $id): bool
    {
        $inventaris = $this->find($id);
        return $inventaris->delete();
    }
}
