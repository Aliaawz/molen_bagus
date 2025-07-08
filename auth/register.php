<?php
require_once '../config/database.php'; // Memanggil file koneksi database

$message = ''; // Variabel untuk menyimpan pesan sukses/error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = 'user'; // Default role untuk pendaftar baru

    // Validasi input
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $message = "<div style='color: red;'>Username dan password tidak boleh kosong.</div>";
    } elseif ($password !== $confirm_password) {
        $message = "<div style='color: red;'>Konfirmasi password tidak cocok.</div>";
    } else {
        // Hash password sebelum disimpan ke database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Cek apakah username sudah ada
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "<div style='color: red;'>Username sudah terdaftar, silakan gunakan username lain.</div>";
        } else {
            // Masukkan data user baru ke database
            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashed_password, $role);

            if ($stmt->execute()) {
                $message = "<div style='color: green;'>Registrasi berhasil! Silakan <a href='login.php'>login</a>.</div>";
            } else {
                $message = "<div style='color: red;'>Registrasi gagal: " . $stmt->error . "</div>";
            }
        }
        $stmt->close();
    }
}
$conn->close(); // Tutup koneksi setelah selesai memproses request
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #FFF7ED; /* bg-orange-50 */
            color: #374151; /* text-gray-800 */
        }
        .container {
            max-width: 448px; /* max-w-md */
            margin-left: auto;
            margin-right: auto;
            padding: 1rem; /* p-4 */
        }
        .form-input {
            width: 100%;
            padding: 0.75rem; /* p-3 */
            border-radius: 0.5rem; /* rounded-lg */
            border: 1px solid #D1D5DB; /* border-gray-300 */
            margin-bottom: 1rem; /* mb-4 */
        }
        .btn-primary {
            background-color: #F97316; /* bg-orange-500 */
            color: white;
            padding: 0.75rem 1rem; /* px-4 py-2 */
            border-radius: 0.5rem; /* rounded-lg */
            width: 100%;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #EA580C; /* hover:bg-orange-600 */
        }
    </style>
</head>
<body class="bg-orange-50 text-gray-800 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-2xl p-8 shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Registrasi Akun</h2>
        <?php echo $message; ?>
        <form action="register.php" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-sm font-semibold mb-2">Username:</label>
                <input type="text" id="username" name="username" class="form-input" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold mb-2">Password:</label>
                <input type="password" id="password" name="password" class="form-input" required>
            </div>
            <div class="mb-6">
                <label for="confirm_password" class="block text-sm font-semibold mb-2">Konfirmasi Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-input" required>
            </div>
            <button type="submit" class="btn-primary">Daftar</button>
        </form>
        <p class="text-center text-sm mt-4">Sudah punya akun? <a href="login.php" class="text-orange-500 hover:underline">Login di sini</a></p>
    </div>
</body>
</html>