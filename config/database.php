<?php
// config/database.php

$host = 'localhost';
$dbname = 'dat_phong_ks'; // Tên database của bạn
$username = 'root';
$password = '';

try {
    // Kết nối bằng PDO, thiết lập charset UTF-8 để không lỗi font tiếng Việt
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Bật chế độ báo lỗi exception để dễ debug
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // Nếu lỗi, ghi log hệ thống và dừng chương trình
    die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
}
?>