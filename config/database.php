<?php
// File: config/database.php
$host = "localhost";
$user = "root";
$pass = ""; // Nếu dùng XAMPP thì để trống
$dbname = "dat_phong_ks";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Giúp hiển thị tiếng Việt trên web không bị lỗi
mysqli_set_charset($conn, "utf8");
?>