<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_sate"; // Pastikan ini sama persis dengan nama database di phpMyAdmin kamu

$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek apakah koneksi berhasil
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>