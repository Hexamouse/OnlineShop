<?php
$host = "localhost";
$user = "root"; // ganti dengan username DB Anda
$pass = ""; // ganti dengan password DB Anda
$dbname = "db_onlineshop"; // ganti dengan nama database Anda

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>