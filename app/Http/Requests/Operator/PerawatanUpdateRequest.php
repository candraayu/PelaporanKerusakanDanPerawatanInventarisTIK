<?php

namespace App\Http\Requests\Operator;

use Illuminate\Foundation\Http\FormRequest;

class PerawatanUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_inventaris' => 'required|exists:inventaris,id_inventaris',
            'tanggal_perawatan' => 'required|date',
            'jenis_perawatan' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ];
    }
}
