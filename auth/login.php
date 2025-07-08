<?php
require_once '../config/database.php'; // Memanggil file koneksi database

session_start(); // Memulai session untuk menyimpan status login

$message = ''; // Variabel untuk menyimpan pesan sukses/error

// Jika user sudah login, arahkan ke halaman yang sesuai
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: ../admin/dashboard.php'); // Arahkan ke dashboard admin
    } else {
        header('Location: ../index.php'); // Arahkan ke halaman utama user
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi input
    if (empty($username) || empty($password)) {
        $message = "<div style='color: red;'>Username dan password tidak boleh kosong.</div>";
    } else {
        // Cari user di database
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Verifikasi password yang diinput dengan hash di database
            if (password_verify($password, $user['password'])) {
                // Password cocok, set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Arahkan user sesuai role
                if ($user['role'] === 'admin') {
                    header('Location: ../admin/dashboard.php');
                } else {
                    header('Location: ../index.php'); // Atau halaman user khusus
                }
                exit(); // Penting untuk menghentikan eksekusi script setelah redirect
            } else {
                $message = "<div style='color: red;'>Password salah.</div>";
            }
        } else {
            $message = "<div style='color: red;'>Username tidak ditemukan.</div>";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Akun</title>
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
        <h2 class="text-2xl font-bold text-center mb-6">Login ke Akun Anda</h2>
        <?php echo $message; ?>
        <form action="login.php" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-sm font-semibold mb-2">Username:</label>
                <input type="text" id="username" name="username" class="form-input" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-semibold mb-2">Password:</label>
                <input type="password" id="password" name="password" class="form-input" required>
            </div>
            <button type="submit" class="btn-primary">Login</button>
        </form>
        <p class="text-center text-sm mt-4">Belum punya akun? <a href="register.php" class="text-orange-500 hover:underline">Daftar di sini</a></p>
    </div>
</body>
</html>