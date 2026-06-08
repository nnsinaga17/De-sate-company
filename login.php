<?php
session_start();

// Jika sudah login, langsung ke dashboard
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
        $_SESSION['login'] = true;
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
    <title>Login Admin</title>
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 400px;">
        <form method="POST" class="p-4 bg-white shadow rounded">
            <h3 class="text-center mb-4">Login Admin</h3>
            
            <?php if($error) : ?>
                <div class='alert alert-danger'>Username atau Password salah!</div>
            <?php endif; ?>
            
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>