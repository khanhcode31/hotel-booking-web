<?php
// booking.php
session_start();
require_once 'config/database.php';

// 1. Ràng buộc: Bắt buộc đăng nhập mới được vào trang điền thông tin đặt phòng
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 2. ĐÃ SỬA LỖI TYPO: Có dấu gạch dưới ở $_GET
$room_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
    // 3. Truy vấn lấy thông tin chi tiết của phòng này
    $sql = "SELECT id, room_number, room_type, price, img FROM rooms WHERE id = :id AND status = 'available' LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $room_id]);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    // Nếu không tìm thấy phòng hoặc phòng đang không ở trạng thái sẵn sàng
    if (!$room) {
        die("<script>alert('Phòng không tồn tại hoặc đã có khách đặt! Vui lòng chọn phòng khác.'); window.location.href='index.php';</script>");
    }

} catch (PDOException $e) {
    error_log("Lỗi tải trang chi tiết đặt phòng: " . $e->getMessage());
    die("Hệ thống gặp sự cố, vui lòng thử lại sau.");
}

// Gọi giao diện hiển thị
require_once 'views/booking.php';
?>