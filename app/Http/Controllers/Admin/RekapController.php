<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LaporanService;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    protected $laporanService;

    public function __construct(LaporanService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    public function index(Request $request)
    {
        $laporan = $this->laporanService->getAll($request->all());
        return view('admin.rekap.index', compact('laporan'));
    }

    public function download(Request $request)
    {
        $laporan = $this->laporanService->getAll($request->all(), 0);
        return view('admin.rekap.download', compact('laporan'));
    }
}
