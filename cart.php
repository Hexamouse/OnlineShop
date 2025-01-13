<?php
session_start();
include('includes/db.php'); // Menyambung ke database

// Cek apakah pengguna sudah login
if (!isset($_SESSION['iduser'])) {
    $is_logged_in = false; // Tandai jika pengguna belum login
} else {
    $is_logged_in = true;
    $iduser = $_SESSION['iduser'];  // Ambil iduser dari session

    // Ambil data cart dan produk dari database
    $query = "SELECT cart.id, produk.nama, cart.quantity, produk.harga, produk.foto1 
              FROM cart
              JOIN produk ON cart.idproduk = produk.idproduk
              WHERE cart.iduser = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $iduser);
    $stmt->execute();
    $result = $stmt->get_result();

    // Hitung total harga cart
    $total = 0;
    $cart_items = [];
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
        $total += $row['quantity'] * $row['harga'];
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    
<?php include('includes/header.php'); ?>

    <main class="p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Keranjang Kamu</h1>
        
        <?php if (!$is_logged_in): ?>
            <!-- Modal for not logged in -->
            <div id="loginModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div class="bg-white p-8 rounded-lg max-w-sm w-full">
                    <button id="closeModal" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">&times;</button>
                    <h2 class="text-xl font-semibold text-center mb-4">Kamu belum Login!</h2>
                    <p class="text-center text-sm mb-4">Login dulu cuy!</p>
                    <div class="flex justify-center">
                        <a href="buyer/auth/login.php" class="px-6 py-2 bg-yellow-400 text-gray-800 font-bold rounded hover:bg-yellow-500">Login</a>
                    </div>
                </div>
            </div>

            <script>
                // Show modal if not logged in
                window.onload = function() {
                    document.getElementById('loginModal').style.display = "flex";
                }

                // Close modal when the close button is clicked
                document.getElementById('closeModal').onclick = function() {
                    document.getElementById('loginModal').style.display = "none";
                }

                // Redirect to login.php if the user clicks on the login button in modal
                document.querySelector('.bg-yellow-400').onclick = function() {
                    window.location.href = "login.php";
                }
            </script>
        <?php else: ?>
            <?php if (empty($cart_items)): ?>
                <p class="text-center text-lg">Your cart is empty. <a href="index.php" class="text-blue-500 hover:text-blue-700">Go shopping</a>.</p>
            <?php else: ?>
                <table class="min-w-full table-auto text-center border-collapse">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-sm font-semibold text-gray-800">Product</th>
                            <th class="px-4 py-2 text-sm font-semibold text-gray-800">Quantity</th>
                            <th class="px-4 py-2 text-sm font-semibold text-gray-800">Price</th>
                            <th class="px-4 py-2 text-sm font-semibold text-gray-800">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                            <tr class="border-b">
                                <td class="px-4 py-2">
                                    <img src="images/<?php echo htmlspecialchars($item['foto1']); ?>" alt="<?php echo htmlspecialchars($item['nama']); ?>" class="max-w-[50px] inline-block">
                                    <span class="ml-2"><?php echo htmlspecialchars($item['nama']); ?></span>
                                </td>
                                <td class="px-4 py-2"><?php echo $item['quantity']; ?></td>
                                <td class="px-4 py-2"><?php echo '$' . number_format($item['harga'], 2); ?></td>
                                <td class="px-4 py-2"><?php echo '$' . number_format($item['quantity'] * $item['harga'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <h3 class="text-xl font-semibold text-right mt-6">Total: $<?php echo number_format($total, 2); ?></h3>
                <div class="flex justify-end mt-4">
                    <a href="checkout.php" class="px-6 py-2 bg-yellow-400 text-gray-800 font-bold rounded hover:bg-yellow-500">Proceed to Checkout</a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <?php include('includes/footer.php'); ?>
</body>
</html>
