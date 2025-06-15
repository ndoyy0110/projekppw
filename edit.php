<?php
include_once("config.php");

// Check if we have a product ID in the query string (e.g., edit.php?id_produk=1)
if (isset($_GET['id_produk'])) {
    $id_produk = $_GET['id_produk'];

    // Retrieve the current product details from the database
    $query = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = $id_produk");
    $product = mysqli_fetch_assoc($query);
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the form data
        $nama_produk = $_POST['nama_produk'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];
        $deskripsi = $_POST['deskripsi'];
        $gambar_url = $_FILES['gambar']['name'];

        // If a new image is uploaded
        if (!empty($gambar_url)) {
            move_uploaded_file($_FILES['gambar']['tmp_name'], "uploads/" . $gambar_url);

            // Update the database with the new image
            $sql = "UPDATE produk SET nama_produk='$nama_produk', harga='$harga', stok='$stok', deskripsi='$deskripsi', gambar_url='$gambar_url' WHERE id_produk = $id_produk";
        } else {
            // If no new image, update the database without changing the image
            $sql = "UPDATE produk SET nama_produk='$nama_produk', harga='$harga', stok='$stok', deskripsi='$deskripsi' WHERE id_produk = $id_produk";
        }

        // Execute the query and redirect if successful
        if (mysqli_query($conn, $sql)) {
            header("Location: admin.php");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Edit Produk</title>

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

    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container px-4 px-lg-5">
            <img src="logo_bulat.png" class="img-fluid rounded-circle" alt="atribut_yujiem" style="max-width: 60px;">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" href="index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="aboutus.html">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#!">All Products</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex">
                    <button class="btn btn-outline-dark" type="button" onclick="window.location.href='cart.html'">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill"></span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Form to Edit Produk -->
    <div class="container py-5">
        <h1 class="text-center mb-4">Edit Produk</h1>

        <form action="edit.php?id_produk=<?php echo $product['id_produk']; ?>" method="POST" enctype="multipart/form-data" class="bg-light p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="<?php echo $product['nama_produk']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="text" name="harga" id="harga" class="form-control" value="<?php echo $product['harga']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" name="stok" id="stok" class="form-control" value="<?php echo $product['stok']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required><?php echo $product['deskripsi']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar (Optional)</label>
                <input type="file" name="gambar" id="gambar" class="form-control">
                <small>Current Image: <img src="uploads/<?php echo $product['gambar_url']; ?>" alt="Gambar Produk" width="100"></small>
            </div>

            <button type="submit" name="submit" class="btn btn-primary w-100">Update Produk</button>
        </form>
    </div>

    <!-- Footer-->
    <footer id="contact" class="py-4 footer-custom text-white">
        <div class="container d-flex justify-content-between align-items-center">
            <p class="mb-0">&copy; 2025 atribut_yujiem. All rights reserved.</p>
            <div class="social-icons">
                <a href="#" class="text-white me-3"><i class="bi bi-whatsapp"></i></a>
                <a href="#" class="text-white me-3"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-white"><i class="bi bi-facebook"></i></a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
