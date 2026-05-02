<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\LaporanStoreRequest;
use App\Http\Requests\Operator\LaporanUpdateRequest;
use App\Http\Requests\Operator\OperatorSearchRequest;
use App\Services\LaporanService;
use App\Services\InventarisService;
use Illuminate\Support\Facades\Auth;

class LaporanKerusakanController extends Controller
{
    protected $laporanService;
    protected $inventarisService;

    public function __construct(LaporanService $laporanService, InventarisService $inventarisService)
    {
        $this->laporanService = $laporanService;
        $this->inventarisService = $inventarisService;
    }

    public function index(OperatorSearchRequest $request)
    {
        $idKecamatan = Auth::user()->id_kecamatan;
        $laporan = $this->laporanService->getAll($request->validated(), 10, $idKecamatan);
        $inventaris = $this->inventarisService->getAll([], $idKecamatan);

        return view('operator.laporan', compact('laporan', 'inventaris'));
    }

    public function create()
    {
        $idKecamatan = Auth::user()->id_kecamatan;
        $inventaris = $this->inventarisService->getAll([], $idKecamatan);
        return view('operator.laporan.create', compact('inventaris'));
    }

    public function store(LaporanStoreRequest $request)
    {
        $this->laporanService->create($request->validated());
        return redirect()->route('operator.laporan.index');
    }

    public function edit($id)
    {
        $laporan = $this->laporanService->find($id);

        if ($laporan->status !== 'menunggu') {
            abort(403);
        }

        $idKecamatan = Auth::user()->id_kecamatan;
        $inventaris = $this->inventarisService->getAll([], $idKecamatan);

        return view('operator.laporan.edit', compact('laporan', 'inventaris'));
    }

    public function update(LaporanUpdateRequest $request, $id)
    {
        $laporan = $this->laporanService->find($id);

        if ($laporan->status !== 'menunggu') {
            abort(403);
        }

        $this->laporanService->update($id, $request->validated());
        return redirect()->route('operator.laporan.index');
    }

    public function destroy($id)
    {
        $laporan = $this->laporanService->find($id);

        if ($laporan->status !== 'menunggu') {
            abort(403);
        }

        $this->laporanService->delete($id);
        return redirect()->route('operator.laporan.index');
    }
}
