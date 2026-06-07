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
    $id = mysqli_real_escape_string($koneksi, $_GET['hapus_id']);
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
            --primary-orange: #d1851b;
            --hover-orange: #E68A00;
            --light-orange: #FFF8F0; /* Putih dengan hint oranye */
            --header-orange: #FFE8D1; /* Oranye pastel untuk header tabel */
            --brown-dark: #4E342E; /* Cokelat gelap untuk teks */
            --brown-light: #8D6E63;
            --bg-main: #F7F5F2; /* Putih tulang/krem terang */
            --white: #FFFFFF;
            --danger: #D32F2F;
        }
        body { 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            background-color: var(--bg-main); 
            color: var(--brown-dark); 
            margin: 0; 
        }
        .admin-navbar { 
            background-color: var(--white); 
            border-bottom: 4px solid var(--primary-orange); 
            padding: 15px 20px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 2px 10px rgba(78, 52, 46, 0.1);
        }
        .navbar-brand { 
            font-weight: 700; 
            color: var(--primary-orange); 
            font-size: 1.5rem; 
        }
        .nav-links { 
            display: flex; 
            gap: 15px; 
            align-items: center; 
            font-weight: 600; 
            color: var(--brown-dark); 
        }
        .btn-nav { 
            padding: 8px 18px; 
            border-radius: 8px; 
            text-decoration: none; 
            font-weight: bold; 
            font-size: 0.9rem; 
            transition: 0.3s; 
        }
        .btn-back { 
            background-color: var(--light-orange); 
            color: var(--primary-orange); 
            border: 1px solid var(--primary-orange); 
        }
        .btn-back:hover { 
            background-color: var(--primary-orange); 
            color: var(--white); 
        }
        .btn-logout { 
            background-color: var(--danger); 
            color: white; 
        }
        .btn-logout:hover { background-color: #b71c1c; }
        .container { 
            max-width: 1200px; 
            margin: 20px auto; 
            padding: 20px; 
        }
        .dashboard-section { 
            background: var(--white); 
            border-radius: 12px; 
            padding: 30px; 
            margin-bottom: 30px; 
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); 
            border-top: 4px solid var(--primary-orange); 
        }
        h2 { 
            color: var(--brown-dark); 
            margin-top: 0; 
            border-bottom: 2px dashed #E0D4C8; 
            padding-bottom: 12px; 
        }
        .menu-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; 
        }
        .menu-table th { 
            background-color: var(--header-orange); 
            color: var(--brown-dark); 
            padding: 15px; 
            text-align: left; 
        }
        .menu-table td { 
            padding: 15px; 
            border-bottom: 1px solid #F0EAE3; 
            color: var(--brown-dark); 
        }
        .form-control { 
            padding: 12px; 
            width: 100%; 
            border: 1px solid #D7CCC8; 
            border-radius: 8px; 
            margin-bottom: 15px; 
            box-sizing: border-box; 
            color: var(--brown-dark); 
            background-color: #FAFAFA;
        }
        .form-control:focus { 
            outline: none; 
            border-color: var(--primary-orange); 
            box-shadow: 0 0 5px rgba(255, 149, 0, 0.3); 
            background-color: var(--white);
        }
        .btn-submit { 
            background-color: var(--primary-orange); 
            color: white; 
            padding: 12px 25px; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: bold; 
            transition: 0.3s; 
            width: 100%; 
            font-size: 1rem; 
        }
        .btn-submit:hover { 
            background-color: var(--hover-orange); 
        }
        .action-link { 
            text-decoration: none; 
            font-weight: bold; 
        }
    </style>
</head>
<body>

    <nav class="admin-navbar">
            <div class="navbar-brand">🍢 De'Sate Admin Panel</div>        
            <div class="nav-links">
            <span>Halo, Admin!</span>
            <a href="index.php" class="btn-nav btn-back">Kembali ke Website</a>
            <a href="logout.php" class="btn-nav btn-logout">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="dashboard-section">
            <h2>➕ Tambah Menu Baru</h2>
            <form method="POST" enctype="multipart/form-data">
                <div style="display: flex; gap: 15px;">
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
                    <tr>
                        <th style="border-top-left-radius: 8px;">No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th style="border-top-right-radius: 8px;">Aksi</th>
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
                        <td><img src="asset/img/<?php echo $row['gambar']; ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #D7CCC8;"></td>
                        <td><strong><?php echo $row['nama_menu']; ?></strong></td>
                        <td><?php echo $row['kategori']; ?></td>
                        <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td>
                            <a href="edit-menu.php?id=<?php echo $row['id']; ?>" class="action-link" style="color: var(--primary-orange);">Edit</a> | 
                            <a href="admin-dashboard.php?hapus_id=<?php echo $row['id']; ?>" class="action-link" style="color: var(--danger);" onclick="return confirm('Yakin hapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>