<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';

    protected $fillable = [
        'nama_lengkap',
        'nik',
        'email',
        'no_telepon',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'skema_sertifikasi_id',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function skema()
    {
        return $this->belongsTo(SkemaSertifikasi::class, 'skema_sertifikasi_id');
    }
}
