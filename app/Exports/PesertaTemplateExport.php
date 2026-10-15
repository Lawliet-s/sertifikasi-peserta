<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PesertaTemplateExport implements FromArray, WithHeadings, WithColumnFormatting
{
    public function array(): array
    {
        return [
            [
                'Budi Santoso',
                '3201123456789001',
                'budi.santoso@example.com',
                '081234567890',
                '2000-05-12',
                'L',
                'Jl. Merdeka No. 10, Jakarta',
                'SKM-JWD-001',
                'pending'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'nama_lengkap',
            'nik',
            'email',
            'no_telepon',
            'tanggal_lahir',
            'jenis_kelamin',
            'alamat',
            'kode_skema',
            'status'
        ];
    }

    public function columnFormats(): array
    {
        // Set kolom B (NIK) dan D (No Telepon) sebagai Text agar tidak kena scientific notation
        return [
            'B' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
