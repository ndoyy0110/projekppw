<?php
session_start();
include_once("config.php");

// Ensure the user is logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: adminlogin.php");  // Redirect to admin login page
    exit;
}
?>

<?php
// Admin session is valid, proceed with pagination and product data

// Set the number of items per page
$batas = 10;

// Get current page number
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;

// Calculate the starting point for pagination
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// Check if the search term is set
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

// Modify the query to search by product name if a search term is provided
if (!empty($cari)) {
    $sql = "SELECT * FROM produk WHERE nama_produk LIKE '%$cari%' LIMIT $halaman_awal, $batas";
} else {
    // If no search term, show all products
    $sql = "SELECT * FROM produk LIMIT $halaman_awal, $batas";
}

// Query to get the total number of products (considering search if applicable)
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM produk WHERE nama_produk LIKE '%$cari%'");
$data = mysqli_fetch_assoc($result);
$jumlah_data = $data['total']; // Total number of products

// Calculate the total number of pages
$total_halaman = ceil($jumlah_data / $batas);

// Query to fetch products for the current page
$query = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Produk Atribut</title>
    <style>
        @import url("https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css");
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css");

        .navbar-custom {
            background-color: #C6D53D;
            padding: 1rem 0;
        }

        .footer-custom {
            background-color: #C6D53D !important;
            padding: 1.5rem 0;
        }

        .social-icons a {
            font-size: 1.5rem;
            transition: color 0.3s;
        }

        .social-icons a:hover {
            color: #4a4a4a !important;
        }

        .btn-outline-dark:hover {
            background-color: #4a4a4a;
            color: white;
        }

        .welcome-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .welcome-message {
            font-size: 1.2rem;
            color: green;
            text-align: center;
        }

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

<script>
    // Function to show confirmation popup
    function confirmLogout(event) {
        // Show a confirmation dialog
        var result = confirm("apakah anda yakin untuk logout dari dashboard ini?");
        if (!result) {
            // If the user cancels, prevent the default action (i.e., navigating)
            event.preventDefault();
        }
    }
</script>

<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container px-4 px-lg-5">
        <img src="logo_bulat.png" class="img-fluid rounded-circle" alt="atribut_yujiem" style="max-width: 60px;">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php" onclick="confirmLogout(event)">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="aboutus.html" onclick="confirmLogout(event)">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact" onclick="#contact">Contact</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!" onclick="confirmLogout(event)">All Products</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!" onclick="confirmLogout(event)">Popular Items</a></li>
                    </ul>
                </li>
            </ul>

            <div class="d-flex">
                <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                    <!-- Show Logout button if admin is logged in -->
                    <button class="btn btn-outline-dark d-flex align-items-center" onclick="window.location.href='logout.php'">
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Logout
                    </button>
                <?php else: ?>
                    <!-- Show Admin button if admin is not logged in -->
                    <button class="btn btn-outline-dark" onclick="window.location.href='adminlogin.php'">
                        <i class="bi-lock-fill me-1"></i>
                        Admin
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

    <!-- Data Produk Section-->
    <div class="container py-5">
        <!-- Welcome message container -->
        <div class="welcome-container">
            <h2>Selamat datang</h2>
            <p class="welcome-message">Haloo, <?php echo $_SESSION['username']; ?>! Kamu Login Sebagai Admin.</p>
        </div>
        <h1 class="text-center mb-4">Data Produk</h1>

        <div class="header-action mb-3 text-align-left">
            <a href="tambah.php" class="btn btn-primary">Tambah Produk</a>
        </div>

        <form action="admin.php" method="get" class="mb-4 text-align-left">
            <label>Cari :</label>
            <input type="text" name="cari" class="form-control d-inline-block w-auto" placeholder="Search for products" value="<?php echo htmlspecialchars($cari); ?>">
            <input type="submit" value="Cari" class="btn btn-secondary ms-2">
        </form>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Gambar</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = $halaman_awal + 1;
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $row['nama_produk'] . "</td>";
                    echo "<td>" . $row['harga'] . "</td>";
                    echo "<td>" . $row['stok'] . "</td>";
                    echo "<td><img src='uploads/" . $row['gambar_url'] . "' alt='Gambar Produk' width='100'></td>";
                    echo "<td>" . $row['deskripsi'] . "</td>";
                    echo "<td><a href='edit.php?id_produk=" . $row['id_produk'] . "' class='btn btn-warning btn-sm'>Edit</a> <a href='hapus.php?id_produk=" . $row['id_produk'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data?\")'>Hapus</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination justify-content-center">
            <?php
            for ($page = 1; $page <= $total_halaman; $page++) {
                echo "<a href='admin.php?halaman=$page&cari=" . urlencode($cari) . "' class='page-link" . ($halaman == $page ? ' active' : '') . "'>$page</a>";
            }
            ?>
        </div>
    </div>

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
</body>

</html>
