<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$query = "SELECT * FROM jasakirim";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jasa Kirim</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-lg p-6">
        
        <!-- Tombol Kembali ke Dashboard -->
        <div class="flex justify-between items-center mb-4">
            <a href="index.php" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                ← Kembali ke Dashboard
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Daftar Jasa Kirim</h1>
            <a href="add_jasakirim.php" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                + Tambah Jasa Kirim
            </a>
        </div>

        <div class="mt-6 overflow-hidden rounded-lg shadow-lg">
            <table class="w-full bg-white border border-gray-200">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">Logo</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Tarif</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-4 py-3">
                                <img src="../uploads/<?php echo $row['logo']; ?>" alt="<?php echo htmlspecialchars($row['nama']); ?>" class="w-16 h-16 object-cover rounded-md">
                            </td>
                            <td class="px-4 py-3 text-gray-800 font-medium"><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td class="px-4 py-3 text-gray-600">Rp <?php echo number_format($row['tarif'], 0, ',', '.'); ?></td>
                            <td class="px-4 py-3 text-center">
                                <a href="edit_jasakirim.php?id=<?php echo $row['idjasa']; ?>" class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition">
                                    Edit
                                </a>
                                <a href="delete_jasakirim.php?id=<?php echo $row['idjasa']; ?>" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition ml-2" onclick="return confirm('Apakah Anda yakin ingin menghapus jasa kirim ini?');">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>