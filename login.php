<?php
session_start();

// Cek apakah sudah login, kalau iya langsung lempar ke dashboard
if(isset($_SESSION['login'])) {
    header("Location: admin-dashboard.php");
    exit;
}

include 'koneksi.php';

$error = false;

if(isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Pastikan nama tabel admin sesuai dengan yang ada di phpMyAdmin
    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
    
    if(mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query); // Ambil spesifik data admin yang login
        
        // Simpan sesi login dan ID Admin
        $_SESSION['login'] = true;
        $_SESSION['admin_id'] = $data['admin_id']; // Super penting untuk relasi tambah menu!
        $_SESSION['username'] = $data['username']; // Disimpan biar nanti bisa panggil nama di dashboard
        
        header("Location: admin-dashboard.php");
        exit;
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - De'Sate</title>
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #b07e37;
            --dark-color: #4a3623;
        }
        body {
            background-color: #fff6eb;
        }
        .btn-custom {
            background-color: var(--primary-color);
            color: white;
            border: none;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background-color: var(--dark-color);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5" style="max-width: 400px; padding-top: 50px;">
        <form method="POST" class="p-5 bg-white shadow-lg rounded-4 text-center">
            <h3 class="mb-4 fw-bold" style="color: var(--dark-color);">🍢 Login Admin</h3>
            
            <?php if($error) : ?>
                <div class='alert alert-danger small py-2'>Username atau Password salah!</div>
            <?php endif; ?>
            
            <div class="mb-3 text-start">
                <input type="text" name="username" class="form-control px-3 py-2" placeholder="Username" required>
            </div>
            <div class="mb-4 text-start">
                <input type="password" name="password" class="form-control px-3 py-2" placeholder="Password" required>
            </div>
            <button type="submit" name="login" class="btn btn-custom w-100 py-2 fw-bold rounded-3">Masuk Dashboard</button>
            
            <div class="mt-4">
                <a href="index.php" class="text-muted small text-decoration-none">Kembali ke Halaman Utama</a>
            </div>
        </form>
    </div>
</body>
</html>