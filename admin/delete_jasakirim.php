<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data logo untuk dihapus
    $stmt = $conn->prepare("SELECT logo FROM jasakirim WHERE idjasa = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($logo);
    $stmt->fetch();
    $stmt->close();

    // Hapus logo jika ada
    if ($logo && file_exists("../uploads/" . $logo)) {
        unlink("../uploads/" . $logo);
    }

    // Hapus data dari database
    $stmt = $conn->prepare("DELETE FROM jasakirim WHERE idjasa = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: admin_jasakirim.php?deleted=1");
    exit;
}
?>