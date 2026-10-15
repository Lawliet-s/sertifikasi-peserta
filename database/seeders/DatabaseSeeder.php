<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SkemaSertifikasi;
use App\Models\Peserta;
use App\Enums\StatusPeserta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder akun Administrator
        User::updateOrCreate(
            ['email' => 'admin@sertifikasi.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );

        // Seeder Skema Sertifikasi
        $skema1 = SkemaSertifikasi::create([
            'kode_skema' => 'SKM-JWD-001',
            'nama_skema' => 'Junior Web Developer',
            'deskripsi' => 'Skema sertifikasi kompetensi untuk pengembang web tingkat junior.',
        ]);

        $skema2 = SkemaSertifikasi::create([
            'kode_skema' => 'SKM-DNO-002',
            'nama_skema' => 'Digital Network Operation',
            'deskripsi' => 'Skema sertifikasi untuk pengelola jaringan komputer.',
        ]);

        $skema3 = SkemaSertifikasi::create([
            'kode_skema' => 'SKM-GRD-003',
            'nama_skema' => 'Graphic Designer',
            'deskripsi' => 'Skema sertifikasi untuk perancang grafis profesional.',
        ]);

        $skemas = [$skema1->id, $skema2->id, $skema3->id];
        $statuses = [
            StatusPeserta::PENDING,
            StatusPeserta::TERVERIFIKASI,
            StatusPeserta::LULUS,
            StatusPeserta::TIDAK_LULUS,
        ];
        $genders = ['L', 'P'];

        // Generate 25 data dummy peserta agar pagination tampil aktif (>10 item)
        for ($i = 1; $i <= 25; $i++) {
            $nikSeq = str_pad($i, 12, '0', STR_PAD_LEFT);
            Peserta::create([
                'nama_lengkap' => "Peserta Contoh {$i}",
                'nik' => "3201" . $nikSeq, // Tepat 16 digit
                'email' => "peserta{$i}@example.com",
                'no_telepon' => "0812" . rand(10000000, 99999999),
                'tanggal_lahir' => '199' . rand(0, 9) . '-' . rand(1, 12) . '-' . rand(1, 28),
                'jenis_kelamin' => $genders[array_rand($genders)],
                'alamat' => "Jl. Contoh No. {$i}, Kota Dummy",
                'skema_sertifikasi_id' => $skemas[array_rand($skemas)],
                'status' => $statuses[array_rand($statuses)],
            ]);
        }
    }
}
