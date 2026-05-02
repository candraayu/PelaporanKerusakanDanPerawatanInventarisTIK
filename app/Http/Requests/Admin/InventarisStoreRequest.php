<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class InventarisStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_kecamatan' => 'required|exists:kecamatan,id_kecamatan',
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
