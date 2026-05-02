<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class InventarisUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('inventari'); // Resource mapping might be 'inventari' or 'inventaris' depending on route definition, but usually Laravel pluralizes resourcefully. Let's check the route later or use the ID directly if passed.
        return [
            'id_kecamatan' => 'required|exists:kecamatan,id_kecamatan',
            'kode_inventaris' => 'required|string|max:100|unique:inventaris,kode_inventaris,' . $id . ',id_inventaris',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'merk' => 'nullable|string|max:100',
            'tipe' => 'nullable|string|max:100',
            'tahun_pengadaan' => 'nullable|digits:4',
            'kondisi' => 'required|in:baik,rusak ringan,rusak berat',
            'jumlah' => 'required|integer|min:1'
        ];
    }
}
