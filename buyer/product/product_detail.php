<?php
session_start();
include('../../includes/db.php');

// Cek apakah pengguna sudah login
if (!isset($_SESSION['iduser'])) {  // Ganti 'user_id' menjadi 'iduser'
    $show_modal = true;  // Tampilkan modal peringatan
} else {
    $show_modal = false;  // Tidak perlu modal jika sudah login
}

// Cek apakah ID produk diberikan dalam URL
if (!isset($_GET['id'])) {
    echo "Produk tidak ditemukan.";
    exit();
}

// Ambil ID produk dari URL
$product_id = $_GET['id'];

// Query untuk mengambil detail produk berdasarkan ID
$query = "SELECT * FROM produk WHERE idproduk = '$product_id'";
$result = mysqli_query($conn, $query);

// Cek apakah query berhasil
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

// Cek apakah produk ditemukan
$product = mysqli_fetch_assoc($result);
if (!$product) {
    echo "Produk tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Modal Background with Glassmorphism Effect */
        #loginModal {
            backdrop-filter: blur(10px); /* Apply blur effect to the background */
            background-color: rgba(0, 0, 0, 0.3); /* Semi-transparent dark background */
        }
    </style>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <?php include('../../buyer/product/header.php'); ?>

    <!-- Modal Peringatan -->
    <?php if ($show_modal): ?>
        <div id="loginModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-8 rounded-lg shadow-lg max-w-sm w-full">
                <h2 class="text-2xl font-semibold mb-4">Peringatan</h2>
                <p class="text-gray-700 mb-4">Anda harus login terlebih dahulu untuk melihat detail produk.</p>
                <button id="redirectToLogin" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">OK</button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Container -->
    <div class="max-w-6xl mx-auto p-8 mt-10 bg-white shadow-lg rounded-lg mb-10">
        <h2 class="text-3xl font-semibold text-center mb-6 text-gray-800"><?= htmlspecialchars($product['nama']); ?></h2>

        <!-- Grid Layout for Image and Product Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Product Image -->
            <div class="text-center md:text-left">
                <img src="../../uploads/<?= htmlspecialchars($product['foto1']); ?>" alt="Gambar Produk" class="w-full h-auto rounded-lg shadow-lg">
            </div>

            <!-- Product Details -->
            <div>
                <div class="mb-4">
                    <p class="text-2xl font-semibold text-gray-800">Harga: Rp <?= number_format($product['harga'], 0, ',', '.'); ?></p>
                </div>
                <div class="mb-4">
                    <p class="text-xl text-gray-700">Stok: <?= $product['stok']; ?> unit</p>
                </div>

                <div class="mb-4">
                    <p class="text-lg text-gray-700 font-semibold">Spesifikasi:</p>
                    <p class="text-gray-700"><?= nl2br(htmlspecialchars($product['spesifikasi'])); ?></p>
                </div>

                <div class="mb-4">
                    <p class="text-lg text-gray-700 font-semibold">Detail:</p>
                    <!-- Scrollable and collapsible details -->
                    <div class="detail-container overflow-hidden h-32 transition-all duration-300 ease-in-out">
                        <p class="text-gray-700"><?= nl2br(htmlspecialchars($product['detail'])); ?></p>
                    </div>
                    <span id="toggle-detail" class="text-blue-500 cursor-pointer mt-2 inline-block">Lihat Selengkapnya</span>
                </div>

                <div class="mb-4">
                    <p class="text-lg text-gray-700">Berat: <?= $product['berat']; ?> kg</p>
                </div>

                <?php if ($product['diskon'] > 0): ?>
                    <div class="mb-4">
                        <p class="text-lg text-red-600 font-semibold">Diskon: <?= $product['diskon']; ?>%</p>
                    </div>
                <?php endif; ?>

                <!-- Add to Cart Form -->
                <form action="cart_add.php" method="post" class="mt-6">
                    <input type="hidden" name="product_id" value="<?= $product['idproduk']; ?>">
                    <input type="number" name="quantity" min="1" max="<?= $product['stok']; ?>" value="1" required class="w-24 p-2 border border-gray-300 rounded-lg">
                    <button type="submit" class="mt-4 px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Tambah ke Keranjang
                    </button>
                </form>
            </div>
        </div>

        <!-- Back to Product Page -->
        <div class="mt-8 text-center">
            <a href="/index.php" class="inline-block px-6 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                Kembali ke Produk
            </a>
        </div>
    </div>

    <script>
        // Toggle Detail Section
        document.getElementById('toggle-detail').addEventListener('click', function() {
            const detailContainer = document.querySelector('.detail-container');
            detailContainer.classList.toggle('h-auto');
            detailContainer.classList.toggle('h-32'); // Change height when clicked

            if (detailContainer.classList.contains('h-auto')) {
                this.textContent = 'Lihat Lebih Sedikit';
            } else {
                this.textContent = 'Lihat Selengkapnya';
            }
        });

        // Redirect to login page when "OK" button is clicked
        document.getElementById('redirectToLogin').addEventListener('click', function() {
            window.location.href = '../auth/login.php'; // Direct user to login page
        });
    </script>

    <?php include('../product/footer.php'); ?>

</body>
</html>
