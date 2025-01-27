<?php
session_start();
include('includes/db.php');

// Cek apakah pengguna sudah login
if (!isset($_SESSION['iduser'])) {
    header("Location: login.php");  // Jika belum login, redirect ke halaman login
    exit();
}

$iduser = $_SESSION['iduser'];  // Ambil iduser dari session
$item_id = $_GET['id'];  // Ambil id produk yang akan dihapus

// Query untuk menghapus item dari cart berdasarkan idproduk dan iduser
$query = "DELETE FROM cart WHERE id = ? AND iduser = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $item_id, $iduser);
$stmt->execute();

// Jika penghapusan berhasil, redirect ke halaman keranjang dengan pesan sukses
if ($stmt->affected_rows > 0) {
    header("Location: cart.php?deleted=true");  // Redirect ke halaman keranjang dengan parameter deleted=true
} else {
    echo "Gagal menghapus item.";
}

$stmt->close();
?>