<?php

namespace App\Enums;

enum StatusPeserta: string
{
    case PENDING = 'pending';
    case TERVERIFIKASI = 'terverifikasi';
    case LULUS = 'lulus';
    case TIDAK_LULUS = 'tidak_lulus';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::TERVERIFIKASI => 'Terverifikasi',
            self::LULUS => 'Lulus',
            self::TIDAK_LULUS => 'Tidak Lulus',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::PENDING => 'bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800',
            self::TERVERIFIKASI => 'bg-indigo-50 dark:bg-indigo-950/50 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800',
            self::LULUS => 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800',
            self::TIDAK_LULUS => 'bg-rose-50 dark:bg-rose-950/50 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800',
        };
    }
}
