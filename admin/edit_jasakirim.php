<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil data berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM jasakirim WHERE idjasa = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
}

// Proses update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $tarif = $_POST['tarif'];
    $logo = $data['logo']; // Default tetap logo lama

    // Jika ada upload logo baru
    if (!empty($_FILES["logo"]["name"])) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["logo"]["name"]);
        move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);
        $logo = basename($_FILES["logo"]["name"]);
    }

    $stmt = $conn->prepare("UPDATE jasakirim SET nama = ?, logo = ?, tarif = ? WHERE idjasa = ?");
    $stmt->bind_param("ssii", $nama, $logo, $tarif, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php?updated=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jasa Kirim</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="max-w-lg w-full bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Edit Jasa Kirim</h1>

        <form action="" method="post" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block font-medium text-gray-700">Nama Jasa Kirim:</label>
                <input type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required class="w-full p-3 border rounded-lg focus:ring focus:ring-indigo-300">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Tarif (Rp):</label>
                <input type="number" name="tarif" value="<?php echo $data['tarif']; ?>" required class="w-full p-3 border rounded-lg focus:ring focus:ring-indigo-300">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Logo Lama:</label>
                <img src="../uploads/<?php echo $data['logo']; ?>" class="w-20 h-20 object-cover rounded-md mb-2">
                <label class="block font-medium text-gray-700">Ganti Logo (Opsional):</label>
                <input type="file" name="logo" class="w-full p-3 border rounded-lg focus:ring focus:ring-indigo-300">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                Simpan Perubahan
            </button>
        </form>
    </div>

</body>
</html>