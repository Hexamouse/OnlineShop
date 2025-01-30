<?php
session_start();
include('includes/db.php'); // Koneksi ke database

if (!isset($_SESSION['iduser'])) {
    header("Location: login.php");
    exit;
}

$iduser = $_SESSION['iduser'];
$selected_items = $_POST['selected_items'] ?? [];

if (empty($selected_items)) {
    header("Location: cart.php");
    exit;
}

// Ambil data dari form
$alamat = $_POST['alamat'];
$kurir = $_POST['kurir'];
$metode_pembayaran = $_POST['metode_pembayaran'];
$total_bayar = $_POST['total_bayar'];

// Ambil detail produk dari cart
$cart_items = [];
$total_harga = 0;
foreach ($selected_items as $cart_id) {
    $query = "SELECT produk.idproduk, produk.nama, cart.quantity, produk.harga 
              FROM cart 
              JOIN produk ON cart.idproduk = produk.idproduk 
              WHERE cart.id = ? AND cart.iduser = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $cart_id, $iduser);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $row['subtotal'] = $row['quantity'] * $row['harga'];
        $total_harga += $row['subtotal'];
        $cart_items[] = $row;
    }
    $stmt->close();
}

// Insert data pesanan ke tabel pesanan
$query = "INSERT INTO pesanan (iduser, total_bayar, alamat, kurir, metode_pembayaran, status_pesanan) 
          VALUES (?, ?, ?, ?, ?, 'Menunggu Pembayaran')";
$stmt = $conn->prepare($query);
$stmt->bind_param("idisi", $iduser, $total_bayar, $alamat, $kurir, $metode_pembayaran);
$stmt->execute();

// Ambil ID pesanan yang baru saja dibuat
$pesanan_id = $stmt->insert_id;

// Insert detail produk pesanan ke tabel pesanan_detail
foreach ($cart_items as $item) {
    $query_detail = "INSERT INTO pesanan_detail (idpesanan, idproduk, quantity, subtotal) 
                     VALUES (?, ?, ?, ?)";
    $stmt_detail = $conn->prepare($query_detail);
    $stmt_detail->bind_param("iiid", $pesanan_id, $item['idproduk'], $item['quantity'], $item['subtotal']);
    $stmt_detail->execute();
}

// Clear cart setelah pesanan selesai
$query_clear_cart = "DELETE FROM cart WHERE iduser = ?";
$stmt_clear_cart = $conn->prepare($query_clear_cart);
$stmt_clear_cart->bind_param("i", $iduser);
$stmt_clear_cart->execute();

// Redirect ke halaman Pesanan Saya
header("Location: pesanan_saya.php");
exit;
?>