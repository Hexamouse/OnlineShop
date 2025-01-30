<?php
// Memulai session untuk menyimpan status login
session_start();

// Memasukkan koneksi database
require_once '../../includes/db.php'; // Pastikan path file ini sesuai

// Fungsi untuk login
function login($email, $password) {
    global $conn;

    // Query untuk memeriksa apakah email ada dalam database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameter ke query
    mysqli_stmt_bind_param($stmt, "s", $email);

    // Eksekusi query
    mysqli_stmt_execute($stmt);

    // Ambil hasil query
    $result = mysqli_stmt_get_result($stmt);

    // Memeriksa jika ada data yang ditemukan
    if (mysqli_num_rows($result) > 0) {
        // Mendapatkan data pengguna
        $user = mysqli_fetch_assoc($result);

        // Memverifikasi password yang dimasukkan dengan yang ada di database (plaintext comparison)
        if ($password === $user['password']) {  // Perbandingan langsung tanpa hashing
            // Jika login sukses, set session
            $_SESSION['iduser'] = $user['iduser'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['status'] = 'online'; // Set status online

            // Update status user di database menjadi 'online'
            $updateStatusSql = "UPDATE users SET status = 'online' WHERE email = ?";
            $updateStmt = mysqli_prepare($conn, $updateStatusSql);
            mysqli_stmt_bind_param($updateStmt, "s", $email);
            mysqli_stmt_execute($updateStmt);

            // Menyimpan pesan sukses di session
            $_SESSION['success'] = "Login berhasil, selamat datang " . $user['username'] . "!";

            // Redirect ke halaman dashboard atau halaman utama
            header("Location: ../../../../index.php");
            exit;
        } else {
            // Jika password salah
            $_SESSION['error'] = "Password yang Anda masukkan salah.";
            header("Location: login.php");
            exit;
        }
    } else {
        // Jika email tidak ditemukan
        $_SESSION['error'] = "Email yang Anda masukkan tidak terdaftar.";
        header("Location: login.php");
        exit;
    }
}

// Fungsi untuk logout
function logout() {
    global $conn;

    // Memastikan user login
    if (isset($_SESSION['iduser'])) {
        $email = $_SESSION['email'];

        // Update status user menjadi 'offline' sebelum logout
        $updateStatusSql = "UPDATE users SET status = 'offline' WHERE email = ?";
        $updateStmt = mysqli_prepare($conn, $updateStatusSql);
        mysqli_stmt_bind_param($updateStmt, "s", $email);
        mysqli_stmt_execute($updateStmt);
    }

    // Menghapus session dan redirect ke login page
    session_destroy();
    header("Location: login.php");
    exit;
}

// Jika form login disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'login') {
        // Menangkap input form login
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // Panggil fungsi login
        login($email, $password);
    }
}

// Jika logout di-request
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    // Panggil fungsi logout
    logout();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Kadai Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<style>
        body {
            /* Setting background seperti yang diminta */
            background-color: white; /* Default background */
            background: linear-gradient(to right, #80808033 1px, transparent 1px), linear-gradient(to bottom, #80808033 1px, transparent 1px);
            background-size: 70px 70px; /* Ukuran kotak */
        }
    </style>

<body>
    <!-- Login Section -->
    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12">

        <!-- Form Login -->
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Login ke Akun Anda</h2>
            <form action="login.php" method="POST">
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
                <button type="submit" name="action" value="login" class="w-full py-2 px-4 bg-yellow-400 text-white font-semibold rounded-lg hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-600 transition-all duration-300">
                    Login
                </button>
            </form>
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">Belum punya akun? <a href="register.php" class="text-yellow-500 hover:underline">Daftar sekarang</a></p>
            </div>
                        <!-- Button to Go to Home -->
                        <div class="mt-4 text-center">
                <a href="../../index.php" class="w-full py-2 px-4 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all duration-300">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <!-- Modal Notification -->
    <?php if (isset($_SESSION['success'])): ?>
    <div id="modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
            <h3 class="text-green-600 font-semibold text-lg">Success</h3>
            <p class="text-gray-800"><?php echo $_SESSION['success']; ?></p>
            <?php unset($_SESSION['success']); ?>
        </div>
    </div>

    <script>
        setTimeout(function() {
            document.querySelector('#modal').classList.add('hidden');
            window.location.href = '../index.php';  // Redirect ke halaman dashboard
        }, 2000);
    </script>
    <?php elseif (isset($_SESSION['error'])): ?>
    <div id="modal-error" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
            <h3 class="text-red-600 font-semibold text-lg">Error</h3>
            <p class="text-gray-800"><?php echo $_SESSION['error']; ?></p>
            <?php unset($_SESSION['error']); ?>
        </div>
    </div>

    <script>
        setTimeout(function() {
            document.querySelector('#modal-error').classList.add('hidden');
        }, 2000);
    </script>
    <?php endif; ?>

</body>
</html>