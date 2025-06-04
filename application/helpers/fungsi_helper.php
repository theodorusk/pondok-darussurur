<?php
// Tambahkan pada helper fungsi_helper.php jika belum ada

/**
 * Fungsi untuk konversi bulan dalam angka menjadi nama bulan dalam bahasa Indonesia
 */
function bulan_indo($bln)
{
    switch ($bln) {
        case 1:
            return "Januari";
        case 2:
            return "Februari";
        case 3:
            return "Maret";
        case 4:
            return "April";
        case 5:
            return "Mei";
        case 6:
            return "Juni";
        case 7:
            return "Juli";
        case 8:
            return "Agustus";
        case 9:
            return "September";
        case 10:
            return "Oktober";
        case 11:
            return "November";
        case 12:
            return "Desember";
        default:
            return "";
    }
}

/**
 * Fungsi untuk mengkonversi tanggal ke format Indonesia: 31 Desember 2023
 */
function tanggal_indo($tanggal)
{
    $date = new DateTime($tanggal);
    $day = $date->format('d');
    $month = bulan_indo($date->format('n'));
    $year = $date->format('Y');

    return $day . ' ' . $month . ' ' . $year;
}

/**
 * Fungsi untuk mengkonversi tanggal dan waktu ke format Indonesia dengan timezone Asia/Jakarta
 */
function tanggal_waktu_indo($tanggal)
{
    if (empty($tanggal)) return '-';
    
    $date = new DateTime($tanggal);
    // Atur timezone ke Asia/Jakarta (WIB)
    $date->setTimezone(new DateTimeZone('Asia/Jakarta'));
    
    $day = $date->format('d');
    $month = bulan_indo($date->format('n'));
    $year = $date->format('Y');
    $time = $date->format('H:i');

    return $day . ' ' . $month . ' ' . $year . ' ' . $time . ' WIB';
}
