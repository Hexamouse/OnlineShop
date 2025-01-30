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

$cart_items = [];
$total_harga = 0;

foreach ($selected_items as $cart_id) {
    $query = "SELECT produk.nama, cart.quantity, produk.harga, produk.foto1 
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

$biaya_pengiriman = 10000; // Ongkir tetap
$biaya_admin = 2000; // Biaya admin tetap
$total_bayar = $total_harga + $biaya_pengiriman + $biaya_admin;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<?php include('includes/header.php'); ?>
<main class="p-6">
    <h1 class="text-3xl font-bold text-center mb-6">Checkout</h1>
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Detail Produk</h2>
        <ul>
    <?php foreach ($cart_items as $item): ?>
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

        <h2 class="text-xl font-semibold mt-6">Alamat Pengiriman</h2>
        <input type="text" name="alamat" placeholder="Masukkan alamat lengkap" class="w-full p-2 border rounded mt-2" required>

        <h2 class="text-xl font-semibold mt-6">Kurir Pengiriman</h2>
        <select name="kurir" class="w-full p-2 border rounded mt-2" required>
            <?php
            $query = "SELECT idjasa, nama, tarif FROM jasakirim";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()):
            ?>
                <option value="<?php echo $row['idjasa']; ?>">
                    <?php echo htmlspecialchars($row['nama']); ?> - Rp <?php echo number_format($row['tarif'], 0, ',', '.'); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <h2 class="text-xl font-semibold mt-6">Metode Pembayaran</h2>
        <select name="metode_pembayaran" class="w-full p-2 border rounded mt-2" required>
            <option value="COD">Cash On Delivery (COD)</option>
            <option value="Bank Transfer">Bank Transfer</option>
            <option value="E-Wallet">E-Wallet (OVO, GoPay, dll)</option>
        </select>

        <div class="mt-6">
            <h2 class="text-xl font-semibold">Ringkasan Pembayaran</h2>
            <ul class="mt-2">
                <li class="flex justify-between py-1"><span>Subtotal:</span><span>Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></span></li>
                <li class="flex justify-between py-1"><span>Biaya Pengiriman:</span><span>Rp <?php echo number_format($biaya_pengiriman, 0, ',', '.'); ?></span></li>
                <li class="flex justify-between py-1"><span>Biaya Admin:</span><span>Rp <?php echo number_format($biaya_admin, 0, ',', '.'); ?></span></li>
                <li class="flex justify-between font-bold py-2 text-lg"><span>Total Bayar:</span><span>Rp <?php echo number_format($total_bayar, 0, ',', '.'); ?></span></li>
            </ul>
        </div>

        <form action="checkout_proses.php" method="post" class="mt-6">
            <input type="hidden" name="total_bayar" value="<?php echo $total_bayar; ?>">
            <input type="hidden" name="selected_items" value="<?php echo implode(',', $selected_items); ?>">
            <button type="submit" class="w-full px-6 py-2 bg-yellow-400 text-gray-800 font-bold rounded hover:bg-yellow-500">Selesaikan Pesanan</button>
        </form>
    </div>
</main>
<?php include('includes/footer.php'); ?>
</body>
</html>