<?php
session_start();
include_once("config.php");

// Query untuk mengambil produk berdasarkan rating tertinggi hingga terendah
$sql_popular_items = "
    SELECT p.*, AVG(u.rating) AS avg_rating
    FROM produk p
    LEFT JOIN ulasan u ON p.id_produk = u.id_produk
    GROUP BY p.id_produk
    ORDER BY avg_rating DESC
";
$query_popular_items = mysqli_query($conn, $sql_popular_items);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Popular Items</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        @import url("https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css");
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css");

        .cart-item {
            margin-bottom: 10px;
            padding: 5px;
            border-bottom: 1px solid #ddd;
        }

        .cart-total {
            font-weight: bold;
        }

        .navbar-custom {
            background-color: #C6D53D;
            padding: 1rem 0;
        }

        .footer-custom {
            background-color: #C6D53D !important;
            color: #fff;
        }

        .footer-custom a {
            text-decoration: none;
            font-size: 1.2rem;
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
                        <li><a class="dropdown-item" href="all.php">All Products</a></li> <!-- Link ke all.php -->
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

    <!-- Popular Items Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="mb-4 text-center">Popular Items</h2>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php while ($row = mysqli_fetch_assoc($query_popular_items)) { ?>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <img class="card-img-top" src="uploads/<?php echo $row['gambar_url']; ?>" alt="<?php echo $row['nama_produk']; ?>" />
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <h5 class="fw-bolder"><?php echo $row['nama_produk']; ?></h5>
                                    <p>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                                    <p>Rating: <?php echo number_format($row['avg_rating'], 1); ?> / 5</p>
                                </div>
                            </div>
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <button class="btn btn-outline-dark mt-auto" onclick="addToCart('<?php echo $row['nama_produk']; ?>', <?php echo $row['harga']; ?>, <?php echo $row['id_produk']; ?>)">Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer id="contact" class="py-4 footer-custom text-dark">
        <div class="container d-flex justify-content-between align-items-center">
            <p class="mb-0">&copy; 2025 atribut_yujiem. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function addToCart(productName, price, productId) {
            // Fungsi untuk menambah produk ke cart (fungsi ini sama seperti di halaman lainnya)
            alert(productName + " added to cart!");
        }
    </script>
</body>

</html>
