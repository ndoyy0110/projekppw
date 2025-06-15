<?php
session_start();
include_once("config.php");

$sql_bundle = "SELECT * FROM produk WHERE category = 'Bundle Pionir'";
$query_bundle = mysqli_query($conn, $sql_bundle);

$sql_atribut = "SELECT * FROM produk WHERE category = 'Atribut Pionir'";
$query_atribut = mysqli_query($conn, $sql_atribut);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>PROJEK PPW</title>
<style>
    @import url("https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css");
    @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css");
         .navbar-custom {
            background-color: #C6D53D;
            padding: 1rem 0;
        }

    .about-us-section {
        background-color: #f9f9f9;
        color: #333;
    }

    .about-us-section h5,
    .about-us-section h6 {
        color: #000;
        font-weight: bold;
    }

    .about-us-section ul {
        padding-left: 1.2rem;
    }

    .about-us-section ul li {
        margin-bottom: 0.5rem;
    }

    .about-us-section img {
        max-width: 100%;
    }
    .footer-custom {
        background-color: #C6D53D !important;
        color: #fff;
    }

    .footer-custom a {
        text-decoration: none;
        font-size: 1.2rem;
    }
    .about-us-section h5.title-with-line,
    .about-us-section h6.title-with-line {
        position: relative;
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
    }

    .about-us-section h5.title-with-line::after,
    .about-us-section h6.title-with-line::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 3px;
        background-color: grey; /* warna garis */
    }
</style>
    </head>
    <body>
 <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container px-4 px-lg-5">
        <img src="logo_bulat.png" class="img-fluid rounded-circle" alt="atribut_yujiem" style="max-width: 60px;">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="aboutus.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown">Shop</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php">All Products</a></li> <!-- Link ke index.php -->
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                    </ul>
                </li>
            </ul>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-dark" onclick="window.location.href='cart.php'">
                    <i class="bi-cart-fill me-1"></i>
                    Cart
                </button>
                <!-- Show Login/Logout buttons based on session -->
                <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
                    <button class="btn btn-outline-dark" onclick="window.location.href='logout.php'">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </button>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-dark">
                        <i class="bi-person-fill me-1"></i>Login
                    </a>
                <?php endif; ?>
                <!-- Show Admin button if admin is not logged in -->
                <button class="btn btn-outline-dark" onclick="window.location.href='adminlogin.php'">
                    <i class="bi-lock-fill me-1"></i>
                    Admin
                </button> 
            </div>
        </div>
    </div>
</nav>


        <section class="about-us-section py-5">
            <div class="container">
                <!-- Row 1: Gambar & Deskripsi -->
                <div class="row align-items-center mb-5">
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    <img src="logo_bulat.png" class="img-fluid rounded-circle" alt="atribut_yujiem" style="max-width: 200px;">
                    <h5 class="mt-3"></h5>
                </div>
                <div class="col-md-8">
                    <h5 class="title-with-line"><strong>Siapa Kami?</strong></h5>
                    <p>
                    Kami adalah platform digital yang menghubungkan penjual dan pembeli atribut pionir gadjah mada secara aman dan efisien. Sejak berdiri, kami berkomitmen untuk memberikan pengalaman jual beli atribut yang mudah, cepat, dan terpercaya bagi semua pengguna mahasiswa baru UGM.
                    </p>
                </div>
                </div>

                <!-- Row 2: Visi & Misi -->
                <div class="row mb-5">
                <div class="col-md-6">
                    <h6 class="title-with-line"><strong>Visi</strong></h6>
                    <ul>
                    <li>Menyediakan layanan pelanggan yang responsif dan profesional.</li>
                    <li>Platform mudah digunakan oleh penjual dan pembeli.</li>
                    <li>Keamanan transaksi melalui sistem verifikasi dan dukungan pelanggan.</li>
                    <li>Pengalaman jual beli yang aman, cepat, dan transparan.</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="title-with-line"><strong>Misi</strong></h6>
                    <p>
                    Menjadi platform digital terpercaya nomor 1 dalam kemudahan jual beli atribut pionir yang berkualitas.
                    </p>
                </div>
                </div>

                <!-- Row 3: Mengapa Kami -->
                <h5 class="text-center mb-4 title-with-line"><strong>Mengapa Kami?</strong></h5>
                <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <img src="assets/icons/icon1.png" style="height: 50px;" alt="Ikon 1">
                    <p class="mt-3">Berkomitmen penuh terhadap kepuasan pelanggan dan mutu vendor kami.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <img src="assets/icons/icon2.png" style="height: 50px;" alt="Ikon 2">
                    <p class="mt-3">Kami menjaga transparansi dan kejujuran dalam setiap transaksi.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <img src="assets/icons/icon3.png" style="height: 50px;" alt="Ikon 3">
                    <p class="mt-3">Ragam produk terbaik untuk setiap kebutuhan tersedia dalam satu tempat.</p>
                </div>
                </div>
            </div>
        </section>

    <!-- Footer-->
    <footer id="contact" class="py-4 footer-custom text-dark">
        <div class="container d-flex justify-content-between align-items-center">
            <p class="mb-0">&copy; 2025 atribut_yujiem. All rights reserved.</p>
            <div class="social-icons">
                <a href="#" class="text-dark me-3"><i class="bi bi-whatsapp"></i></a>
                <a href="#" class="text-dark me-3"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-dark"><i class="bi bi-facebook"></i></a>
            </div>
        </div>
    </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
