<?php

namespace App\Http\Requests\Operator;

use Illuminate\Foundation\Http\FormRequest;

class LaporanUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_inventaris' => 'required|exists:inventaris,id_inventaris',
            'tanggal_laporan' => 'required|date',
            'deskripsi_kerusakan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ];
    }
}
