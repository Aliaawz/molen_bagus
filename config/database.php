<?php

// ====================================================================
// KONFIGURASI DATABASE DINAMIS BERDASARKAN LINGKUNGAN
// Secara otomatis beralih antara konfigurasi lokal dan online
// ====================================================================

$db_host = '';
$db_user = '';
$db_pass = '';
$db_name = '';

// Deteksi lingkungan: Jika berjalan di localhost atau 127.0.0.1
if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_ADDR'] == '127.0.0.1') {
    // Konfigurasi untuk Lingkungan LOKAL (XAMPP)
    $db_host = 'localhost';
    $db_user = 'root'; // Username database XAMPP, defaultnya 'root'
    $db_pass = '';     // Password database XAMPP, defaultnya kosong
    $db_name = 'molen_bagus_db'; // Nama database lokal kamu
} else {
    // Konfigurasi untuk Lingkungan ONLINE (InfinityFree, Hostinger, dll.)
    // GANTI KREDENSIAL INI DENGAN INFORMASI DARI HOSTING ONLINE KAMU!
    $db_host = 'sql307.infinityfree.com'; // MySQL Host Name dari InfinityFree
    $db_user = 'ifo_39420600';           // MySQL User Name dari InfinityFree
    $db_pass = 'YOUR_V_PANEL_PASSWORD_HERE'; // <--- SANGAT PENTING: GANTI DENGAN PASSWORD V-PANEL ASLI KAMU!
    $db_name = 'ifo_39420600_molen_bagus'; // MySQL DB Name dari InfinityFree
}

// Membuat koneksi ke database menggunakan MySQLi (objek oriented)
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Mengecek koneksi
if ($conn->connect_error) {
    // Jika koneksi gagal, hentikan eksekusi script dan tampilkan pesan error
    // Pesan error ini sangat penting untuk debugging jika koneksi gagal
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Mengatur charset untuk koneksi agar mendukung karakter khusus (misalnya emoji, aksara lain)
// Penting untuk memastikan data yang diambil atau disimpan ditampilkan dengan benar
$conn->set_charset("utf8mb4");

// Anda bisa menambahkan baris ini untuk debugging jika ingin memastikan koneksi berhasil
// echo "Koneksi database berhasil!";

// Penting: Objek koneksi ($conn) akan tetap terbuka dan bisa digunakan di seluruh script
// Jangan menutup koneksi ($conn->close()) di sini, karena akan dibutuhkan oleh halaman-halaman lain.

?>