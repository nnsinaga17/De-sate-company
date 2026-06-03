<?php
$host = "localhost";
$user = "dbsate"; 
$pass = "g3@Cb426n"; 
$db   = "desate4575_"; 

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (mysqli_connect_errno()){
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>