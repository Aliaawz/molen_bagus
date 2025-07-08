<?php
session_start(); // Mulai session

// Hapus semua variabel session
$_SESSION = array();

// Hapus session cookie. Ini akan menghancurkan session,
// dan juga menghapus session cookie.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Terakhir, hancurkan session
session_destroy();

// Tambahkan baris ini untuk debugging
// echo "Session dihancurkan. Mengarahkan ke login...";
// exit(); // Gunakan ini sementara jika redirect tidak bekerja

// Arahkan kembali ke halaman login
header('Location: login.php');
exit();
?>