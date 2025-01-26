<?php
session_start();
include('../includes/db.php');

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Handle penghapusan produk
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    // Query untuk menghapus produk
    $query_delete = "DELETE FROM produk WHERE idproduk = ?";
    $stmt = $conn->prepare($query_delete);
    $stmt->bind_param('i', $delete_id);

    if ($stmt->execute()) {
        header("Location: manage-products.php?message=Produk+berhasil+dihapus");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Query untuk mengambil data produk
$query_produk = "SELECT * FROM produk";
$result_produk = mysqli_query($conn, $query_produk);

// Cek apakah query produk berhasil
if (!$result_produk) {
    die("Query Produk Gagal: " . mysqli_error($conn));
}
?>

<head>
    <title>Kelola Produk</title>
    <!-- Menyertakan CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: white;
            background: linear-gradient(to right, #80808033 1px, transparent 1px), linear-gradient(to bottom, #80808033 1px, transparent 1px);
            background-size: 70px 70px;
        }
    </style>
    <script>
        // Fungsi untuk reload halaman jika pesan keberhasilan ada
        window.onload = function() {
            const params = new URLSearchParams(window.location.search);
            if (params.has('message')) {
                setTimeout(() => {
                    window.location.href = 'manage-products.php';
                }, 2000); // Reload setelah 2 detik
            }
        };
    </script>
</head>

<body class="min-h-screen flex items-center justify-center bg-white dark:bg-secondaryBlack font-base">
    <div class="space-y-6 bg-white p-6 rounded-lg shadow-lg max-w-5xl mx-auto mt-10">
        <h2 class="text-2xl font-semibold text-center mb-6">Kelola Produk</h2>

        <!-- Pesan Notifikasi -->
        <?php if (isset($_GET['message'])): ?>
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                <?= htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <!-- Tabel Produk -->
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Nama</th>
                        <th class="border border-gray-300 px-4 py-2">Harga</th>
                        <th class="border border-gray-300 px-4 py-2">Stok</th>
                        <th class="border border-gray-300 px-4 py-2">Kategori</th>
                        <th class="border border-gray-300 px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($produk = mysqli_fetch_assoc($result_produk)): ?>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= $produk['idproduk']; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $produk['nama']; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-right">Rp<?= number_format($produk['harga'], 2, ',', '.'); ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= $produk['stok']; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $produk['idkat']; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <a href="edit_product.php?id=<?= $produk['idproduk']; ?>" class="inline-block px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">Edit</a>
                                <a href="manage-products.php?delete_id=<?= $produk['idproduk']; ?>" class="inline-block px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Tombol Kembali ke Dashboard -->
        <div class="text-center mt-4">
            <a href="../admin/index.php" class="inline-block px-6 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</body>