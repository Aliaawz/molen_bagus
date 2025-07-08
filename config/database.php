<?php

// Konfigurasi Database
define('DB_HOST', 'localhost'); // Host database, biasanya 'localhost'
define('DB_USER', 'root');     // Username database XAMPP, defaultnya 'root'
define('DB_PASS', '');         // Password database XAMPP, defaultnya kosong
define('DB_NAME', 'molen_bagus_db'); // Nama database yang sudah kita buat

// Membuat koneksi ke database menggunakan MySQLi (objek oriented)
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Mengatur charset untuk koneksi
$conn->set_charset("utf8mb4");

// Anda bisa menguji koneksi di sini (opsional)
// echo "Koneksi database berhasil!";
// close the connection when not needed, but typically you'll leave it open for the duration of the script.
// $conn->close();

?>