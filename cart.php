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

    // Menyimpan items cart
    $cart_items = [];
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
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
            <p class="text-center text-lg">Keranjang kamu kosong. <a href="index.php" class="text-blue-500 hover:text-blue-700">Ayo belanja</a>.</p>
        <?php else: ?>
            <form action="checkout.php" method="post" id="cart-form">
                <table class="min-w-full table-auto text-center border-collapse">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-sm font-semibold text-gray-800">Pilih</th>
                            <th class="px-4 py-2 text-sm font-semibold text-gray-800">Produk</th>
                            <th class="px-4 py-2 text-sm font-semibold text-gray-800">Kuantitas</th>
                            <th class="px-4 py-2 text-sm font-semibold text-gray-800">Harga</th>
                            <th class="px-4 py-2 text-sm font-semibold text-gray-800">Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                            <tr class="border-b">
                                <td class="py-2">
                                    <input type="checkbox" name="selected_items[]" value="<?php echo $item['id']; ?>" class="form-checkbox item-checkbox" data-price="<?php echo $item['quantity'] * $item['harga']; ?>" onchange="updateTotalPrice()">
                                </td>
                                <td class="px-4 py-2">
                                    <img src="uploads/<?php echo htmlspecialchars($item['foto1']); ?>" alt="<?php echo htmlspecialchars($item['nama']); ?>" class="max-w-[50px] inline-block">
                                    <span class="ml-2"><?php echo htmlspecialchars($item['nama']); ?></span>
                                </td>
                                <td class="px-4 py-2 flex items-center justify-center">
                                    <button type="button" class="px-2 py-1 bg-gray-200 rounded-l hover:bg-gray-300" onclick="updateQuantity(<?php echo $item['id']; ?>, 'decrease', <?php echo $item['harga']; ?>)">-</button>
                                    <input type="number" name="quantity[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>" class="w-12 text-center border border-gray-300 mx-2" readonly>
                                    <button type="button" class="px-2 py-1 bg-gray-200 rounded-r hover:bg-gray-300" onclick="updateQuantity(<?php echo $item['id']; ?>, 'increase', <?php echo $item['harga']; ?>)">+</button>
                                </td>
                                <td class="px-4 py-2"><?php echo 'Rp ' . number_format($item['harga'], 0, ',', '.'); ?></td>
                                <td class="px-4 py-2">
                                    <a href="delete_item.php?id=<?php echo $item['id']; ?>" class="text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Display the total price for selected items -->
                <div class="mt-4 text-right px-4">
                    <strong>Total: </strong>
                    <span class="text-xl font-extrabold text-yellow-500" id="total-price">Rp 0</span>
                    <button type="submit" class="px-6 py-2 bg-yellow-400 text-gray-800 font-bold rounded hover:bg-yellow-500">Proses Checkout</button>
                </div>
            </form>
        <?php endif; ?>
    <?php endif; ?>
</main>

<!-- Modal for Product Deleted -->
<?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'true'): ?>
    <div id="deleteSuccessModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-8 rounded-lg max-w-sm w-full">
            <button id="closeDeleteModal" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">&times;</button>
            <h2 class="text-xl font-semibold text-center mb-4">Produk Berhasil Dihapus!</h2>
            <p class="text-center text-sm mb-4">Produk telah dihapus dari keranjang kamu.</p>
            <div class="flex justify-center">
                <a href="cart.php" class="px-6 py-2 bg-yellow-400 text-gray-800 font-bold rounded hover:bg-yellow-500">Tutup</a>
            </div>
        </div>
    </div>

    <script>
        // Show the modal when a product is deleted
        window.onload = function() {
            document.getElementById('deleteSuccessModal').style.display = "flex";
        }

        // Close the modal
        document.getElementById('closeDeleteModal').onclick = function() {
            document.getElementById('deleteSuccessModal').style.display = "none";
        }
    </script>
<?php endif; ?>

<script>
function updateTotalPrice() {
    let totalPrice = 0;

    // Loop through all items
    document.querySelectorAll('.item-checkbox').forEach(function(checkbox) {
        if (checkbox.checked) {
            const itemId = checkbox.value;
            const itemPrice = parseInt(checkbox.getAttribute('data-price'));
            const quantity = parseInt(document.querySelector(`input[name="quantity[${itemId}]"]`).value);

            // Add the price * quantity to the total
            totalPrice += itemPrice * quantity;
        }
    });

    // Update the total price in the DOM
    document.getElementById('total-price').textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
}
</script>

<?php include('includes/footer.php'); ?>

</body>
</html>