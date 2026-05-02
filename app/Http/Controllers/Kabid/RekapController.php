<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kabid\RekapIndexRequest;
use App\Services\LaporanService;

class RekapController extends Controller
{
    protected $laporanService;

    public function __construct(LaporanService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    public function index(RekapIndexRequest $request)
    {
        $laporan = $this->laporanService->getAll($request->validated());
        return view('kabid.rekap.index', compact('laporan'));
    }

    public function download(RekapIndexRequest $request)
    {
        $laporan = $this->laporanService->getAll($request->validated(), 0);
        return view('kabid.rekap.download', compact('laporan'));
    }
}
