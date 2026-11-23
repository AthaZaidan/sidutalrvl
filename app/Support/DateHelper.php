<?php

namespace App\Support;

use Carbon\Carbon;

final class DateHelper
{
    private const MONTHS = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    public static function tglIndo(?string $date): string
    {
        if (empty($date) || $date === '0000-00-00') {
            return '-';
        }
        try {
            $dt = Carbon::parse($date);
            return $dt->day . ' ' . (self::MONTHS[$dt->month] ?? $dt->format('F')) . ' ' . $dt->year;
        } catch (\Throwable) {
            return (string) $date;
        }
    }

    public static function diffForHumansId(?string $datetime): string
    {
        if (empty($datetime)) {
            return '-';
        }
        try {
            $dt = Carbon::parse($datetime);
            $diffDays = (int) $dt->diffInDays(now());
            if ($diffDays > 7) {
                return self::tglIndo($datetime);
            }
            if ($diffDays >= 1) {
                return $diffDays . ' hari yang lalu';
            }
            $diffHours = (int) $dt->diffInHours(now());
            if ($diffHours >= 1) {
                return $diffHours . ' jam yang lalu';
            }
            $diffMins = (int) $dt->diffInMinutes(now());
            if ($diffMins >= 1) {
                return $diffMins . ' menit yang lalu';
            }
            return 'Baru saja';
        } catch (\Throwable) {
            return (string) $datetime;
        }
    }

    public static function formatRupiah($value): string
    {
        if ($value === null || $value === '' || !is_numeric($value)) {
            return '-';
        }
        return 'Rp ' . number_format((float) $value, 0, ',', '.');
    }
}
