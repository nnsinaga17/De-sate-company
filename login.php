<?php
session_start();
if(isset($_SESSION['login'])) {
    header("Location: admin-dashboard.php");
    exit;
}
include 'koneksi.php';
$error = false;

if(isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
    
    if(mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['login'] = true;
        $_SESSION['admin_id'] = $data['admin_id'];
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary-color: #b07e37; --dark-color: #4a3623; }
        body { background-color: #fff6eb; font-family: 'Poppins', sans-serif; }
        .login-card { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(176,126,55,0.2); }
        .btn-custom { background-color: var(--primary-color); color: white; border: none; transition: 0.3s; }
        .btn-custom:hover { background-color: var(--dark-color); color: white; }
        .logo-icon { font-size: 3rem; color: var(--primary-color); margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card login-card p-5" style="max-width: 400px; width: 100%;">
            <div class="text-center">
                <div class="logo-icon"><i class="fas fa-utensils"></i></div>
                <h3 class="fw-bold mb-4" style="color: var(--dark-color);">Login Admin</h3>
            </div>
            
            <?php if($error) : ?>
                <div class='alert alert-danger small'>Username/Password salah!</div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-4">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" name="login" class="btn btn-custom w-100 py-2 fw-bold">Masuk Dashboard</button>
            </form>
            
            <div class="text-center mt-4">
                <a href="index.php" class="text-decoration-none" style="color: var(--primary-color);">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Website
                </a>
            </div>
        </div>
    </div>
</body>
</html>