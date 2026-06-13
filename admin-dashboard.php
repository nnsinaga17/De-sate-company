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
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_menu']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $kategori_id = mysqli_real_escape_string($koneksi, $_POST['kategori']); // Mengambil ID dari dropdown
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    
    $gambar = $_FILES['gambar']['name'];
    $tmp_file = $_FILES['gambar']['tmp_name'];
    $path = "asset/img/" . $gambar;
    
    // Default admin_id = 1 (Sona) jika session admin_id belum diset di halaman login
    $admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : 1; 
    
    if(move_uploaded_file($tmp_file, $path)) {
        $query_tambah = "INSERT INTO menu_item (admin_id, category_id, menu_name, description, price, image_url) 
                         VALUES ('$admin_id', '$kategori_id', '$nama', '$deskripsi', '$harga', '$gambar')";
        mysqli_query($koneksi, $query_tambah);
        
        header("Location: admin-dashboard.php");
        exit;
    } else {
        echo "<script>alert('Gagal mengunggah gambar, coba periksa kembali foldernya.');</script>";
    }
}

// PROSES HAPUS MENU
if(isset($_GET['hapus_id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['hapus_id']);
    mysqli_query($koneksi, "DELETE FROM menu_item WHERE menu_id='$id'");
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
            --light-orange: #FFF8F0; 
            --header-orange: #FFE8D1; 
            --brown-dark: #4E342E; 
            --brown-light: #8D6E63;
            --bg-main: #F7F5F2; 
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

        /* --- PERBAIKAN TAMPILAN HP (MOBILE) --- */
        @media (max-width: 768px) {
            .admin-navbar { 
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }
            .form-row-custom { 
                flex-direction: column !important;
                gap: 10px !important;
            }
            .form-row-custom input {
                width: 100% !important;
            }

            .dashboard-section {
                padding: 15px; 
            }

            .table-responsive-wrapper {
                width: 100%;
                overflow-x: auto; 
                -webkit-overflow-scrolling: touch; 
                display: block; 
                margin-top: 15px;
                border: 1px solid #E0D4C8;
                border-radius: 8px;
            }
            
            .menu-table {
                width: 100%;
                min-width: 800px; /* Lebar tabel minimum agar lega */
            }
            
            .menu-table th, .menu-table td {
                white-space: nowrap !important; /* Mencegah teks patah */
                padding: 12px;
            }
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
                <div class="form-row-custom" style="display: flex; gap: 15px;">
                    <input type="text" name="nama_menu" placeholder="Nama Menu" required class="form-control">
                    <input type="number" name="harga" placeholder="Harga" required class="form-control">
                </div>
                
                <select name="kategori" required class="form-control">
                    <option value="">-- Pilih Kategori --</option>
                    <?php
                    $query_kat = mysqli_query($koneksi, "SELECT * FROM category");
                    while($kat = mysqli_fetch_assoc($query_kat)) {
                        echo '<option value="'.$kat['category_id'].'">'.$kat['category_name'].'</option>';
                    }
                    ?>
                </select>
                
                <input type="file" name="gambar" required class="form-control">
                <input type="text" name="deskripsi" placeholder="Deskripsi Singkat" required class="form-control">
                <button type="submit" name="tambah_menu" class="btn-submit">Simpan Menu</button>
            </form>
        </div>

        <div class="dashboard-section">
            <h2>🍽️ Daftar Menu Saat Ini</h2>
            
            <div class="table-responsive-wrapper">
                <table class="menu-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Menu</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query_tampil = "SELECT menu_item.*, category.category_name 
                                         FROM menu_item 
                                         LEFT JOIN category ON menu_item.category_id = category.category_id 
                                         ORDER BY menu_item.menu_id DESC";
                        $query = mysqli_query($koneksi, $query_tampil);
                        
                        if(mysqli_num_rows($query) > 0) {
                            while($row = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><img src="asset/img/<?php echo $row['image_url']; ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #D7CCC8;"></td>
                            <td><strong><?php echo $row['menu_name']; ?></strong></td>
                            <td><?php echo $row['category_name']; ?></td>
                            <td>Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                            <td>
                                <a href="edit-menu.php?id=<?php echo $row['menu_id']; ?>" class="action-link" style="color: var(--primary-orange);">Edit</a> | 
                                <a href="admin-dashboard.php?hapus_id=<?php echo $row['menu_id']; ?>" class="action-link" style="color: var(--danger);" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                        <?php 
                            } 
                        } else {
                            echo "<tr><td colspan='6' style='text-align:center;'>Belum ada menu yang ditambahkan.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>