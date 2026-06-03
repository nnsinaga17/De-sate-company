<?php 
// 1. Panggil file koneksi di awal
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>De'Sate - Kuliner Tradisional Nusantara</title>
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #FF9500; 
            --secondary-color: #FFD700;
            --dark-color: #212121;
            --light-bg: #c5beba;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffffa6;
            color: var(--dark-color);
            scroll-behavior: smooth;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }
        .nav-link {
            font-weight: 500;
            color: var(--dark-color);
            transition: 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
        }

        /* Hero Section (Home) */
        .hero-section {
            background-color: var(--light-bg);
            padding: 100px 0;
            min-height: 80vh;
            display: flex;
            align-items: center;
        }
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
        }
        .hero-title span { color: var(--primary-color); }
        .btn-custom {
            background-color: var(--primary-color);
            color: white;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 600;
            transition: 0.3s;
            border: none;
            text-decoration: none;
            display: inline-block;
        }
        .btn-custom:hover {
            background-color: #E68500;
            color: white;
            transform: translateY(-2px);
        }

        /* Section Title */
        .section-title {
            font-weight: 700;
            position: relative;
            margin-bottom: 40px;
            padding-bottom: 15px;
        }
        .section-title::after {
            content: '';
            position: absolute;
            display: block;
            width: 60px;
            height: 3px;
            background: var(--primary-color);
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        /* About Section */
        .about-section { background-color: #ffffff; padding: 80px 0; }

        /* Favorite & Menu Section */
        .favorite-section, .menu-section, .contact-section { padding: 80px 0; }
        .bg-light-section { background-color: var(--light-bg); }
        
        /* Card Menu */
        .card-menu { 
            border-radius: 15px; 
            transition: 0.3s; 
            height: 100%; 
            border: none; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .card-menu:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important; 
        }
        .card-menu img { 
            height: 180px; 
            object-fit: cover; 
            border-top-left-radius: 15px; 
            border-top-right-radius: 15px; 
            cursor: pointer; 
        }
        
        .price-text { 
            color: var(--primary-color); 
            font-weight: 700; 
            font-size: 1.1rem; 
            margin-bottom: 0; 
        }
        .btn-cart-wa {
            background-color: #25D366;
            color: white;
            border-radius: 50px;
            padding: 6px 16px;
            font-size: 0.85rem;
            text-decoration: none;
            transition: 0.3s;
            border: none;
        }
        .btn-cart-wa:hover { background-color: #128C7E; color: white; }

        /* Tombol Keranjang Melayang (Floating Cart) */
        .floating-cart {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: var(--primary-color);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            z-index: 999;
            transition: 0.3s ease-in-out;
        }
        .floating-cart:hover {
            transform: scale(1.1);
            background-color: #E68500;
        }
        .floating-cart .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 0.75rem;
            padding: 5px 8px;
        }

        /* Maps Wrapper */
        .map-responsive {
            overflow: hidden;
            padding-bottom: 56.25%;
            position: relative;
            height: 0;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .map-responsive iframe {
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            position: absolute;
        }

        /* Footer */
        footer { 
            background-color: var(--dark-color); 
            color: #ffffff; 
            padding: 30px 0 15px 0; 
        }
        .social-icons a { 
            color: white; 
            font-size: 1.5rem; 
            margin: 0 10px; 
            transition: 0.3s; 
        }
        .social-icons a:hover { color: var(--secondary-color); }
    </style>
</head>
<body>

    <div class="floating-cart" onclick="openCartModal()">
        <i class="fas fa-shopping-cart"></i>
        <span id="cart-count" class="badge bg-danger rounded-pill">0</span>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#home"><i class="fas fa-utensils me-2"></i>De'Sate</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#favorite">Favorite</a></li>
                    <li class="nav-item"><a class="nav-link" href="#menu">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold text-success" href="javascript:void(0)" onclick="openCartModal()">
                            <i class="fas fa-shopping-basket me-1"></i> Cart (<span id="nav-cart-count">0</span>)
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0 text-start">
                    <h1 class="hero-title">Kelezatan Asli <span>Nusantara</span> Di Hidangan Anda</h1>
                    <p class="lead my-4">Kami menyajikan hidangan sate pilihan dengan bumbu kacang khas meresap, diolah dari resep turun-temurun yang terjamin kualitas rasanya.</p>
                    <a href="#menu" class="btn btn-custom">Eksplor Menu <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="asset/img/sate-opening2.jpg" alt="Sate Hero" class="img-fluid rounded-circle shadow zoom-target">
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-4 mb-lg-0">
                <img src="asset/img/pakde.jpeg" alt="Pemilik De'Sate" class="img-fluid rounded-3 shadow zoom-target">                </div>
                <div class="col-lg-7 ps-lg-5 text-start">
                    <h2 class="section-title text-start">Tentang De'Sate</h2>
                    <p>Berawal dari resep rahasia keluarga, De'Sate didirikan oleh sosok yang akrab disapa <strong>Pak De</strong>. Dimulai dari warung rumahan kecil, beliau berkomitmen untuk selalu menghadirkan hidangan sate legendaris yang tidak hanya higienis, nikmat, dan ramah di kantong, tetapi juga penuh kehangatan.</p>
<p>Bagi Pak De, setiap pelanggan adalah keluarga. Keramahan tulusnya menemani setiap tusuk sate yang dibakar dengan teknik khusus agar daging tetap empuk. Dipadukan dengan rempah murni nusantara tanpa pengawet buatan, Pak De siap menyajikan kebahagiaan sejati di setiap gigitan untuk Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="favorite" class="favorite-section bg-light-section">
        <div class="container">
            <h2 class="text-center section-title">Menu Terfavorit</h2>
            <div class="row g-4">
                <?php
                // Mengambil 3 menu teratas dari database
                // TIPS: Jika kamu punya kolom hitungan views, ganti 'harga DESC' menjadi 'views DESC' atau 'jumlah_dilihat DESC'
                $query_favorit = mysqli_query($koneksi, "SELECT * FROM db_sate ORDER BY harga DESC LIMIT 3");
                
                if(mysqli_num_rows($query_favorit) > 0) {
                    while($fav = mysqli_fetch_array($query_favorit)) {
                    ?>
                    <div class="col-md-4">
                        <div class="card card-menu shadow-sm">
                            <img src="asset/img/<?php echo $fav['gambar']; ?>" class="card-img-top zoom-target" alt="<?php echo $fav['nama_menu']; ?>">
                            <div class="card-body d-flex flex-column text-start">
                                <h5 class="fw-bold"><?php echo $fav['nama_menu']; ?></h5>
                                <p class="text-muted small flex-grow-1"><?php echo $fav['deskripsi']; ?></p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="price-text">Rp <?php echo number_format($fav['harga'], 0, ',', '.'); ?></span>
                                    <button onclick="addToCart('<?php echo addslashes($fav['nama_menu']); ?>', <?php echo $fav['harga']; ?>)" class="btn-cart-wa">
                                        <i class="fas fa-cart-plus me-1"></i> + Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                    }
                } else {
                    echo "<div class='col-12 text-center'><p class='text-muted small'>Belum ada menu favorit yang tersedia.</p></div>";
                }
                ?>
            </div>
        </div>
    </section>

    <section id="menu" class="menu-section">
    <div class="container">
        <h2 class="text-center section-title">Daftar Menu Kategori</h2>

        <?php
        // Mengambil semua kategori unik yang terdaftar di database secara otomatis
        $query_kategori = mysqli_query($koneksi, "SELECT DISTINCT kategori FROM db_sate");
        
        $index = 1;
        while($kat_row = mysqli_fetch_array($query_kategori)) {
            $kat = $kat_row['kategori'];
            
            echo '<div class="category-block mb-5">';
            echo '<h4 class="fw-bold text-capitalize text-start mb-4" style="color: var(--primary-color); border-left: 4px solid var(--primary-color); padding-left: 10px;">' . $index . '. Kategori ' . $kat . '</h4>';
            echo '<div class="row g-4">';
            
            // Mengambil semua menu sesuai kategori, diurutkan dari yang paling baru ditambahkan (tanpa limit)
            $query_menu = mysqli_query($koneksi, "SELECT * FROM db_sate WHERE kategori='$kat' ORDER BY id DESC");
            
            if(mysqli_num_rows($query_menu) > 0) {
                while($row = mysqli_fetch_array($query_menu)){
                ?>
                <div class="col-md-4">
                    <div class="card card-menu shadow-sm">
                        <img src="asset/img/<?php echo $row['gambar']; ?>" class="card-img-top zoom-target" alt="<?php echo $row['nama_menu']; ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column text-start">
                            <small class="text-muted text-capitalize d-block mb-1"><?php echo $row['kategori']; ?></small>
                            <h5 class="fw-bold"><?php echo $row['nama_menu']; ?></h5>
                            <p class="text-muted small flex-grow-1"><?php echo $row['deskripsi']; ?></p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <p class="price-text">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                                <button onclick="addToCart('<?php echo addslashes($row['nama_menu']); ?>', <?php echo $row['harga']; ?>)" class="btn-cart-wa">
                                    <i class="fas fa-cart-plus me-1"></i> + Keranjang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                } 
            } else {
                echo "<div class='col-12 text-start'><p class='text-muted ps-2 small'>Belum ada menu yang tersedia di kategori ini.</p></div>";
            }
            echo '</div></div>';
            $index++;
        }
        ?>
    </div>
</section>

    <section id="contact" class="contact-section bg-light-section">
        <div class="container">
            <h2 class="text-center section-title">Hubungi & Kunjungi Kami</h2>
            <div class="row g-4 justify-content-center text-start">
                
                <div class="col-md-6">
                    <div class="bg-white p-4 rounded shadow-sm mb-4">
                        <h5 class="fw-bold mb-3"><i class="fas fa-map-marker-alt text-danger me-2"></i>Alamat Toko</h5>
                        <p class="text-muted mb-1 fw-semibold">De'Sate Taman Kota Mas</p>
                        <p class="text-muted small">Perumahan Jl. Taman Kota Mas Blok BLV 2, Tj. Uma, Kec. Lubuk Baja, Kota Batam, Kepulauan Riau 29445</p>
                        <p class="text-muted small mb-0"><i class="fas fa-clock text-warning me-1"></i> Jam Operasional: 10.00 - 22.00 WIB</p>
                    </div>

                    <form id="contactForm" class="bg-white p-4 rounded shadow-sm">
                        <h5 class="fw-bold mb-3"><i class="fas fa-envelope text-primary me-2"></i>Kirim Kritik & Saran</h5>
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" placeholder="Masukkan nama kamu" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label fw-semibold">Pesan / Saran</label>
                            <textarea class="form-control" id="message" rows="3" placeholder="Tulis masukan di sini..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-custom w-100">Kirim Notifikasi</button>
                    </form>
                </div>

                <div class="col-md-6">
                    <div class="map-responsive">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.052857476686!2d104.0071373!3d1.1314488!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d98bc2399225c5%3A0x9d54e4ff81467554!2sTaman%20Kota%20Mas!5e0!3m2!1sid!2sid!4v1717364000000!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <footer>
        <div class="container text-center">
            <div class="social-icons mb-3">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-whatsapp"></i></a>
            </div>
            <p class="mb-0 text-muted small">© 2026 De'Sate Taman Kota Mas. All rights reserved.</p>
        </div>
    </footer>

    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 position-relative text-center">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <img src="" id="imgModalTarget" class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="fas fa-shopping-cart text-warning me-2"></i>Keranjang Belanja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    <div id="cart-items-container">
                        </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center fw-bold fs-5">
                        <span>Total Bayar:</span>
                        <span class="text-success" id="cart-total-price">Rp 0</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tambah Menu Lagi</button>
                    <button type="button" class="btn btn-success" onclick="checkoutToWhatsApp()"><i class="fab fa-whatsapp me-1"></i> Kirim Pesanan Ke WA</button>
                </div>
            </div>
        </div>
    </div>

    <script src="asset/js/bootstrap.bundle.js"></script>
    <script>
        // --- SISTEM KERANJANG BELANJA (LOCALSTORAGE) ---
        let cart = JSON.parse(localStorage.getItem('desate_cart')) || [];

        // Fungsi memperbarui UI jumlah badge keranjang & isi modal
        function updateCartUI() {
            const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
            document.getElementById('cart-count').innerText = totalItems;
            document.getElementById('nav-cart-count').innerText = totalItems;

            const container = document.getElementById('cart-items-container');
            if (cart.length === 0) {
                container.innerHTML = '<p class="text-muted text-center py-3">Keranjang belanjamu masih kosong nih.</p>';
                document.getElementById('cart-total-price').innerText = 'Rp 0';
                return;
            }

            let htmlContent = '';
            let grandTotal = 0;

            cart.forEach((item, index) => {
                let subtotal = item.harga * item.qty;
                grandTotal += subtotal;

                htmlContent += `
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <div>
                            <h6 class="fw-bold mb-0">${item.nama}</h6>
                            <small class="text-muted">Rp ${item.harga.toLocaleString('id-ID')} / porsi</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="changeQty(${index}, -1)">-</button>
                            <span class="mx-2 fw-bold">${item.qty}</span>
                            <button class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="changeQty(${index}, 1)">+</button>
                            <button class="btn btn-sm text-danger ms-3" onclick="deleteItem(${index})"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = htmlContent;
            document.getElementById('cart-total-price').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
        }

        // Fungsi Tambah ke Keranjang
        function addToCart(namaMenu, hargaMenu) {
            const foundIndex = cart.findIndex(item => item.nama === namaMenu);
            
            if (foundIndex > -1) {
                cart[foundIndex].qty += 1;
            } else {
                cart.push({ nama: namaMenu, harga: hargaMenu, qty: 1 });
            }

            localStorage.setItem('desate_cart', JSON.stringify(cart));
            updateCartUI();
            alert(`"${namaMenu}" berhasil ditambahkan ke keranjang!`);
        }

        // Fungsi Ubah Kuantitas (+/-)
        function changeQty(index, amount) {
            cart[index].qty += amount;
            if (cart[index].qty <= 0) {
                cart.splice(index, 1);
            }
            localStorage.setItem('desate_cart', JSON.stringify(cart));
            updateCartUI();
        }

        // Fungsi Hapus Item Tunggal
        function deleteItem(index) {
            cart.splice(index, 1);
            localStorage.setItem('desate_cart', JSON.stringify(cart));
            updateCartUI();
        }

        // Fungsi Buka Modal Keranjang
        function openCartModal() {
            updateCartUI();
            const modalCartElement = new bootstrap.Modal(document.getElementById('cartModal'));
            modalCartElement.show();
        }

        // Fungsi Rekap & Kirim Sekaligus ke WhatsApp
        function checkoutToWhatsApp() {
            if (cart.length === 0) {
                alert('Keranjang belanja kosong, yuk pilih sate dulu!');
                return;
            }

            let nomorWA = '6282392333601'; 
            let teksPesan = 'Halo De\'Sate, saya ingin memesan menu berikut:\n\n';
            let totalBayar = 0;

            cart.forEach((item, i) => {
                let sub = item.harga * item.qty;
                totalBayar += sub;
                teksPesan += `${i + 1}. *${item.nama}* (${item.qty}x)\n   ↳ Subtotal: Rp ${sub.toLocaleString('id-ID')}\n\n`;
            });

            teksPesan += `-------------------------------\n`;
            teksPesan += `*Total Grand Price: Rp ${totalBayar.toLocaleString('id-ID')}*\n\n`;
            teksPesan += `Mohon konfirmasi pesanannya ya min, terima kasih!`;

            // Proses encode teks pesan agar aman dibaca url WhatsApp API
            let urlAkhir = `https://wa.me/${nomorWA}?text=${encodeURIComponent(teksPesan)}`;
            
            // Kosongkan keranjang setelah checkout sukses
            cart = [];
            localStorage.removeItem('desate_cart');
            updateCartUI();

            // Redirect ke tab baru WhatsApp
            window.open(urlAkhir, '_blank');
        }

        // --- SISTEM MODAL ZOOM IMAGE ---
        const images = document.querySelectorAll('.zoom-target');
        const modalImg = document.getElementById('imgModalTarget');
        const instanceModal = new bootstrap.Modal(document.getElementById('previewModal'));

        images.forEach(img => {
            img.addEventListener('click', function() {
                modalImg.src = this.src;
                instanceModal.show();
            });
        });

        // Handler form kontak biasa
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert(`Terima kasih banyak ${document.getElementById('name').value}, pesan kamu berhasil terkirim!`);
            this.reset();
        });

        // Jalankan sinkronisasi keranjang saat halaman pertama kali dimuat
        document.addEventListener('DOMContentLoaded', () => {
            updateCartUI();
        });
    </script>
    <footer style="text-align: center; padding: 20px;">
    <a href="login.php" style="color: #f5f5f5; font-size: 10px; text-decoration: none; cursor: default;">© 2026 De'Sate</a>
</footer>
</body>
</html>