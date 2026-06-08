<?php 
// 1. Panggil file koneksi
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Menu - De'Sate</title>
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .card-menu { border-radius: 15px; margin-bottom: 20px; transition: 0.3s; height: 100%; border: none; }
        .card-menu:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important; }
        .card-menu img { height: 180px; object-fit: cover; border-top-left-radius: 15px; border-top-right-radius: 15px; cursor: pointer; }
        .price-text { color: #FF9500; font-weight: 700; font-size: 1.1rem; margin-bottom: 0; }
        .btn-cart-wa {
            background-color: #25D366;
            color: white;
            border-radius: 50px;
            padding: 4px 12px;
            font-size: 0.85rem;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-cart-wa:hover { background-color: #128C7E; color: white; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="text-center mb-5 fw-bold">Daftar Menu Kami</h2>
        <div class="row">
            <?php
            // Query JOIN ke tabel menu_item dan category
            $query_tampil = "SELECT menu_item.*, category.category_name 
                             FROM menu_item 
                             LEFT JOIN category ON menu_item.category_id = category.category_id 
                             ORDER BY menu_item.menu_id DESC";
            $query = mysqli_query($koneksi, $query_tampil);
            
            // Cek apakah data ada
            if(mysqli_num_rows($query) > 0) {
                while($row = mysqli_fetch_array($query)){
            ?>
            <div class="col-md-3 mb-4">
                <div class="card card-menu shadow-sm">
                    <img src="asset/img/<?php echo $row['image_url']; ?>" class="card-img-top zoom-target" alt="<?php echo $row['menu_name']; ?>">
                    <div class="card-body d-flex flex-column">
                        <small class="text-muted text-capitalize text-start d-block"><?php echo $row['category_name']; ?></small>
                        <h5 class="fw-bold mt-1 text-start"><?php echo $row['menu_name']; ?></h5>
                        <p class="text-muted small text-start flex-grow-1"><?php echo $row['description']; ?></p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <p class="price-text">Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></p>
                            <a href="https://wa.me/6281160601362?text=Halo,%20saya%20ingin%20pesan%20<?php echo urlencode($row['menu_name']); ?>" class="btn-cart-wa" target="_blank">
                                <i class="fas fa-shopping-cart me-1"></i> Beli
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                } 
            } else {
                echo "<p class='text-center'>Belum ada menu yang tersedia.</p>";
            }
            ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-outline-dark">Kembali ke Home</a>
        </div>
    </div>

    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 position-relative text-center">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-