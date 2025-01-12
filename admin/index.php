<?php
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: ../login.php");
    exit();
}

$admin_name = $_SESSION['admin_name'];  // Nama admin yang login
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <div class="w-64 bg-indigo-600 text-white p-6">
            <h2 class="text-2xl font-bold mb-8">Admin Dashboard</h2>
            <ul>
                <li>
                    <a href="index.php" class="text-lg py-2 hover:bg-indigo-500 rounded px-4 block">Dashboard</a>
                </li>
                <li>
                    <a href="manage-products.php" class="text-lg py-2 hover:bg-indigo-500 rounded px-4 block">Manage Products</a>
                </li>
                <li>
                    <a href="manage-users.php" class="text-lg py-2 hover:bg-indigo-500 rounded px-4 block">Manage Users</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-semibold text-gray-800 mb-4">Halo, <?php echo $admin_name; ?>!</h1>

            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Dashboard Admin</h2>
                <p class="text-gray-600 mt-2">Selamat datang di panel admin. Anda dapat mengelola produk, pengguna, dan lainnya di sini.</p>
            </div>

            <!-- Fitur-fitur Admin -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                <!-- Card untuk mengelola produk -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800">Manage Products</h3>
                    <p class="text-gray-600">Kelola produk yang tersedia di toko Anda.</p>
                    <a href="manage-products.php" class="mt-4 inline-block py-2 px-4 bg-indigo-600 text-white rounded hover:bg-indigo-700">Manage Products</a>
                </div>

                <!-- Card untuk mengelola pengguna -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800">Manage Users</h3>
                    <p class="text-gray-600">Kelola akun pengguna yang terdaftar.</p>
                    <a href="manage-users.php" class="mt-4 inline-block py-2 px-4 bg-indigo-600 text-white rounded hover:bg-indigo-700">Manage Users</a>
                </div>

                <!-- Card untuk menambah produk -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800">Add New Product</h3>
                    <p class="text-gray-600">Tambahkan produk baru ke toko Anda.</p>
                    <a href="../admin/product_add.php" class="mt-4 inline-block py-2 px-4 bg-indigo-600 text-white rounded hover:bg-indigo-700">Add Product</a>
                </div>
            </div>

            <!-- Logout -->
            <div class="mt-6">
                <a href="../admin/logout.php" class="text-indigo-600 hover:text-indigo-800">Logout</a>
            </div>
        </div>
    </div>

</body>
</html>
