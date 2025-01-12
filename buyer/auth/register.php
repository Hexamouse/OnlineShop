<?php
// Menambahkan session untuk status pendaftaran
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_onlineshop";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Ambil data dari form
    $nama_lengkap = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Validasi input
    if (empty($nama_lengkap) || empty($email) || empty($password) || empty($password_confirm)) {
        $_SESSION['error'] = "Semua field wajib diisi!";
        header("Location: register.php");
        exit();
    }

    if ($password !== $password_confirm) {
        $_SESSION['error'] = "Password dan konfirmasi password tidak cocok!";
        header("Location: register.php");
        exit();
    }

    // Cek apakah email sudah terdaftar
    $sql_check_email = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql_check_email);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Email sudah terdaftar!";
        header("Location: register.php");
        exit();
    }

    // Menyimpan data pengguna baru
    $sql_insert = "INSERT INTO users (username, password, nama_lengkap, email, status, tgl_daftar) VALUES (?, ?, ?, ?, 'Aktif', NOW())";
    $stmt = $conn->prepare($sql_insert);
    $username = strtolower(str_replace(' ', '', $nama_lengkap)); // Menggunakan nama lengkap sebagai username
    $stmt->bind_param("ssss", $username, $password, $nama_lengkap, $email);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Register Sukses!";
        // Redirect ke halaman register untuk menampilkan modal
        header("Location: register.php");
        exit(); // Menghindari halaman ter-refresh lebih dari satu kali
    } else {
        $_SESSION['error'] = "Terjadi kesalahan. Coba lagi!";
        header("Location: register.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Kadai Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Register Section -->
    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Buat Akun Baru</h2>

            <form action="register.php" method="POST">
                <!-- Nama Lengkap Input -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" id="name" name="name" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400" placeholder="Nama Lengkap">
                </div>
                <!-- Email Input -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400" placeholder="Email Anda">
                </div>
                <!-- Password Input -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400" placeholder="Password Anda">
                </div>
                <!-- Konfirmasi Password -->
                <div class="mb-6">
                    <label for="password_confirm" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <input type="password" id="password_confirm" name="password_confirm" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400" placeholder="Konfirmasi Password Anda">
                </div>
                <!-- Submit Button -->
                <button type="submit" class="w-full py-2 px-4 bg-yellow-400 text-white font-semibold rounded-lg hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-600 transition-all duration-300">
                    Daftar
                </button>
            </form>
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">Sudah punya akun? <a href="login.php" class="text-yellow-500 hover:underline">Login sekarang</a></p>
            </div>

            <!-- Button to Go to Home -->
            <div class="mt-4 text-center">
                <a href="../../index.php" class="w-full py-2 px-4 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all duration-300">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <!-- Modal Error or Success -->
    <?php if (isset($_SESSION['error']) || isset($_SESSION['success'])): ?>
    <div class="fixed inset-0 flex justify-center items-center bg-gray-900 bg-opacity-50 z-50" id="modal">
        <div class="bg-white p-6 rounded-lg w-40">
            <h3 class="text-lg font-semibold text-center text-gray-800">
                <?php
                    if (isset($_SESSION['error'])) {
                        echo "<span class='text-red-500'>" . $_SESSION['error'] . "</span>";
                        unset($_SESSION['error']);
                    } elseif (isset($_SESSION['success'])) {
                        echo "<span class='text-green-500'>" . $_SESSION['success'] . "</span>";
                        unset($_SESSION['success']);
                    }
                ?>
            </h3>
            <div class="mt-4 flex justify-center">
                <button onclick="closeModal()" class="bg-yellow-400 text-white px-4 py-2 rounded-lg focus:outline-none hover:bg-yellow-500">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        // Menunggu 5 detik lalu mengalihkan halaman untuk notifikasi sukses
        setTimeout(function() {
            document.getElementById('modal').style.display = 'none';
            <?php if (isset($_SESSION['success'])): ?>
                window.location.href = 'login.php'; // Redirect setelah 5 detik untuk sukses
            <?php endif; ?>
        }, 5000);
    </script>

    <?php endif; ?>

    <script>
        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>

</body>
</html>