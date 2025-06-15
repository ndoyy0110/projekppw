<?php
include_once("config.php");

if (isset($_GET['id_produk'])) {
    $id_produk = $_GET['id_produk'];

    // Delete the image from the server
    $result = mysqli_query($conn, "SELECT gambar_url FROM produk WHERE id_produk = $id_produk");
    $row = mysqli_fetch_assoc($result);
    unlink("uploads/" . $row['gambar_url']);

    // Delete the product from the database
    $sql = "DELETE FROM produk WHERE id_produk = $id_produk";
    if (mysqli_query($conn, $sql)) {
        header("Location: admin.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
