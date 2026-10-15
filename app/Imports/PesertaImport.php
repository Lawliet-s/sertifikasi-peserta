<?php

namespace App\Imports;

use App\Enums\StatusPeserta;
use App\Models\Peserta;
use App\Models\SkemaSertifikasi;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class PesertaImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    protected $skemas;
    protected $importedCount = 0;
    protected $seenNiks = [];
    protected $seenEmails = [];
    protected $skemaCache = [];

    public function __construct()
    {
        // Pre-fetching Skema Sertifikasi untuk pencegahan N+1 query
        $this->skemas = SkemaSertifikasi::pluck('id', 'kode_skema')->toArray();
    }

    public function prepareForValidation($data, $index)
    {
        // 1. Normalisasi NIK (penanganan angka ilmiah/scientific notation jika terbaca sebagai float/int)
        if (isset($data['nik'])) {
            $nikVal = trim((string)$data['nik']);
            if (is_numeric($nikVal) && stripos($nikVal, 'e') !== false) {
                $nikVal = number_format((float)$nikVal, 0, '', '');
            }
            $data['nik'] = $nikVal;
        }

        // 2. Normalisasi Email dan Kode Skema
        if (isset($data['email'])) {
            $data['email'] = strtolower(trim((string)$data['email']));
        }
        if (isset($data['kode_skema'])) {
            $data['kode_skema'] = trim((string)$data['kode_skema']);
        }

        // 3. Konversi Tanggal Lahir (mendukung serial Excel date maupun string Y-m-d / d-m-Y)
        if (isset($data['tanggal_lahir'])) {
            $tgl = $data['tanggal_lahir'];
            if (is_numeric($tgl)) {
                try {
                    $dateTime = ExcelDate::excelToDateTimeObject($tgl);
                    $data['tanggal_lahir'] = $dateTime->format('Y-m-d');
                } catch (\Exception $e) {
                    // Biarkan divalidasi oleh rule date
                }
            } elseif (is_string($tgl)) {
                $tgl = trim($tgl);
                // Cek format d-m-Y atau d/m/Y
                if (preg_match('/^\d{1,2}[-\/]\d{1,2}[-\/]\d{4}$/', $tgl)) {
                    try {
                        $parsed = Carbon::createFromFormat(strpos($tgl, '/') !== false ? 'd/m/Y' : 'd-m-Y', $tgl);
                        $data['tanggal_lahir'] = $parsed->format('Y-m-d');
                    } catch (\Exception $e) {}
                }
            }
        }

        // 4. Normalisasi Jenis Kelamin (tidak peka huruf besar/kecil)
        if (isset($data['jenis_kelamin'])) {
            $data['jenis_kelamin'] = strtoupper(trim((string)$data['jenis_kelamin']));
        }

        return $data;
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nik' => [
                'required',
                'string',
                'size:16',
                'regex:/^\d{16}$/',
                'unique:peserta,nik',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:peserta,email',
            ],
            'no_telepon' => ['required', 'string', 'max:20'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'alamat' => ['required', 'string'],
            'kode_skema' => ['required', 'string'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus tepat 16 karakter angka.',
            'nik.regex' => 'NIK harus berupa 16 digit angka valid (tidak boleh notasi ilmiah).',
            'nik.unique' => 'NIK sudah terdaftar di database.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar di database.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
            'jenis_kelamin.in' => 'Jenis kelamin harus L atau P.',
            'alamat.required' => 'Alamat wajib diisi.',
            'kode_skema.required' => 'Kode skema wajib diisi.',
        ];
    }

    public function model(array $row)
    {
        $nik = $row['nik'];
        $email = $row['email'];
        $kodeSkema = $row['kode_skema'];

        // 5. Pencegahan Duplikasi di Dalam File yang Sama (In-File Duplicates)
        if (isset($this->seenNiks[$nik]) || isset($this->seenEmails[$email])) {
            throw new \Exception("Duplikasi data NIK ({$nik}) atau Email ({$email}) di dalam file Excel yang sama.");
        }

        // Cek keberadaan kode_skema dari pre-fetched array
        if (!isset($this->skemas[$kodeSkema])) {
            throw new \Exception("Kode skema '{$kodeSkema}' tidak ditemukan di database.");
        }

        $skemaId = $this->skemas[$kodeSkema];

        // Tentukan status (jika kolom status diisi dan valid, gunakan; jika tidak, default PENDING)
        $statusVal = StatusPeserta::PENDING;
        if (!empty($row['status'])) {
            $enumStatus = StatusPeserta::tryFrom(strtolower(trim($row['status'])));
            if ($enumStatus) {
                $statusVal = $enumStatus;
            }
        }

        // Tandai sudah dilihat dalam file
        $this->seenNiks[$nik] = true;
        $this->seenEmails[$email] = true;

        $this->importedCount++;

        return new Peserta([
            'nama_lengkap' => trim($row['nama_lengkap']),
            'nik' => $nik,
            'email' => $email,
            'no_telepon' => trim((string)$row['no_telepon']),
            'tanggal_lahir' => $row['tanggal_lahir'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'alamat' => trim($row['alamat']),
            'skema_sertifikasi_id' => $skemaId,
            'status' => $statusVal,
        ]);
    }

    public function getImportedCount(): int
    {
        return $this->importedCount;
    }
}
