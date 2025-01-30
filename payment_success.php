<?php
session_start();
include('includes/db.php'); // Koneksi ke database

if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit;
}

$order_id = $_GET['order_id'];
$iduser = $_SESSION['iduser'];

// Fetch the order details
$query = "SELECT * FROM orders WHERE iduser = ? AND id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $iduser, $order_id);
$stmt->execute();
$order_result = $stmt->get_result();
$order = $order_result->fetch_assoc();
$stmt->close();

// Fetch the order items
$order_items = [];
$query = "SELECT produk.nama, order_items.quantity, produk.harga, produk.foto1 
          FROM order_items 
          JOIN produk ON order_items.product_id = produk.idproduk
          WHERE order_items.order_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_items_result = $stmt->get_result();
while ($row = $order_items_result->fetch_assoc()) {
    $row['subtotal'] = $row['quantity'] * $row['harga'];
    $order_items[] = $row;
}
$stmt->close();

// Calculate the total order price
$total_order_price = 0;
foreach ($order_items as $item) {
    $total_order_price += $item['subtotal'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<?php include('includes/header.php'); ?>

<main class="p-6">
    <h1 class="text-3xl font-bold text-center mb-6">Pembayaran Berhasil</h1>

    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Detail Pembelian</h2>

        <h3 class="text-lg font-semibold">Order ID: <?php echo htmlspecialchars($order['id']); ?></h3>
        <p>Status: <?php echo htmlspecialchars($order['status']); ?></p>

        <h2 class="text-xl font-semibold mt-6">Detail Produk</h2>
        <ul>
            <?php foreach ($order_items as $item): ?>
                <li class="flex items-center border-b py-2">
                    <img src="uploads/<?php echo htmlspecialchars($item['foto1']); ?>" alt="<?php echo htmlspecialchars($item['nama']); ?>" class="w-16 h-16 object-cover rounded mr-4">
                    <div class="flex-1">
                        <span class="font-semibold"><?php echo htmlspecialchars($item['nama']); ?></span>
                        <p class="text-sm text-gray-500">Qty: <?php echo $item['quantity']; ?></p>
                    </div>
                    <span class="font-semibold">Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>

        <h2 class="text-xl font-semibold mt-6">Ringkasan Pembayaran</h2>
        <ul class="mt-2">
            <li class="flex justify-between py-1"><span>Total Pembayaran:</span><span>Rp <?php echo number_format($total_order_price, 0, ',', '.'); ?></span></li>
        </ul>

        <div class="mt-6">
            <a href="index.php" class="w-full px-6 py-2 bg-blue-500 text-white font-bold rounded hover:bg-blue-600">Kembali ke Beranda</a>
        </div>
    </div>
</main>

<?php include('includes/footer.php'); ?>

</body>
</html>