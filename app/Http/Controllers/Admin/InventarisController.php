<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InventarisStoreRequest;
use App\Http\Requests\Admin\InventarisUpdateRequest;
use App\Services\InventarisService;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    protected $inventarisService;

    public function __construct(InventarisService $inventarisService)
    {
        $this->inventarisService = $inventarisService;
    }

    public function index(Request $request)
    {
        $inventaris = $this->inventarisService->getAll($request->all());
        $kecamatan = Kecamatan::all();
        return view('admin.inventaris', compact('inventaris', 'kecamatan'));
    }

    public function create()
    {
        $kecamatan = Kecamatan::all();
        return view('admin.inventaris.create', compact('kecamatan'));
    }

    public function store(InventarisStoreRequest $request)
    {
        $inventaris = $this->inventarisService->create($request->validated());
        return redirect()->route('admin.inventaris.index')->with('success', 'Data inventaris berhasil ditambahkan dengan kode ' . $inventaris->kode_inventaris);
    }

    public function show($id)
    {
        $inventaris = $this->inventarisService->find($id)->load('kecamatan');
        return view('admin.inventaris.show', compact('inventaris'));
    }

    public function edit($id)
    {
        $inventaris = $this->inventarisService->find($id);
        $kecamatan = Kecamatan::all();
        return view('admin.inventaris.edit', compact('inventaris', 'kecamatan'));
    }

    public function update(InventarisUpdateRequest $request, $id)
    {
        $this->inventarisService->update($id, $request->validated());
        return redirect()->route('admin.inventaris.index')->with('success', 'Data inventaris berhasil diperbarui.');
    }

    public function getLatestKode()
    {
        return response()->json(['kode' => $this->inventarisService->generateKodeInventaris()]);
    }

    public function destroy($id)
    {
        $this->inventarisService->delete($id);
        return redirect()->route('admin.inventaris.index')->with('success', 'Data inventaris berhasil dihapus.');
    }
}
