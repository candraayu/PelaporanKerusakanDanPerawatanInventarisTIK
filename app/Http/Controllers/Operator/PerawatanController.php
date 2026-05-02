<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\PerawatanStoreRequest;
use App\Http\Requests\Operator\PerawatanUpdateRequest;
use App\Http\Requests\Operator\OperatorSearchRequest;
use App\Services\PerawatanService;
use App\Services\InventarisService;
use Illuminate\Support\Facades\Auth;

class PerawatanController extends Controller
{
    protected $perawatanService;
    protected $inventarisService;

    public function __construct(PerawatanService $perawatanService, InventarisService $inventarisService)
    {
        $this->perawatanService = $perawatanService;
        $this->inventarisService = $inventarisService;
    }

    public function index(OperatorSearchRequest $request)
    {
        $idKecamatan = Auth::user()->id_kecamatan;
        $perawatan = $this->perawatanService->getAll($request->validated(), $idKecamatan);
        $inventaris = $this->inventarisService->getAll([], $idKecamatan);

        return view('operator.perawatan', compact('perawatan', 'inventaris'));
    }

    public function create()
    {
        $idKecamatan = Auth::user()->id_kecamatan;
        $inventaris = $this->inventarisService->getAll([], $idKecamatan);
        return view('operator.perawatan.create', compact('inventaris'));
    }

    public function store(PerawatanStoreRequest $request)
    {
        $this->perawatanService->create($request->validated());
        return redirect()->route('operator.perawatan.index');
    }

    public function edit($id)
    {
        $perawatan = $this->perawatanService->find($id);
        $idKecamatan = Auth::user()->id_kecamatan;
        $inventaris = $this->inventarisService->getAll([], $idKecamatan);

        return view('operator.perawatan.edit', compact('perawatan', 'inventaris'));
    }

    public function update(PerawatanUpdateRequest $request, $id)
    {
        $this->perawatanService->update($id, $request->validated());
        return redirect()->route('operator.perawatan.index');
    }

    public function destroy($id)
    {
        $this->perawatanService->delete($id);
        return redirect()->route('operator.perawatan.index');
    }
}
