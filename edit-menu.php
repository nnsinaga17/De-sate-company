<?php
include 'koneksi.php';

// Ambil ID dari URL
$id = $_GET['id'];

// Ambil data menu yang mau diedit dari database
$query = mysqli_query($koneksi, "SELECT * FROM db_sate WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

// Proses Update Data
if(isset($_POST['update_menu'])) {
    $nama = $_POST['nama_menu'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];
    
    // Cek apakah admin mengupload foto baru
    if($_FILES['gambar']['name'] != "") {
        // Kalau upload foto baru
        $gambar = $_FILES['gambar']['name'];
        $tmp_file = $_FILES['gambar']['tmp_name'];
        $path = "asset/img/" . $gambar;
        
        move_uploaded_file($tmp_file, $path);
        
        // Update semua data termasuk nama file gambar baru
        mysqli_query($koneksi, "UPDATE db_sate SET nama_menu='$nama', kategori='$kategori', harga='$harga', deskripsi='$deskripsi', gambar='$gambar' WHERE id='$id'");
    } else {
        // Kalau foto TIDAK diganti (hanya ganti teks/harga)
        mysqli_query($koneksi, "UPDATE db_sate SET nama_menu='$nama', kategori='$kategori', harga='$harga', deskripsi='$deskripsi' WHERE id='$id'");
    }
    
    // Balik lagi ke dashboard
    header("Location: admin-dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - De'Sate</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f5f5; color: #212121; }
        .container { max-width: 800px; margin: 40px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { font-weight: bold; display: block; margin-bottom: 5px; color: #FF9500; }
        .form-control { width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ddd; box-sizing: border-box; }
        .btn-submit { background-color: #388e3c; color: white; padding: 10px 20px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; }
        .btn-cancel { background-color: #666; color: white; padding: 10px 20px; border: none; border-radius: 5px; font-weight: bold; text-decoration: none; display: inline-block; margin-left: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="color: #FF9500; border-bottom: 2px solid #FF9500; padding-bottom: 10px;">✏️ Edit Menu Sate</h2>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Menu</label>
                <input type="text" name="nama_menu" value="<?php echo $data['nama_menu']; ?>" required class="form-control">
            </div>
            
            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="harga" value="<?php echo $data['harga']; ?>" required class="form-control">
            </div>
            
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" required class="form-control">
                    <option value="sate" <?php if($data['kategori'] == 'sate') echo 'selected'; ?>>Sate</option>
                    <option value="Mie" <?php if($data['kategori'] == 'Mie') echo 'selected'; ?>>Mie</option>
                    <option value="Nasi" <?php if($data['kategori'] == 'Nasi') echo 'selected'; ?>>Nasi</option>
                    <option value="Minuman" <?php if($data['kategori'] == 'Minuman') echo 'selected'; ?>>Minuman</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Deskripsi Singkat</label>
                <textarea name="deskripsi" required class="form-control" rows="3"><?php echo $data['deskripsi']; ?></textarea>
            </div>

            <div class="form-group">
                <label>Foto Saat Ini:</label>
                <img src="asset/img/<?php echo $data['gambar']; ?>" style="width: 150px; border-radius: 8px; margin-bottom: 10px; display: block;">
                <label>Ganti Foto (Kosongkan jika tidak ingin ganti foto)</label>
                <input type="file" name="gambar" accept="image/*" class="form-control">
            </div>
            
            <div style="margin-top: 30px;">
                <button type="submit" name="update_menu" class="btn-submit">Simpan Perubahan</button>
                <a href="admin-dashboard.php" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>