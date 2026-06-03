<?php
session_start();
// Cek Login
if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

// PROSES TAMBAH MENU
if(isset($_POST['tambah_menu'])) {
    $nama = $_POST['nama_menu'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];
    
    $gambar = $_FILES['gambar']['name'];
    $tmp_file = $_FILES['gambar']['tmp_name'];
    $path = "asset/img/" . $gambar;
    
    if(move_uploaded_file($tmp_file, $path)) {
        mysqli_query($koneksi, "INSERT INTO db_sate (nama_menu, kategori, harga, deskripsi, gambar) VALUES ('$nama', '$kategori', '$harga', '$deskripsi', '$gambar')");
        header("Location: admin-dashboard.php");
        exit;
    } else {
        echo "<script>alert('Gagal mengunggah gambar, coba periksa kembali foldernya.');</script>";
    }
}

// PROSES HAPUS MENU
if(isset($_GET['hapus_id'])) {
    $id = $_GET['hapus_id'];
    mysqli_query($koneksi, "DELETE FROM db_sate WHERE id='$id'");
    header("Location: admin-dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - De'Sate</title>
    <style>
        :root {
            --primary-color: #FF9500;
            --danger-color: #d32f2f;
            --success-color: #388e3c;
            --light-bg: #fff8f5;
        }
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f5f5f5; margin: 0; }
        .admin-navbar { background-color: white; border-bottom: 2px solid var(--primary-color); padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .navbar-brand { font-weight: 700; color: var(--primary-color); font-size: 1.5rem; }
        .nav-links { display: flex; gap: 15px; align-items: center; }
        .btn-nav { padding: 8px 15px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 0.9rem; }
        .btn-back { background-color: var(--primary-color); color: white; }
        .btn-logout { background-color: var(--danger-color); color: white; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; }
        .dashboard-section { background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .menu-table { width: 100%; border-collapse: collapse; }
        .menu-table th, .menu-table td { padding: 15px; border-bottom: 1px solid #eee; }
        .form-control { padding: 10px; width: 100%; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px; }
        .btn-submit { background-color: var(--success-color); color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>

    <nav class="admin-navbar">
        <div class="navbar-brand">🍗 De'Sate Admin Panel</div>
        <div class="nav-links">
            <span>Halo, Admin Nana!</span>
            <a href="index.php" class="btn-nav btn-back">Kembali ke Website</a>
            <a href="logout.php" class="btn-nav btn-logout">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="dashboard-section">
            <h2>➕ Tambah Menu Baru</h2>
            <form method="POST" enctype="multipart/form-data">
                <div style="display: flex; gap: 10px;">
                    <input type="text" name="nama_menu" placeholder="Nama Menu" required class="form-control">
                    <input type="number" name="harga" placeholder="Harga" required class="form-control">
                </div>
                <select name="kategori" required class="form-control">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Sate">Sate</option>
                    <option value="Mie">Mie</option>
                    <option value="Nasi">Nasi</option>
                    <option value="Minuman">Minuman</option>
                </select>
                <input type="file" name="gambar" required class="form-control">
                <input type="text" name="deskripsi" placeholder="Deskripsi Singkat" required class="form-control">
                <button type="submit" name="tambah_menu" class="btn-submit">Simpan Menu</button>
            </form>
        </div>

        <div class="dashboard-section">
            <h2>🍽️ Daftar Menu Saat Ini</h2>
            <table class="menu-table">
                <thead>
                    <tr><th>No</th><th>Foto</th><th>Nama</th><th>Kategori</th><th>Harga</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM db_sate ORDER BY id DESC");
                    while($row = mysqli_fetch_assoc($query)) {
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><img src="asset/img/<?php echo $row['gambar']; ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;"></td>
                        <td><strong><?php echo $row['nama_menu']; ?></strong></td>
                        <td><?php echo $row['kategori']; ?></td>
                        <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td>
                            <a href="edit-menu.php?id=<?php echo $row['id']; ?>" style="color: #2196F3;">Edit</a> | 
                            <a href="admin-dashboard.php?hapus_id=<?php echo $row['id']; ?>" style="color: red;" onclick="return confirm('Yakin hapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>