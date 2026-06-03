<?php
session_start();
// Cek Login (Satpam)
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
        echo "<script>alert('Gagal mengunggah gambar, coba periksa kembali foldernya ya.');</script>";
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
            --secondary-color: #FFD700;
            --dark-color: #212121;
            --light-bg: #fff8f5;
            --danger-color: #d32f2f;
            --success-color: #388e3c;
        }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f5f5; color: var(--dark-color); margin: 0; padding: 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .admin-navbar { background-color: white; border-bottom: 2px solid var(--primary-color); box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); }
        .nav-container { display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; max-width: 1200px; margin: 0 auto; }
        .navbar-brand { font-weight: 700; color: var(--primary-color); font-size: 1.5rem; }
        .dashboard-section { background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .menu-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .menu-table th { padding: 15px; text-align: left; font-weight: 600; color: var(--primary-color); border-bottom: 2px solid var(--primary-color); }
        .menu-table td { padding: 15px; border-bottom: 1px solid #e0e0e0; vertical-align: middle; }
        .btn-delete { background-color: var(--danger-color); color: white; padding: 6px 12px; border: none; border-radius: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; }
        .form-group { display: flex; gap: 15px; margin-bottom: 15px; }
        .form-control { padding: 10px; width: 100%; border-radius: 5px; border: 1px solid #ddd; font-family: inherit; }
        .btn-submit { background-color: var(--success-color); color: white; padding: 12px 25px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; font-family: inherit; }
    </style>
</head>
<body>
    <nav class="admin-navbar">
        <div class="nav-container">
            <div class="navbar-brand">🍗 De'Sate Admin Panel</div>
            <div>
                <span style="font-weight: bold; margin-right: 15px;">Halo, Admin Nana!</span>
                <a href="logout.php" style="color: var(--danger-color); text-decoration: none; font-weight: bold;">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="dashboard-section">
            <h2 style="font-size: 1.5rem; margin-top: 0; margin-bottom: 20px; border-bottom: 2px solid var(--primary-color); padding-bottom: 10px;">➕ Tambah Menu Baru</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" name="nama_menu" placeholder="Nama Menu" required class="form-control">
                    <input type="number" name="harga" placeholder="Harga" required class="form-control">
                </div>
                <div class="form-group">
                    <select name="kategori" required class="form-control">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="sate">Sate</option>
                        <option value="Mie">Mie</option>
                        <option value="Nasi">Nasi</option>
                        <option value="Minuman">Minuman</option>
                    </select>
                    <input type="file" name="gambar" accept="image/*" required class="form-control" style="background: #fafafa;">
                </div>
                <div style="margin-bottom: 15px;">
                    <input type="text" name="deskripsi" placeholder="Deskripsi Singkat" required class="form-control">
                </div>
                <button type="submit" name="tambah_menu" class="btn-submit">Simpan Menu</button>
            </form>
        </div>

        <div class="dashboard-section">
            <h2 style="font-size: 1.5rem; margin-top: 0; margin-bottom: 20px; border-bottom: 2px solid var(--primary-color); padding-bottom: 10px;">🍽️ Daftar Menu Saat Ini</h2>
            <div style="overflow-x: auto;">
                <table class="menu-table">
                    <thead>
                        <tr>
                            <th>No</th><th>Foto</th><th>Nama Menu</th><th>Kategori</th><th>Harga</th><th>Aksi</th>
                        </tr>
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
                            <td>
                                <strong><?php echo $row['nama_menu']; ?></strong><br>
                                <small style="color: #666;"><?php echo $row['deskripsi']; ?></small>
                            </td>
                            <td><span style="background: var(--light-bg); color: var(--primary-color); padding: 5px 10px; border-radius: 15px; font-weight: bold;"><?php echo $row['kategori']; ?></span></td>
                            <td><strong>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></strong></td>
                            <td>
                                <div style="display: flex; gap: 8px; align-items: center;">
                                    <a href="edit-menu.php?id=<?php echo $row['id']; ?>" style="background-color: #2196F3; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; font-weight: bold;">Edit</a>
                                    
                                    <a href="admin-dashboard.php?hapus_id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>