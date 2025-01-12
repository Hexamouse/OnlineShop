<?php
session_start();
include('../includes/db.php');

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil data pengguna
$query = "SELECT * FROM users";
$result = $conn->query($query);
?>

<h2>Kelola Pengguna</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['iduser']; ?></td>
                <td><?php echo $row['nama_lengkap']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <a href="user_management.php?block_user=<?php echo $row['iduser']; ?>">Blokir</a>
                    <a href="user_management.php?unblock_user=<?php echo $row['iduser']; ?>">Buka Blokir</a>
                    <a href="user_management.php?delete_user=<?php echo $row['iduser']; ?>">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
// Blokir Pengguna
if (isset($_GET['block_user'])) {
    $iduser = $_GET['block_user'];
    $query = "UPDATE users SET status = 'blocked' WHERE iduser = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $iduser);
    $stmt->execute();
    header("Location: user_management.php");
}

// Buka blokir Pengguna
if (isset($_GET['unblock_user'])) {
    $iduser = $_GET['unblock_user'];
    $query = "UPDATE users SET status = 'active' WHERE iduser = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $iduser);
    $stmt->execute();
    header("Location: user_management.php");
}

// Hapus Pengguna
if (isset($_GET['delete_user'])) {
    $iduser = $_GET['delete_user'];
    $query = "DELETE FROM users WHERE iduser = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $iduser);
    $stmt->execute();
    header("Location: user_management.php");
}
?>