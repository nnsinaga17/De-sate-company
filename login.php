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
    <title>Login Admin - De'Sate</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background-color: #fff6eb; /* Warna cream soft */
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-card { 
            background: white;
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 10px 25px rgba(176, 126, 55, 0.15);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .icon-sate { font-size: 3rem; color: #d1851b; margin-bottom: 15px; }
        .btn-sate { 
            background-color: #d1851b; 
            border: none; 
            border-radius: 12px; 
            color: white; 
            padding: 12px;
            font-weight: 600;
        }
        .btn-sate:hover { background-color: #b07e37; }
        .back-link { color: #8D6E63; text-decoration: none; font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="icon-sate">🍢</div>
        <h3 class="fw-bold mb-4" style="color: #4E342E;">Login Admin</h3>
        
        <?php if($error) : ?>
            <div class='alert alert-danger py-2'>Username/Password salah!</div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3 text-start">
                <input type="text" name="username" class="form-control rounded-3" placeholder="Username" required>
            </div>
            <div class="mb-4 text-start">
                <input type="password" name="password" class="form-control rounded-3" placeholder="Password" required>
            </div>
            <button type="submit" name="login" class="btn btn-sate w-100">Masuk Dashboard</button>
        </form>
        
        <div class="mt-4">
            <a href="index.php" class="back-link">← Kembali ke Halaman Utama</a>
        </div>
    </div>
</body>
</html>