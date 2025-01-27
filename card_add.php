<?php
session_start();
include('includes/db.php'); // Database connection

// Cek apakah pengguna sudah login
if (!isset($_SESSION['iduser'])) {
    header('Location: login.php'); // Arahkan pengguna ke halaman login jika belum login
    exit();
}

$iduser = $_SESSION['iduser']; // Ambil iduser dari session

// Pastikan product_id dan quantity diterima dari form
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Validasi quantity
    if ($quantity < 1) {
        $quantity = 1; // Set default quantity jika kurang dari 1
    }

    // Query untuk mengecek apakah produk sudah ada di keranjang
    $query = "SELECT * FROM cart WHERE iduser = ? AND idproduk = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $iduser, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika produk sudah ada di keranjang, update quantity
    if ($result->num_rows > 0) {
        $cart_item = $result->fetch_assoc();
        $new_quantity = $cart_item['quantity'] + $quantity; // Tambahkan quantity

        // Update jumlah produk dalam keranjang
        $update_query = "UPDATE cart SET quantity = ? WHERE iduser = ? AND idproduk = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("iii", $new_quantity, $iduser, $product_id);
        $stmt->execute();
    } else {
        // Insert produk baru ke dalam keranjang
        $insert_query = "INSERT INTO cart (iduser, idproduk, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("iii", $iduser, $product_id, $quantity);
        $stmt->execute();
    }

    // Redirect ke halaman cart.php
    header('Location: cart.php');
    exit();
} else {
    echo "Produk tidak valid.";
    exit();
}