<?php
session_start();
include('../includes/db.php');

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Handle penghapusan pengguna
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    // Query untuk menghapus pengguna
    $query_delete = "DELETE FROM users WHERE iduser = ?";
    $stmt = $conn->prepare($query_delete);
    $stmt->bind_param('i', $delete_id);

    if ($stmt->execute()) {
        header("Location: manage-users.php?message=Pengguna+berhasil+dihapus");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Query untuk mengambil data pengguna
$query_users = "SELECT * FROM users";
$result_users = mysqli_query($conn, $query_users);

// Cek apakah query pengguna berhasil
if (!$result_users) {
    die("Query Users Gagal: " . mysqli_error($conn));
}
?>

<head>
    <title>Kelola Pengguna</title>
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
                    window.location.href = 'manage-users.php';
                }, 2000); // Reload setelah 2 detik
            }
        };
    </script>
</head>

<body class="min-h-screen flex items-center justify-center bg-white dark:bg-secondaryBlack font-base">
    <div class="space-y-6 bg-white p-6 rounded-lg shadow-lg max-w-5xl mx-auto mt-10">
        <h2 class="text-2xl font-semibold text-center mb-6">Kelola Pengguna</h2>

        <!-- Pesan Notifikasi -->
        <?php if (isset($_GET['message'])): ?>
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                <?= htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <!-- Tabel Pengguna -->
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Username</th>
                        <th class="border border-gray-300 px-4 py-2">Password</th>
                        <th class="border border-gray-300 px-4 py-2">Nama Lengkap</th>
                        <th class="border border-gray-300 px-4 py-2">Email</th>
                        <th class="border border-gray-300 px-4 py-2">Status</th>
                        <th class="border border-gray-300 px-4 py-2">Tanggal Daftar</th>
                        <th class="border border-gray-300 px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($result_users)): ?>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= $user['iduser']; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $user['username']; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $user['password']; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $user['nama_lengkap']; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $user['email']; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <?php if ($user['status'] === 'Active'): ?>
                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm rounded-lg">Active</span>
                                <?php elseif ($user['status'] === 'Warning'): ?>
                                    <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-lg">Warning</span>
                                <?php elseif ($user['status'] === 'Blocked'): ?>
                                    <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-sm rounded-lg">Blocked</span>
                                <?php else: ?>
                                    <span class="inline-block px-3 py-1 bg-gray-100 text-gray-800 text-sm rounded-lg">Unknown</span>
                                <?php endif; ?>
                            </td>
                            <td class="border border-gray-300 px-4 py-2"><?= $user['tgl_daftar']; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <a href="edit_user.php?id=<?= $user['iduser']; ?>" class="inline-block px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">Edit</a>
                                <a href="manage-users.php?delete_id=<?= $user['iduser']; ?>" class="inline-block px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">Hapus</a>
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