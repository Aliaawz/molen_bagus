<?php
session_start(); // Mulai session
require_once '../config/database.php'; // Memanggil file koneksi database

// Lindungi halaman ini: hanya admin yang bisa mengakses
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php'); // Arahkan ke login jika belum login atau bukan admin
    exit();
}

// Ambil data produk dari database
$products = [];
$sql = "SELECT id, name, price, image, description FROM products ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        body { background-color: #FFF7ED; color: #374151; }
        .table-container { overflow-x: auto; }
        .action-btn { margin-right: 0.5rem; }
    </style>
</head>
<body class="bg-orange-50 text-gray-800 p-8">
    <div class="max-w-6xl mx-auto bg-white rounded-2xl p-6 shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Manajemen Produk</h1>
            <div class="flex items-center space-x-4">
                <a href="add_product.php" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300">
                    <i class="fa fa-plus mr-2"></i>Tambah Produk
                </a>
                <a href="dashboard.php" class="text-blue-600 hover:underline">
                    <i class="fa fa-arrow-left mr-2"></i>Kembali ke Dashboard
                </a>
                <a href="../auth/logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300">
                    <i class="fa fa-sign-out-alt mr-2"></i>Logout
                </a>
            </div>
        </div>

        <?php if (empty($products)): ?>
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                <p class="font-bold">Informasi</p>
                <p>Belum ada produk yang ditambahkan.</p>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-sm">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="py-2 px-4 border-b">ID</th>
                            <th class="py-2 px-4 border-b">Gambar</th>
                            <th class="py-2 px-4 border-b">Nama Produk</th>
                            <th class="py-2 px-4 border-b">Harga</th>
                            <th class="py-2 px-4 border-b">Deskripsi</th>
                            <th class="py-2 px-4 border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($product['id']); ?></td>
                                <td class="py-2 px-4 border-b">
                                    <?php if (!empty($product['image']) && file_exists('../images/' . $product['image'])): ?>
                                        <img src="../images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-16 h-16 object-cover rounded">
                                    <?php else: ?>
                                        <span class="text-gray-500 text-sm">Tidak ada gambar</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-2 px-4 border-b font-medium"><?php echo htmlspecialchars($product['name']); ?></td>
                                <td class="py-2 px-4 border-b">Rp<?php echo number_format($product['price'], 0, ',', '.'); ?></td>
                                <td class="py-2 px-4 border-b text-sm"><?php echo htmlspecialchars(substr($product['description'], 0, 50)); ?><?php echo (strlen($product['description']) > 50) ? '...' : ''; ?></td>
                                <td class="py-2 px-4 border-b whitespace-nowrap">
                                    <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="action-btn text-blue-600 hover:underline">Edit</a>
                                    <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="action-btn text-red-600 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>