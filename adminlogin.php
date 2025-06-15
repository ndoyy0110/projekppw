<?php
session_start();
include_once("config.php");

// If the user is already logged in, redirect to the admin dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check username in the database
    $sql = "SELECT * FROM admin WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Verify the password using password_hash
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['username'] = $username;
            header("Location: admin.php");  // Redirect to the admin dashboard
            exit;
        } else {
            $error_message = "Invalid username or password.";
        }
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin Login</title>
    <style>
        @import url("https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css");
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css");

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

        .login-container {
            max-width: 400px;
            margin: 100px auto; /* Add margin to create space from navbar */
            padding: 40px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .error-message {
            color: red;
            font-size: 0.9rem;
            text-align: center;
            margin-top: 10px;
        }

        /* Space between form and footer */
        .footer-spacing {
            margin-top: 50px;
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


    <!-- Admin Login Form -->
    <div class="login-container">
        <h2 class="form-title">Admin Login</h2>

        <!-- Show error message if credentials are wrong -->
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Admin Login Form -->
        <form method="POST" action="adminlogin.php">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required />
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <!-- Footer-->
    <footer id="contact" class="py-4 footer-custom text-dark footer-spacing">
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
