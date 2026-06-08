<?php
// verify.php
require_once 'config/database.php';
require_once 'cotrollers/AuthController.php';

if (session_status() == PHP_SESSION_NONE) { session_start(); }

// Nếu không có thông tin email cần xác thực thì đẩy về trang đăng ký
if (!isset($_SESSION['verify_email'])) {
    header("Location: register.php");
    exit();
}

$authController = new AuthController($pdo);
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otpInput = trim($_POST['otp_code']);
    $email = $_SESSION['verify_email'];

    $isVerified = $authController->verifyOtp($email, $otpInput);

    if ($isVerified) {
        // Xóa các session rác sau khi kích hoạt thành công
        unset($_SESSION['verify_email']);
        unset($_SESSION['mock_otp']);
        
        // Chuyển hướng thẳng sang trang đăng nhập kèm thông báo
        header("Location: login.php?msg=activated");
        exit();
    } else {
        $error = "Mã OTP sai hoặc đã hết hạn!";
    }
}

require_once 'views/verify.php';
?>