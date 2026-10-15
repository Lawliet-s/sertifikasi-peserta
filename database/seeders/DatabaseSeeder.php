<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SkemaSertifikasi;
use App\Models\Peserta;
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

        // Seeder Peserta
        Peserta::create([
            'nama_lengkap' => 'Budi Santoso',
            'nik' => '3201123456789001',
            'email' => 'budi@example.com',
            'no_telepon' => '081234567890',
            'tanggal_lahir' => '2000-05-12',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Merdeka No. 10, Jakarta',
            'skema_sertifikasi_id' => $skema1->id,
        ]);

        Peserta::create([
            'nama_lengkap' => 'Siti Aminah',
            'nik' => '3201123456789002',
            'email' => 'siti@example.com',
            'no_telepon' => '089876543210',
            'tanggal_lahir' => '2001-08-20',
            'jenis_kelamin' => 'P',
            'alamat' => 'Jl. Sudirman No. 45, Bandung',
            'skema_sertifikasi_id' => $skema2->id,
        ]);
    }
}
