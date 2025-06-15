<?php
session_start();
include_once("config.php"); // Ensure this connects to the database properly

$error_message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check user credentials
    $sql = "SELECT * FROM users WHERE email = ?"; // Assuming 'email' is the email column
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password_hash'])) {
            // Set session variables
            $_SESSION['user_logged_in'] = true;
            $_SESSION['username'] = $user['nama'];
            $_SESSION['id_user'] = $user['id_user']; // Assuming 'id_user' is the primary key for users
            
            // Redirect to index.php after successful login
            header("Location: index.php");
            exit;
        } else {
            $error_message = "Invalid credentials";
        }
    } else {
        $error_message = "Invalid credentials";
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
    <title>PROJEK PPW - Login</title>
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

            .login-container {
                max-width: 400px;
                margin: 0 auto;
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

            .form-footer {
                text-align: center;
                margin-top: 20px;
            }

            .error-message {
                color: red;
                font-size: 0.9rem;
                text-align: center;
                margin-top: 10px;
            }

            .success-message {
                color: green;
                font-size: 0.9rem;
                text-align: center;
                margin-top: 10px;
            }

            .login-container {
                margin-bottom: 30px;
            } 

            .form-check-label {
                margin-left: 10px;
            }

            .login-form {
                display: none; /* Initially hidden until a role is selected */
            }

            .welcome-section {
                background: linear-gradient(rgba(255,255,255,0.9), rgba(255,255,255,0.9));
                margin-bottom: 2rem 0;
                margin-bottom: 1rem;
            }

            .display-4 {
                color: #198754;
                font-size: 2.5rem;
            }

            .lead {
                font-size: 1.1rem;
                max-width: 600px;
                margin: 0 auto;
            }

            .divider {
                height: 3px;
                width: 100px;
                background: #C6D53D;
                margin: 0 auto;
                margin-bottom: 1rem;
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


    <div class="welcome-section text-center py-5">
        <h1 class="display-4 fw-bold text-success mb-3">Selamat Datang di atribut_yujiem</h1>
        <p class="lead text-muted mb-4">Sumber terpercaya Anda untuk atribut Pionir UGM yang autentik</p>
        <div class="divider mb-5"></div>
    </div>
    <!-- Login Section -->
    <div class="login-container">
        <h2 class="form-title">Login</h2>

        <!-- Show error message if credentials are wrong -->
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Email</label>
                <input type="text" class="form-control" id="username" name="username" required />
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required />
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <div class="form-footer">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
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
