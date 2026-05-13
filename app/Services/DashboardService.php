<?php

namespace App\Services;

use App\Models\LaporanKerusakan;
use App\Models\Kecamatan;
use App\Models\Inventaris;

class DashboardService
{
    public function getStats(): array
    {
        return [
            // 'totalKecamatan'  => Kecamatan::count(),
            // 'totalInventaris' => Inventaris::count(),
            // 'totalLaporan'    => LaporanKerusakan::count(),
            // 'laporanDiproses' => LaporanKerusakan::whereIn('status', ['diproses', 'disetujui'])->count(),
            // 'laporanSelesai'  => LaporanKerusakan::where('status', 'selesai')->count(),
            // 'laporanDitolak' => LaporanKerusakan::where('status', 'ditolak')->count(),
            'totalKecamatan'   => Kecamatan::count(),
            'totalInventaris'  => Inventaris::count(),
            'totalLaporan'     => LaporanKerusakan::count(),

            'laporanMenunggu'  => LaporanKerusakan::where('status', 'menunggu')->count(),

            'laporanDisetujui' => LaporanKerusakan::where('status', 'disetujui')->count(),

            'laporanDiproses'  => LaporanKerusakan::where('status', 'diproses')->count(),

            'laporanSelesai'   => LaporanKerusakan::where('status', 'selesai')->count(),

            'laporanDitolak'   => LaporanKerusakan::where('status', 'ditolak')->count(),
        ];
    }

    public function getKabidStats(): array
    {
        return [
            'totalKecamatan'  => Kecamatan::count(),
            'totalInventaris' => Inventaris::count(),
            'totalLaporan'    => LaporanKerusakan::count(),
            'laporanMenunggu' => LaporanKerusakan::where('status', 'menunggu')->count(),
            'laporanSelesai'  => LaporanKerusakan::where('status', 'selesai')->count(),
        ];
    }

    public function getOperatorStats(int $idKecamatan): array
    {
        return [
            'totalInventaris' => Inventaris::where('id_kecamatan', $idKecamatan)->count(),
            'totalLaporan'    => LaporanKerusakan::whereHas('inventaris', function ($q) use ($idKecamatan) {
                $q->where('id_kecamatan', $idKecamatan);
            })->count(),
            'laporanMenunggu' => LaporanKerusakan::where('status', 'menunggu')
                ->whereHas('inventaris', function ($q) use ($idKecamatan) {
                    $q->where('id_kecamatan', $idKecamatan);
                })->count(),
            'laporanDiproses' => LaporanKerusakan::where('status', 'diproses')
                ->whereHas('inventaris', function ($q) use ($idKecamatan) {
                    $q->where('id_kecamatan', $idKecamatan);
                })->count(),
            'laporanSelesai'  => LaporanKerusakan::where('status', 'selesai')
                ->whereHas('inventaris', function ($q) use ($idKecamatan) {
                    $q->where('id_kecamatan', $idKecamatan);
                })->count(),
        ];
    }

    public function getRecentReports(int $limit = 5)
    {
        return LaporanKerusakan::with(['inventaris', 'user'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getTrendData(int $period = 6): array
    {
        $months = [];
        $reportCounts = [];
        $completedCounts = [];

        for ($i = $period - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M');

            $reportCounts[] = LaporanKerusakan::whereYear('tanggal_laporan', $date->year)
                ->whereMonth('tanggal_laporan', $date->month)
                ->count();

            $completedCounts[] = LaporanKerusakan::whereYear('tanggal_laporan', $date->year)
                ->whereMonth('tanggal_laporan', $date->month)
                ->where('status', 'selesai')
                ->count();
        }

        return compact('months', 'reportCounts', 'completedCounts');
    }
}
