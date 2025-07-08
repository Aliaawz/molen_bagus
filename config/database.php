<?php
// Konfigurasi Database untuk LOKAL (XAMPP)

// Host database lokal, biasanya 'localhost'
define('DB_HOST', 'localhost');

// Username database XAMPP, defaultnya 'root'
define('DB_USER', 'root');

// Password database XAMPP, defaultnya kosong
define('DB_PASS', '');

// Nama database yang sudah kita buat di XAMPP
define('DB_NAME', 'molen_bagus_db'); // Pastikan ini nama database lokalmu

// Membuat koneksi ke database menggunakan MySQLi (objek oriented)
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Mengatur charset untuk koneksi
$conn->set_charset("utf8mb4");

?>