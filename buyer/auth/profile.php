<?php
session_start();
include('../../includes/db.php');

// Cek apakah pengguna sudah login
if (!isset($_SESSION['iduser'])) {
    echo "Anda belum login. Harap login terlebih dahulu.";
    exit();
}

// Ambil ID pengguna dari session
$user_id = $_SESSION['iduser'];

// Query untuk mengambil data pengguna berdasarkan session
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);

// Cek apakah query berhasil
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);

// Proses update profil
if (isset($_POST['update_profile'])) {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $foto = $_FILES['foto']['name'];

    // Jika ada foto yang diupload, proses upload foto
    if ($foto) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($foto);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
    } else {
        // Jika tidak ada foto baru, gunakan foto lama
        $foto = $user['foto'];
    }

    // Query untuk update data pengguna
    $update_query = "UPDATE users SET nama = '$nama', email = '$email', foto = '$foto' WHERE id = '$user_id'";

    if (mysqli_query($conn, $update_query)) {
        // Jika berhasil, redirect ke halaman profil
        header("Location: profile.php");
        exit();
    } else {
        // Jika gagal, tampilkan error
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="max-w-4xl mx-auto p-6 mt-10 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold text-center mb-6">Profil Pengguna</h2>

        <form action="profile.php" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="nama" class="block text-lg font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($user['nama']); ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']); ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-4">
                <label for="foto" class="block text-lg font-medium text-gray-700">Foto Profil</label>
                <input type="file" name="foto" id="foto" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                <small class="text-gray-500">*Opsional, biarkan kosong jika tidak ingin mengubah foto.</small>
            </div>

            <div class="text-center">
                <button type="submit" name="update_profile" class="mt-4 px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Update Profil
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <a href="dashboard.php" class="inline-block px-6 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                Kembali ke Dashboard
            </a>
        </div>
    </div>

</body>
</html>