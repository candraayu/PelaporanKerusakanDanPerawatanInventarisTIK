<?php

namespace App\Http\Requests\Operator;

use Illuminate\Foundation\Http\FormRequest;

class RekapIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal_awal' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date'
        ];
    }
}
