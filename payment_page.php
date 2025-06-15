<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Pembayaran - QRIS</title>
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

    <!-- Bagian Pembayaran-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="mb-4 text-center">Pembayaran via QRIS</h2>

            <!-- Ringkasan Pesanan-->
            <div class="row mb-5">
                <div class="col-md-6">
                    <h5 class="title-with-line"><strong>Ringkasan Pesanan</strong></h5>
                    <ul id="orderSummary">
                        <!-- Detail pesanan akan dimasukkan di sini -->
                    </ul>
                </div>
                <div class="col-md-6">
                    <h5 class="title-with-line"><strong>Detail Pembayaran QRIS</strong></h5>
                    <p>Pindai kode QR di bawah ini menggunakan aplikasi GoPay atau dompet digital lainnya untuk melakukan pembayaran.</p>
                    <p><strong>Total Pembayaran:</strong> <span id="paymentAmount"></span></p>

                    <!-- Placeholder untuk kode QRIS (akan diganti dengan kode QRIS yang sebenarnya) -->
                    <div class="text-center">
                        <img id="qrisImage" src="https://via.placeholder.com/300x300.png?text=QRIS+Pembayaran" alt="QRIS Payment QR Code" />
                    </div>

                    <p class="text-center mt-4">Setelah pembayaran selesai, silakan konfirmasi pembayaran Anda.</p>
                </div>
            </div>

            <!-- Konfirmasi Pembayaran-->
            <div class="row">
                <div class="col-md-12 text-center">
                    <button class="btn btn-primary" onclick="confirmPayment()">Konfirmasi Pembayaran</button>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Mengambil detail pesanan dari local storage
        window.onload = function() {
            const orderDetails = JSON.parse(localStorage.getItem('orderDetails'));
            if (orderDetails) {
                // Menampilkan detail pesanan
                document.getElementById("paymentAmount").innerText = `Rp${orderDetails.totalPrice.toFixed(2)}`;
                
                const orderSummary = document.getElementById("orderSummary");
                orderSummary.innerHTML = `
                    <li><strong>Produk:</strong> ${orderDetails.productName}</li>
                    <li><strong>Jumlah:</strong> ${orderDetails.quantity}</li>
                    <li><strong>Total:</strong> Rp${orderDetails.totalPrice.toFixed(2)}</li>
                `;

                // Menghasilkan kode QRIS (contoh, ganti dengan API gateway pembayaran yang sebenarnya)
                generateQRISCode(orderDetails.totalPrice);
            }
        };

        function generateQRISCode(amount) {
            // Menghasilkan kode QRIS menggunakan API gateway seperti Midtrans (ganti dengan API yang sebenarnya)
            const qrisUrl = `https://via.placeholder.com/300x300.png?text=QRIS+Pembayaran+Rp${amount.toFixed(2)}`;
            document.getElementById('qrisImage').src = qrisUrl;
        }

        function confirmPayment() {
            // Simulasikan konfirmasi pembayaran
            alert("Terima kasih! Pembayaran Anda telah dikonfirmasi.");
        }
    </script>
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

</body>
</html>
