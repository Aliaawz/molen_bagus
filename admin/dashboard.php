<?php
session_start(); // Mulai session

// Lindungi halaman ini: hanya admin yang bisa mengakses
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php'); // Arahkan ke login jika belum login atau bukan admin
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        body {
            background-color: #FFF7ED; /* bg-orange-50 */
            color: #374151; /* text-gray-800 */
        }
    </style>
</head>
<body class="bg-orange-50 text-gray-800 p-8">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl p-6 shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Dashboard Admin</h1>
            <a href="../auth/logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300">
                <i class="fa fa-sign-out-alt mr-2"></i>Logout
            </a>
        </div>

        <p class="mb-4">Selamat datang, <span class="font-semibold"><?php echo htmlspecialchars($_SESSION['username']); ?></span> (Role: <?php echo htmlspecialchars($_SESSION['role']); ?>).</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-blue-100 p-5 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-3 text-blue-800">Manajemen Produk</h2>
                <p class="mb-4 text-blue-700">Kelola daftar molen dan produk lainnya.</p>
                <a href="products.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                    Kelola Produk
                </a>
            </div>

            <div class="bg-green-100 p-5 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-3 text-green-800">Manajemen Ulasan</h2>
                <p class="mb-4 text-green-700">Tinjau dan kelola ulasan dari pelanggan.</p>
                <a href="reviews.php" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-300">
                    Kelola Ulasan
                </a>
            </div>
        </div>
    </div>
</body>
</html>