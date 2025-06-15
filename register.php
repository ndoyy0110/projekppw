<?php
session_start();
include_once("config.php");

$error_message = "";
$success_message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Check if email already exists
        $sql_check_email = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql_check_email);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "This email is already registered.";
        } else {
            // Hash the password
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            // Insert the data into the users table
            $sql_insert = "INSERT INTO users (nama, email, password_hash) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bind_param("sss", $name, $email, $password_hash);

            if ($stmt->execute()) {
                $success_message = "Registration successful. You can now log in.";
            } else {
                $error_message = "An error occurred. Please try again.";
            }
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
    <title>Register - PROJEK PPW</title>
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
            .footer-custom a {
            text-decoration: none;
            font-size: 1.2rem;
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
            margin-bottom: 30px; /* Adjust the value to control the space */
            } 
            .login-container {
            margin-top: 30px; /* Adjust the value to control the space */
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

    <!-- Registration Form -->
    <div class="login-container">
        <h2 class="form-title">Register</h2>

        <!-- Show error or success messages -->
        <?php if (!empty($error_message)) { echo "<div class='error-message'>$error_message</div>"; } ?>
        <?php if (!empty($success_message)) { echo "<div class='success-message'>$success_message</div>"; } ?>

        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required />
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required />
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required />
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required />
            </div>

            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>

        <div class="form-footer">
            <p>Already have an account? <a href="login.php">Login here</a></p>
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
            <!-- Core theme JS-->
            <script src="js/scripts.js"></script>
    </body>
</html>
