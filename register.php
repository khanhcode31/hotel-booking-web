<?php
// register.php
require_once 'config/database.php';
require_once 'cotrollers/AuthController.php';

$authController = new AuthController($pdo);
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $sdt = trim($_POST['sdt']);
    $address = trim($_POST['address']);
    $password = trim($_POST['password']);

    $result = $authController->register($fullname, $email, $sdt, $address, $password);

    if (is_array($result) && $result['status'] === 'success') {
        // Khởi động session để chuyển thông tin sang trang OTP
        if (session_status() == PHP_SESSION_NONE) { session_start(); }
        $_SESSION['verify_email'] = $result['email'];
        $_SESSION['mock_otp'] = $result['otp']; // Lưu tạm mã OTP để hiển thị ra màn hình cho bạn test dễ dàng
        
        header("Location: verify.php");
        exit();
    } else {
        $error = $result;
    }
}

require_once 'views/register.php';
?>