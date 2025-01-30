<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['iduser'])) {
    header("Location: login.php");
    exit;
}

$iduser = $_SESSION['iduser'];

// Query to fetch orders
$query = "SELECT * FROM pesanan WHERE iduser = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}
$stmt->bind_param("i", $iduser);
$stmt->execute();
$result = $stmt->get_result();

// Handle delete request
if (isset($_GET['delete'])) {
    $idpesanan = $_GET['delete'];
    $deleteQuery = "DELETE FROM pesanan WHERE idpesanan = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $idpesanan);
    $deleteStmt->execute();
    header("Location: pesanan_saya.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <?php include('includes/header.php'); ?>
    <main class="p-6">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-bold text-center mb-6 text-gray-900">Pesanan Saya</h1>

            <!-- List of Orders -->
            <div class="space-y-6">
                <?php while ($pesanan = $result->fetch_assoc()): ?>
                    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-800">Pesanan #<?php echo $pesanan['idpesanan']; ?></h2>
                            <span class="px-4 py-2 text-sm font-medium text-white bg-yellow-500 rounded-full">
                                <?php echo ($pesanan['status_pesanan'] == 'Menunggu Pembayaran') ? 'Berhasil' : htmlspecialchars($pesanan['status_pesanan']); ?>
                            </span>
                        </div>

                        <div class="space-y-2">
                            <p><strong>Status:</strong> <?php echo ($pesanan['status_pesanan'] == 'Menunggu Pembayaran') ? 'Berhasil' : htmlspecialchars($pesanan['status_pesanan']); ?></p>
                            <p><strong>Total Bayar:</strong> Rp <?php echo number_format($pesanan['total_bayar'], 0, ',', '.'); ?></p>
                        </div>

                        <!-- Delete Button -->
                        <div class="mt-4">
                            <a href="?delete=<?php echo $pesanan['idpesanan']; ?>" 
                               class="text-red-600 hover:text-red-800 font-semibold">
                                Hapus Pesanan
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>

    <?php include('includes/footer.php'); ?>
</body>
</html>