<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LaporanService;
use Illuminate\Http\Request;

class LaporanKerusakanController extends Controller
{
    protected $laporanService;

    public function __construct(LaporanService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    public function index(Request $request)
    {
        $laporan = $this->laporanService->getAll($request->all());
        return view('admin.laporan.index', compact('laporan'));
    }

    public function show($id)
    {
        $laporan = $this->laporanService->find($id);
        return view('admin.laporan.show', compact('laporan'));
    }

    public function diproses($id)
    {
        $this->laporanService->updateStatus($id, 'diproses');
        return redirect()->route('admin.laporan.index');
    }

    public function selesai($id)
    {
        $this->laporanService->updateStatus($id, 'selesai');
        return redirect()->route('admin.laporan.index');
    }
}
