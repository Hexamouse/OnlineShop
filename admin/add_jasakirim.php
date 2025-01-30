<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$showModal = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $tarif = $_POST['tarif'];

    // Upload logo
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["logo"]["name"]);
    move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);
    $logo = basename($_FILES["logo"]["name"]);

    $stmt = $conn->prepare("INSERT INTO jasakirim (nama, logo, tarif) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $nama, $logo, $tarif);
    $stmt->execute();
    $stmt->close();

    header("Location: add_jasakirim.php?success=1");
    exit;
}

// Check if the 'success' parameter is set in the URL
if (isset($_GET['success'])) {
    $showModal = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jasa Kirim</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="max-w-lg w-full bg-white shadow-lg rounded-lg p-6">
        
        <!-- Tombol Kembali -->
        <div class="flex justify-between items-center mb-4">
            <a href="admin_jasakirim.php" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                ← Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Jasa Kirim</h1>
        </div>

        <form action="" method="post" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block font-medium text-gray-700">Nama Jasa Kirim:</label>
                <input type="text" name="nama" required class="w-full p-3 border rounded-lg focus:ring focus:ring-indigo-300">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Tarif (Rp):</label>
                <input type="number" name="tarif" required class="w-full p-3 border rounded-lg focus:ring focus:ring-indigo-300">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Logo:</label>
                <input type="file" name="logo" required class="w-full p-3 border rounded-lg focus:ring focus:ring-indigo-300">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                + Tambah Jasa Kirim
            </button>
        </form>
    </div>

    <!-- Modal Notification -->
    <?php if ($showModal): ?>
    <div id="notificationModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
            <h2 class="text-xl font-semibold text-green-600">Jasa Kirim Berhasil Ditambahkan!</h2>
            <p class="text-gray-700 mt-2">Jasa kirim baru telah berhasil ditambahkan ke sistem.</p>
            <button onclick="closeModal()" class="mt-4 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                Tutup
            </button>
        </div>
    </div>
    <script>
        function closeModal() {
            document.getElementById('notificationModal').style.display = 'none';
        }
    </script>
    <?php endif; ?>

</body>
</html>