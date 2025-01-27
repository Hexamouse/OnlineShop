<?php
session_start();
include('../includes/db.php'); // Menyambung ke database

// Cek apakah pengguna adalah admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php'); // Redirect ke login jika bukan admin
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $voucher_code = $_POST['voucher_code'];
    $discount_percentage = $_POST['discount_percentage'];
    $expiration_date = $_POST['expiration_date'];

    // Validasi input
    if (empty($voucher_code) || empty($discount_percentage) || empty($expiration_date)) {
        $error_message = "Semua kolom harus diisi!";
    } elseif (!is_numeric($discount_percentage) || $discount_percentage <= 0 || $discount_percentage > 100) {
        $error_message = "Diskon harus dalam rentang 1-100!";
    } else {
        // Simpan voucher ke database
        $query = "INSERT INTO vouchers (voucher_code, discount_percentage, expiration_date) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sds", $voucher_code, $discount_percentage, $expiration_date);

        if ($stmt->execute()) {
            $success_message = "Voucher berhasil ditambahkan!";
        } else {
            $error_message = "Terjadi kesalahan saat menambahkan voucher. Coba lagi!";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Voucher</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<main class="p-6 max-w-4xl mx-auto bg-white shadow-lg rounded-lg mt-12">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Tambah Voucher Baru</h1>

    <!-- Error or Success Message -->
    <?php if (isset($error_message)): ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <strong>Error: </strong> <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($success_message)): ?>
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            <strong>Success: </strong> <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>

    <!-- Form -->
    <form action="voucher-add.php" method="POST">
        <div class="mb-6">
            <label for="voucher_code" class="block text-sm font-semibold text-gray-700 mb-2">Kode Voucher</label>
            <input type="text" name="voucher_code" id="voucher_code" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan kode voucher" required>
        </div>

        <div class="mb-6">
            <label for="discount_percentage" class="block text-sm font-semibold text-gray-700 mb-2">Diskon (%)</label>
            <input type="number" name="discount_percentage" id="discount_percentage" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan persentase diskon" required>
        </div>

        <div class="mb-6">
            <label for="expiration_date" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Kedaluwarsa</label>
            <input type="date" name="expiration_date" id="expiration_date" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Tambah Voucher</button>
        </div>
    </form>
</main>

</body>
</html>