<?php
session_start();
include('../includes/db.php');  // Pastikan koneksi database benar

// Cek apakah admin sudah login dan waktu aktivitasnya
if (isset($_SESSION['admin_id'])) {
    // Cek apakah sesi sudah lebih dari 30 menit
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
        // Jika sudah lebih dari 30 menit, logout admin
        session_unset();
        session_destroy();
        header("Location: login.php"); // Redirect ke halaman login
        exit();
    }

    // Perbarui waktu terakhir aktivitas
    $_SESSION['last_activity'] = time();

    header("Location: index.php");  // Arahkan jika admin sudah login
    exit();
}

// Validasi login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi data login
    $query = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Set session
        $_SESSION['admin_id'] = $admin['idadmin'];
        $_SESSION['admin_name'] = $admin['namalengkap'];
        $_SESSION['last_activity'] = time(); // Set waktu terakhir aktivitas

        // Arahkan admin ke halaman index.php di folder admin
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Username atau password salah!";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            /* Setting background seperti yang diminta */
            background-color: white; /* Default background */
            background: linear-gradient(to right, #80808033 1px, transparent 1px), linear-gradient(to bottom, #80808033 1px, transparent 1px);
            background-size: 70px 70px; /* Ukuran kotak */
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-white dark:bg-secondaryBlack font-base">

    <div class="w-full max-w-sm bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login Admin</h2>

        <!-- Form login -->
        <form method="POST" action="login.php">
            <div class="mb-4">
                <label for="username" class="block text-sm font-semibold text-gray-700">Username</label>
                <input type="text" name="username" id="username" placeholder="Masukkan username" required
                       class="w-full mt-2 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan password" required
                       class="w-full mt-2 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="mb-4">
                <button type="submit" name="login" class="w-full py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Login</button>
            </div>

            <?php if (isset($error_message)) { ?>
                <div class="text-red-600 text-sm text-center mt-4"><?php echo $error_message; ?></div>
            <?php } ?>
        </form>
    </div>

</body>
</html>
