<?php

$host     = "localhost";
$username = "dbsatenew";
$password = "7*5rQ92yy"; 
$database = "DB_DESATE"; 

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>