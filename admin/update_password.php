<?php
include('../includes/db.php');  // Pastikan koneksi database sudah benar

// Password yang ingin Anda ubah
$password = 'admin';  // Password lama (plain text)

// Hash password menggunakan PASSWORD_DEFAULT
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Query untuk memperbarui password
$query = "UPDATE admin SET password = ? WHERE username = 'admin'";  // Sesuaikan dengan username Anda
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $hashed_password);
$stmt->execute();

echo "Password berhasil diperbarui! Anda dapat login sekarang.";
?>