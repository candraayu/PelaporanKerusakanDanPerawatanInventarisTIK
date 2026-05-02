<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KecamatanStoreRequest;
use App\Http\Requests\Admin\KecamatanUpdateRequest;
use App\Services\KecamatanService;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    protected $kecamatanService;

    public function __construct(KecamatanService $kecamatanService)
    {
        $this->kecamatanService = $kecamatanService;
    }

    public function index(Request $request)
    {
        $kecamatan = $this->kecamatanService->getAll($request->all());
        return view('admin.kecamatan', compact('kecamatan'));
    }

    public function create()
    {
        return view('admin.kecamatan.create');
    }

    public function store(KecamatanStoreRequest $request)
    {
        $this->kecamatanService->create($request->validated());
        return redirect()->route('admin.kecamatan.index')->with('success', 'Data kecamatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kecamatan = $this->kecamatanService->find($id);
        return view('admin.kecamatan.edit', compact('kecamatan'));
    }

    public function update(KecamatanUpdateRequest $request, $id)
    {
        $this->kecamatanService->update($id, $request->validated());
        return redirect()->route('admin.kecamatan.index')->with('success', 'Data kecamatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->kecamatanService->delete($id);
        return redirect()->route('admin.kecamatan.index')->with('success', 'Data kecamatan berhasil dihapus.');
    }
}
