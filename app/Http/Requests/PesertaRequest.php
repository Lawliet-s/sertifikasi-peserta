<?php

namespace App\Http\Requests;

use App\Enums\StatusPeserta;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PesertaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pesertaId = $this->route('peserta') ? $this->route('peserta')->id : null;

        return [
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nik' => [
                'required',
                'string',
                'size:16',
                'regex:/^\d{16}$/',
                Rule::unique('peserta', 'nik')->ignore($pesertaId),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('peserta', 'email')->ignore($pesertaId),
            ],
            'no_telepon' => ['required', 'string', 'max:20'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'alamat' => ['required', 'string'],
            'skema_sertifikasi_id' => ['required', 'exists:skema_sertifikasi,id'],
            'status' => ['required', Rule::enum(StatusPeserta::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus tepat 16 karakter.',
            'nik.regex' => 'NIK harus berupa 16 digit angka.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
            'alamat.required' => 'Alamat wajib diisi.',
            'skema_sertifikasi_id.required' => 'Skema sertifikasi wajib dipilih.',
            'skema_sertifikasi_id.exists' => 'Skema sertifikasi yang dipilih tidak valid.',
            'status.required' => 'Status peserta wajib dipilih.',
            'status.Illuminate\Validation\Rules\Enum' => 'Pilihan status tidak valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_lengkap' => 'Nama Lengkap',
            'nik' => 'NIK',
            'email' => 'Email',
            'no_telepon' => 'Nomor Telepon',
            'tanggal_lahir' => 'Tanggal Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'alamat' => 'Alamat',
            'skema_sertifikasi_id' => 'Skema Sertifikasi',
            'status' => 'Status',
        ];
    }
}
