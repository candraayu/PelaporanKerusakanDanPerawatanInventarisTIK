<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kabid\LaporanIndexRequest;
use App\Services\LaporanService;
use Illuminate\Http\Request;
use App\Services\CatatanService;

class LaporanKerusakanController extends Controller
{
    protected $laporanService;
    protected $catatanService;

    public function __construct(LaporanService $laporanService, CatatanService $catatanService)
    {
        $this->laporanService = $laporanService;
        $this->catatanService = $catatanService;
    }

    public function index(LaporanIndexRequest $request)
    {
        $laporan = $this->laporanService->getAll($request->validated());
        return view('kabid.laporan', compact('laporan'));
    }

    public function show($id)
    {
        $laporan = $this->laporanService->find($id);
        return view('kabid.laporan.show', compact('laporan'));
    }

    public function setujui($id)
    {
        $laporan = $this->laporanService->find($id);

        if ($laporan->status !== 'menunggu') {
            abort(403);
        }

        $this->laporanService->updateStatus($id, 'disetujui');
        return redirect()->route('kabid.laporan.index');
    }

    // public function tolak($id)
    // {
    //     $laporan = $this->laporanService->find($id);

    //     if ($laporan->status !== 'menunggu') {
    //         abort(403);
    //     }

    //     $this->laporanService->updateStatus($id, 'ditolak');
    //     return redirect()->route('kabid.laporan.index');
    // }

    public function tolak(Request $request, $id)
    {
        $laporan = $this->laporanService->find($id);

        if ($laporan->status !== 'menunggu') {
            abort(403);
        }

        // ubah status
        $this->laporanService->updateStatus($id, 'ditolak');

        // simpan catatan dari kabid
        $this->catatanService->create([
            'id_laporan' => $id,
            'catatan' => $request->catatan,
            'tanggal' => now()
        ]);

        return redirect()->route('kabid.laporan.index');
    }
}
