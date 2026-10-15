<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportPesertaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'File Excel wajib diunggah.',
            'file.file' => 'Berkas yang diunggah harus berupa file.',
            'file.mimes' => 'Format file harus berupa Excel (.xlsx, .xls) atau .csv.',
            'file.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'file' => 'File Excel',
        ];
    }
}
