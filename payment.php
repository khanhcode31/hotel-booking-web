<?php
// payment.php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;

try {
    // Lấy chi tiết đơn hàng cùng số phòng để hiển thị lên hóa đơn thanh toán
    $sql = "SELECT b.*, r.room_number 
            FROM bookings b
            JOIN rooms r ON b.room_id = r.id
            WHERE b.id = :booking_id AND b.user_id = :user_id";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':booking_id' => $booking_id,
        ':user_id' => $_SESSION['user_id']
    ]);
    
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$booking) {
        die("Đơn đặt phòng không tồn tại hoặc bạn không có quyền truy cập.");
    }

} catch (PDOException $e) {
    error_log("Lỗi tải trang thanh toán: " . $e->getMessage());
    die("Lỗi hệ thống.");
}

// Gọi giao diện hiển thị QR thanh toán
require_once 'views/payment.php';
?>