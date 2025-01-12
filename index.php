<?php
session_start();
include('includes/db.php');

// Query untuk mengambil semua produk
$query = "SELECT * FROM produk";
$result = mysqli_query($conn, $query);

// Cek apakah query berhasil
if (!$result) {
    die("Query Produk Gagal: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Online Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Header -->
    <?php include 'includes/header.php' ?>

    <!-- Banner / Image Slider -->
    <?php include 'includes/slide.php' ?>

    <!-- Daftar Produk -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-10">Produk Kami</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while ($product = mysqli_fetch_assoc($result)): ?>
                    <div class="bg-white border rounded-lg shadow-lg overflow-hidden">
                        <img src="assets/images/<?= $product['foto1']; ?>" alt="<?= $product['nama']; ?>" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold"><?= $product['nama']; ?></h3>
                            <p class="text-lg font-semibold mt-4">Rp <?= number_format($product['harga'], 2, ',', '.'); ?></p>
                            
                            <!-- Menambahkan Diskon jika ada -->
                            <?php if (!empty($product['diskon'])): ?>
                                <p class="text-lg text-red-500 mt-2">Diskon: <?= $product['diskon']; ?>%</p>
                            <?php endif; ?>

                            <!-- Menambahkan Deskripsi Produk -->
                            <?php if (!empty($product['detail'])): ?>
                                <p class="text-sm text-gray-600 mt-2"><?= substr($product['detail'], 0, 100); ?>...</p>
                            <?php endif; ?>

                            <a href="product_detail.php?id=<?= $product['idproduk']; ?>" class="block bg-gray-800 text-white text-center py-2 mt-4 rounded hover:bg-yellow-400">Lihat Detail</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php' ?>

</body>
</html>

<script>
// JavaScript untuk mengendalikan slider otomatis dan manual

let currentIndex = 0;
const slides = document.querySelectorAll('#slider img');
const totalSlides = slides.length;

function showSlide(index) {
    // Menentukan pergeseran gambar dengan menggunakan transform
    const slider = document.getElementById('slider');
    const offset = -index * 100; // Setiap gambar akan bergerak 100% lebar ke kiri
    slider.style.transform = `translateX(${offset}%)`;
}

function nextSlide() {
    currentIndex = (currentIndex + 1) % totalSlides;
    showSlide(currentIndex);
}

function prevSlide() {
    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
    showSlide(currentIndex);
}

// Otomatis bergeser setiap 5 detik
setInterval(nextSlide, 5000);
</script>
