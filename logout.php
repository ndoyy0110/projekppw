<?php
session_start();
session_unset(); // Menghapus semua session
session_destroy(); // Menghancurkan sesi

header("Location: index.php"); // Mengarahkan kembali ke halaman index
exit();
