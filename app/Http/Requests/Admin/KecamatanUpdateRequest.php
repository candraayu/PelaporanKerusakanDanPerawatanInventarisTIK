<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class KecamatanUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('kecamatan');
        return [
            'kode_kecamatan' => 'required|string|size:8|unique:kecamatan,kode_kecamatan,' . $id . ',id_kecamatan',
            'nama_kecamatan' => 'required|string|max:255|unique:kecamatan,nama_kecamatan,' . $id . ',id_kecamatan',
            'alamat'         => 'nullable|string',
            'kontak'         => 'required|numeric|digits_between:10,15'
        ];
    }

    public function messages(): array
    {
        return [
            'kode_kecamatan.required' => 'Kode kecamatan wajib diisi.',
            'kode_kecamatan.size'     => 'Kode kecamatan wajib 8 karakter.',
            'kode_kecamatan.unique'   => 'Kode kecamatan sudah terdaftar.',
            'nama_kecamatan.required' => 'Nama kecamatan wajib diisi.',
            'nama_kecamatan.unique'   => 'Nama kecamatan sudah terdaftar.',
            'kontak.required'         => 'Kontak wajib diisi.',
            'kontak.numeric'          => 'Kontak harus berupa angka.',
            'kontak.digits_between'   => 'Kontak harus antara 10 sampai 15 digit.'
        ];
    }
}
