<?php

namespace App\Helpers;

class Terbilang
{
    public static function rupiah($angka)
    {
        $angka = abs($angka);
        $huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
        $temp = "";

        if ($angka < 12) {
            $temp = $huruf[$angka];
        } elseif ($angka < 20) {
            $temp = self::rupiah($angka - 10) . " Belas";
        } elseif ($angka < 100) {
            $temp = self::rupiah(floor($angka / 10)) . " Puluh " . self::rupiah($angka % 10);
        } elseif ($angka < 200) {
            $temp = "Seratus " . self::rupiah($angka - 100);
        } elseif ($angka < 1000) {
            $temp = self::rupiah(floor($angka / 100)) . " Ratus " . self::rupiah($angka % 100);
        } elseif ($angka < 2000) {
            $temp = "Seribu " . self::rupiah($angka - 1000);
        } elseif ($angka < 1000000) {
            $temp = self::rupiah(floor($angka / 1000)) . " Ribu " . self::rupiah($angka % 1000);
        } elseif ($angka < 1000000000) {
            $temp = self::rupiah(floor($angka / 1000000)) . " Juta " . self::rupiah($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $temp = self::rupiah(floor($angka / 1000000000)) . " Miliar " . self::rupiah($angka % 1000000000);
        } elseif ($angka < 1000000000000000) {
            $temp = self::rupiah(floor($angka / 1000000000000)) . " Triliun " . self::rupiah($angka % 1000000000000);
        }

        return trim(preg_replace('/\s+/', ' ', $temp)); // bersihkan spasi dobel
    }
}
