<?php

namespace App\Services;

use App\Models\LaporanKerusakan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanService
{
    public function getAll(array $filters = [], int $perPage = 10, int $idKecamatan = null)
    {
        $query = LaporanKerusakan::with(['inventaris', 'user', 'catatan.user']);

        if ($idKecamatan) {
            $query->whereHas('inventaris', function ($q) use ($idKecamatan) {
                $q->where('id_kecamatan', $idKecamatan);
            });
        }

        if (isset($filters['search']) && $filters['search'] != '') {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->whereHas('inventaris', function ($sq) use ($search) {
                    $sq->where('nama_barang', 'like', "%$search%")
                        ->orWhere('kode_inventaris', 'like', "%$search%");
                })->orWhereHas('user', function ($sq) use ($search) {
                    $sq->where('nama', 'like', "%$search%");
                })->orWhereHas('inventaris.kecamatan', function ($sq) use ($search) {
                    $sq->where('nama_kecamatan', 'like', "%$search%");
                })->orWhere('deskripsi_kerusakan', 'like', "%$search%");
            });
        }

        if (isset($filters['status']) && $filters['status'] != '') {
            $query->where('status', $filters['status']);
        }

        // if (isset($filters['tgl_mulai']) && isset($filters['tgl_selesai'])) {
        //     $query->whereBetween('created_at', [$filters['tgl_mulai'] . ' 00:00:00', $filters['tgl_selesai'] . ' 23:59:59']);
        // }

        if (isset($filters['tanggal_awal'])) {
            $query->whereDate('tanggal_laporan', '>=', $filters['tanggal_awal']);
        }

        if (isset($filters['tanggal_akhir'])) {
            $query->whereDate('tanggal_laporan', '<=', $filters['tanggal_akhir']);
        }

        $query->latest('tanggal_laporan');

        return $perPage ? $query->paginate($perPage)->withQueryString() : $query->get();
    }

    public function find(int $id): LaporanKerusakan
    {
        return LaporanKerusakan::with(['inventaris.kecamatan', 'user', 'catatan.user'])->findOrFail($id);
    }

    public function updateStatus(int $id, string $status): bool
    {
        $laporan = LaporanKerusakan::findOrFail($id);
        return $laporan->update(['status' => $status]);
    }

    public function create(array $data)
    {
        if (isset($data['foto'])) {
            $data['foto'] = $data['foto']->store('laporan_kerusakan', 'public');
        }

        $data['id_user'] = Auth::id();
        $data['status'] = 'menunggu';

        return LaporanKerusakan::create($data);
    }

    public function update(int $id, array $data)
    {
        $laporan = $this->find($id);

        if (isset($data['foto'])) {
            if ($laporan->foto) {
                Storage::disk('public')->delete($laporan->foto);
            }
            $data['foto'] = $data['foto']->store('laporan_kerusakan', 'public');
        }

        return $laporan->update($data);
    }

    public function delete(int $id)
    {
        $laporan = $this->find($id);

        if ($laporan->foto) {
            Storage::disk('public')->delete($laporan->foto);
        }

        return $laporan->delete();
    }
}
