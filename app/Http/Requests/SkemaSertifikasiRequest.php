<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SkemaSertifikasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $skemaId = $this->route('skema_sertifikasi') ? $this->route('skema_sertifikasi')->id : null;

        return [
            'kode_skema' => [
                'required',
                'string',
                'max:50',
                Rule::unique('skema_sertifikasi', 'kode_skema')->ignore($skemaId),
            ],
            'nama_skema' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'kode_skema.required' => 'Kode skema wajib diisi.',
            'kode_skema.unique' => 'Kode skema sudah terdaftar.',
            'nama_skema.required' => 'Nama skema wajib diisi.',
        ];
    }

    public function attributes(): array
    {
        return [
            'kode_skema' => 'Kode Skema',
            'nama_skema' => 'Nama Skema',
            'deskripsi' => 'Deskripsi',
        ];
    }
}
