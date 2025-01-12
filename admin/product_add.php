<?php
session_start();
include('../includes/db.php');

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Query untuk mengambil data kategori
$query_kategori = "SELECT * FROM kategori";
$result_kategori = mysqli_query($conn, $query_kategori);

// Cek apakah query kategori berhasil
if (!$result_kategori) {
    die("Query Kategori Gagal: " . mysqli_error($conn));
}

if (isset($_POST['add_product'])) {
    // Ambil data dari form
    $idkat = $_POST['idkat']; // Menyimpan kategori yang dipilih
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $spesifikasi = $_POST['spesifikasi'];
    $detail = $_POST['detail'];
    $diskon = isset($_POST['diskon']) ? $_POST['diskon'] : ''; // Cek jika diskon kosong
    $berat = $_POST['berat'];
    $isikotak = $_POST['isikotak'];
    $foto1 = $_FILES['foto1']['name'];
    $foto2 = $_FILES['foto2']['name'];

    // Upload foto
    move_uploaded_file($_FILES['foto1']['tmp_name'], "../uploads/$foto1");
    move_uploaded_file($_FILES['foto2']['tmp_name'], "../uploads/$foto2");

    // Query untuk menyimpan produk ke dalam database
    $query = "INSERT INTO produk (idkat, idadmin, nama, harga, stok, spesifikasi, detail, diskon, berat, isikotak, foto1, foto2, tglproduk)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    // Persiapkan query
    $stmt = $conn->prepare($query);
    
    // Bind parameters sesuai dengan jumlah dan tipe
    $stmt->bind_param('iissdssssss', $idkat, $_SESSION['admin_id'], $nama, $harga, $stok, $spesifikasi, $detail, $diskon, $berat, $isikotak, $foto1, $foto2);

    // Eksekusi query
    if ($stmt->execute()) {
        // Jika sukses, redirect ke halaman index
        header("Location: ../index.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . $stmt->error;
    }
}
?>

<!-- Formulir untuk menambah produk -->
<head>
    <title>Tambah Produk</title>
    <!-- Menyertakan CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            /* Setting background seperti yang diminta */
            background-color: white;
            background: linear-gradient(to right, #80808033 1px, transparent 1px), linear-gradient(to bottom, #80808033 1px, transparent 1px);
            background-size: 70px 70px; /* Ukuran kotak */
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-white dark:bg-secondaryBlack font-base">
    <form action="product_add.php" method="post" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-lg shadow-lg max-w-lg mx-auto mt-10">
        <h2 class="text-2xl font-semibold text-center mb-6">Tambah Produk</h2>

        <!-- Pilih Kategori -->
        <div class="grid grid-cols-1 gap-4">
            <label for="idkat" class="block text-lg font-medium text-gray-700">Kategori</label>
            <select name="idkat" id="idkat" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                <option value="" disabled selected>Pilih Kategori</option>
                <?php while ($kategori = mysqli_fetch_assoc($result_kategori)): ?>
                    <option value="<?= $kategori['idkat']; ?>"><?= $kategori['namakat']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Nama Produk -->
        <div class="grid grid-cols-1 gap-4">
            <label for="nama" class="block text-lg font-medium text-gray-700">Nama Produk</label>
            <input type="text" name="nama" id="nama" placeholder="Nama Produk" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Kolom Harga dan Stok dalam satu baris -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="harga" class="block text-lg font-medium text-gray-700">Harga</label>
                <input type="number" step="0.01" name="harga" id="harga" placeholder="Harga" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label for="stok" class="block text-lg font-medium text-gray-700">Stok</label>
                <input type="number" name="stok" id="stok" placeholder="Stok" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <!-- Kolom Spesifikasi dan Detail Produk dalam satu baris -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="spesifikasi" class="block text-lg font-medium text-gray-700">Spesifikasi</label>
                <textarea name="spesifikasi" id="spesifikasi" placeholder="Spesifikasi" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>
            <div>
                <label for="detail" class="block text-lg font-medium text-gray-700">Detail Produk</label>
                <textarea name="detail" id="detail" placeholder="Detail Produk" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>
        </div>

        <!-- Kolom Diskon dan Berat dalam satu baris -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="diskon" class="block text-lg font-medium text-gray-700">Diskon</label>
                <input type="number" step="0.01" name="diskon" id="diskon" placeholder="Diskon (jika ada)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label for="berat" class="block text-lg font-medium text-gray-700">Berat</label>
                <input type="number" step="0.01" name="berat" id="berat" placeholder="Berat Produk" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <!-- Isi Kotak -->
        <div class="grid grid-cols-1 gap-4">
            <label for="isikotak" class="block text-lg font-medium text-gray-700">Isi Kotak</label>
            <input type="text" name="isikotak" id="isikotak" placeholder="Isi Kotak" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Input Foto 1 -->
        <div class="grid grid-cols-1 gap-4">
            <label for="foto1" class="block text-lg font-medium text-gray-700">Foto 1</label>
            <input type="file" name="foto1" id="foto1" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Input Foto 2 -->
        <div class="grid grid-cols-1 gap-4">
            <label for="foto2" class="block text-lg font-medium text-gray-700">Foto 2</label>
            <input type="file" name="foto2" id="foto2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Tombol Submit -->
        <div class="text-center">
            <button type="submit" name="add_product" class="mt-6 px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Tambah Produk
            </button>
        </div>

        <!-- Tombol Kembali ke Dashboard -->
        <div class="text-center mt-4">
            <a href="../admin/index.php" class="inline-block px-6 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                Kembali ke Dashboard
            </a>
        </div>
    </form>
</body>
