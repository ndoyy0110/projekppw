<?php
session_start();
include_once("config.php");

// Jika tidak ada produk di dalam cart, redirect kembali ke halaman all.php
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    header("Location: all.php");
    exit();
}

// Menyimpan data pesanan jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart = $_SESSION['cart'];
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $fakultas = $_POST['fakultas'];
    $prodi = $_POST['prodi'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $paymentMethod = $_POST['paymentMethod'];
    
    // Menghitung total harga
    $totalHarga = 0;
    foreach ($cart as $item) {
        $totalHarga += $item['price'] * $item['quantity'];
    }

    // Menyimpan data transaksi ke dalam database
    $userId = $_SESSION['user_id']; // Menggunakan ID user yang login
    $status = 'menunggu'; // Status awal transaksi
    $query = "INSERT INTO transaksi (id_user, total_harga, status, alamat_pengiriman) 
              VALUES ('$userId', '$totalHarga', '$status', '$address')";
    if (mysqli_query($conn, $query)) {
        // Mengambil ID transaksi yang baru dimasukkan
        $transactionId = mysqli_insert_id($conn);
        
        // Menyimpan detail produk yang dibeli
        foreach ($cart as $item) {
            $productId = $item['id'];
            $quantity = $item['quantity'];
            $queryDetail = "INSERT INTO detail_transaksi (id_transaksi, id_produk, quantity) 
                            VALUES ('$transactionId', '$productId', '$quantity')";
            mysqli_query($conn, $queryDetail);
        }
        
        // Setelah transaksi berhasil, menghapus cart dan mengarahkan ke halaman konfirmasi
        unset($_SESSION['cart']);
        header("Location: confirmation.php?transaction_id=$transactionId");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
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
    <title>Cart - Produk Atribut</title>
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
                </ul>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-dark" onclick="window.location.href='cart.php'">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Cart Display-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="mb-4 text-center">Items in Cart:</h2>
            <div id="cartItems">
                <?php
                // Menampilkan produk dalam cart
                $cart = $_SESSION['cart'];
                $total = 0;
                foreach ($cart as $item) {
                    echo "<div class='cart-item'>
                            {$item['name']} x {$item['quantity']} - Rp " . number_format($item['price'], 0, ',', '.') . "
                          </div>";
                    $total += $item['price'] * $item['quantity'];
                }
                ?>
            </div>
            <div id="cartTotal" class="cart-total">
                Total: Rp <?php echo number_format($total, 0, ',', '.'); ?>
            </div>
            
            <h2 class="mb-4 text-center">Formulir Pembelian</h2>
            <form id="purchaseForm" action="cart.php" method="POST">
                <!-- Personal Information Section -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="fullName" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" required />
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required />
                    </div>
                </div>
                <!-- fakultas -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="fakultas" class="form-label">Fakultas</label>
                        <input type="text" class="form-control" id="fakultas" name="fakultas" required />
                    </div>
                    <div class="col-md-6">
                        <label for="prodi" class="form-label">Prodi</label>
                        <input type="text" class="form-control" id="prodi" name="prodi" required />
                    </div>
                </div>

                <!-- Address Section -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required />
                    </div>
                    <div class="col-md-6">
                        <label for="address" class="form-label">Alamat Pengiriman</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                </div>

                <!-- Payment Section -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="paymentMethod" class="form-label">Metode Pembayaran</label>
                        <select class="form-control" id="paymentMethod" name="paymentMethod" required>
                            <option value="QRIS">QRIS</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Pesanan</button>
            </form>
        </div>
    </section>

    <!-- Footer-->
    <footer id="contact" class="py-4 footer-custom text-dark">
        <div class="container d-flex justify-content-between align-items-center">
            <p class="mb-0">&copy; 2025 atribut_yujiem. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
