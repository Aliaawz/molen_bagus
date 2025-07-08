<?php

// ====================================================================
// KONFIGURASI DATABASE DINAMIS BERDASARKAN LINGKUNGAN
// Secara otomatis beralih antara konfigurasi lokal dan online
// ====================================================================

// --- BARIS DEBUGGING DIMULAI DI SINI ---
echo "<h3>DEBUG KONEKSI DATABASE:</h3>";
echo "Server Name: " . $_SERVER['SERVER_NAME'] . "<br>";
echo "Server Address: " . $_SERVER['SERVER_ADDR'] . "<br>";
// --- BARIS DEBUGGING BERAKHIR DI SINI ---

$db_host = '';
$db_user = '';
$db_pass = '';
$db_name = '';

// Deteksi lingkungan: Jika berjalan di localhost atau 127.0.0.1
if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_ADDR'] == '127.0.0.1') {
    echo "Menggunakan konfigurasi LOKAL (XAMPP).<br>"; // Debugging
    $db_host = 'localhost';
    $db_user = 'root'; // Username database XAMPP, defaultnya 'root'
    $db_pass = '';     // Password database XAMPP, defaultnya kosong
    $db_name = 'molen_bagus_db'; // Nama database lokal kamu
} else {
    echo "Menggunakan konfigurasi ONLINE (InfinityFree).<br>"; // Debugging
    // Konfigurasi untuk Lingkungan ONLINE (InfinityFree, Hostinger, dll.)
    // GANTI KREDENSIAL INI DENGAN INFORMASI DARI HOSTING ONLINE KAMU!
    $db_host = 'sql307.infinityfree.com'; // MySQL Host Name dari InfinityFree
    $db_user = 'ifo_39420600';           // MySQL User Name dari InfinityFree
    $db_pass = 'YOUR_V_PANEL_PASSWORD_HERE'; // <--- SANGAT PENTING: GANTI DENGAN PASSWORD V-PANEL ASLI KAMU!
    $db_name = 'ifo_39420600_molen_bagus'; // MySQL DB Name dari InfinityFree
}

// --- BARIS DEBUGGING LAGI DI SINI ---
echo "DB Host yang digunakan: " . $db_host . "<br>";
echo "DB User yang digunakan: " . $db_user . "<br>";
echo "DB Name yang digunakan: " . $db_name . "<br>";
echo "Mencoba koneksi ke database...<br>";
// --- BARIS DEBUGGING BERAKHIR DI SINI ---

// Membuat koneksi ke database menggunakan MySQLi (objek oriented)
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Mengecek koneksi
if ($conn->connect_error) {
    // Jika koneksi gagal, hentikan eksekusi script dan tampilkan pesan error
    die("Koneksi database GAGAL: " . $conn->connect_error . "<br>"); // Ubah ini sedikit agar debug sebelumnya bisa terlihat
}

// Mengatur charset untuk koneksi agar mendukung karakter khusus (misalnya emoji, aksara lain)
$conn->set_charset("utf8mb4");

// Jika koneksi berhasil, pesan ini akan muncul sebelum konten website
echo "DEBUG: Koneksi database BERHASIL! (Ini akan hilang saat debugging selesai)<br>";

?>