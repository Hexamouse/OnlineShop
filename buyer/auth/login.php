<?php
// Menambahkan session jika diperlukan untuk login status
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Kadai Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Header -->
    <header class="bg-gradient-to-r from-gray-800 via-gray-900 to-black text-white py-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center px-8 max-w-screen-xl">
            <h1 class="text-4xl font-bold tracking-wide text-yellow-400 hover:text-yellow-500 cursor-pointer transition-all duration-300">
                <a href="/index.php">Kadai Online</a>
            </h1>
        </div>
    </header>

    <!-- Login Section -->
    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Login ke Akun Anda</h2>
            <form action="login_process.php" method="POST">
                <!-- Email Input -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400" placeholder="Email Anda">
                </div>
                <!-- Password Input -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400" placeholder="Password Anda">
                </div>
                <!-- Submit Button -->
                <button type="submit" class="w-full py-2 px-4 bg-yellow-400 text-white font-semibold rounded-lg hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-600 transition-all duration-300">
                    Login
                </button>
            </form>
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">Belum punya akun? <a href="register.php" class="text-yellow-500 hover:underline">Daftar sekarang</a></p>
            </div>
        </div>
    </div>

    <!-- Footer (Optional) -->
    <footer class="bg-gray-800 text-white py-4">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Kadai Online. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>