<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\RekapIndexRequest;
use App\Services\LaporanService;
use Illuminate\Support\Facades\Auth;

class RekapController extends Controller
{
    protected $laporanService;

    public function __construct(LaporanService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    public function index(RekapIndexRequest $request)
    {
        $idKecamatan = Auth::user()->id_kecamatan;
        $laporan = $this->laporanService->getAll($request->validated(), 0, $idKecamatan);

        return view('operator.rekap.index', compact('laporan'));
    }

    public function download(RekapIndexRequest $request)
    {
        $idKecamatan = Auth::user()->id_kecamatan;
        $laporan = $this->laporanService->getAll($request->validated(), 0, $idKecamatan);

        return view('operator.rekap.download', compact('laporan'));
    }
}
