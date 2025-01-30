<?php
session_start();
include('includes/db.php'); // Koneksi ke database

if (!isset($_SESSION['iduser'])) {
    header("Location: login.php");
    exit;
}

$iduser = $_SESSION['iduser'];
$total_bayar = $_POST['total_bayar'];

$selected_items = $_POST['selected_items'] ?? [];
if (empty($selected_items)) {
    header("Location: cart.php");
    exit;
}

// Insert payment and order into the database (example query)
$query = "INSERT INTO orders (iduser, total_bayar, status) VALUES (?, ?, 'pending')";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $iduser, $total_bayar);
$stmt->execute();
$order_id = $stmt->insert_id;  // Get the inserted order ID
$stmt->close();

// Insert items into the order_items table
foreach ($selected_items as $cart_id) {
    $query = "SELECT produk.idproduk, cart.quantity FROM cart 
              JOIN produk ON cart.idproduk = produk.idproduk 
              WHERE cart.id = ? AND cart.iduser = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $cart_id, $iduser);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $query = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt2 = $conn->prepare($query);
        $stmt2->bind_param("iii", $order_id, $row['idproduk'], $row['quantity']);
        $stmt2->execute();
        $stmt2->close();
    }
    $stmt->close();
}

// Clear the cart after successful payment
$query = "DELETE FROM cart WHERE iduser = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $iduser);
$stmt->execute();
$stmt->close();

// Redirect to success page with order ID
header("Location: payment_success.php?order_id=" . $order_id);
exit;
?>