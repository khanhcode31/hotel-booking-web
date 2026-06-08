<?php
// process_verify_booking.php
session_start();
require_once 'config/database.php';

$action = isset($_GET['action']) ? trim($_GET['action']) : '';
$booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;

if ($booking_id <= 0 || !in_array($action, ['approve', 'cancel'])) {
    header("Location: admin_bookings.php");
    exit();
}

try {
    // Lấy thông tin room_id từ booking trước để xử lý cập nhật trạng thái phòng kèm theo
    $roomQuery = $pdo->prepare("SELECT room_id FROM bookings WHERE id = :id");
    $roomQuery->execute([':id' => $booking_id]);
    $bookingData = $roomQuery->fetch(PDO::FETCH_ASSOC);

    if (!$bookingData) {
        die("Đơn hàng không tồn tại trên hệ thống.");
    }

    $room_id = $bookingData['room_id'];

    if ($action === 'approve') {
        // 1. Duyệt đơn hàng thành công
        $updateBooking = $pdo->prepare("UPDATE bookings SET status = 'confirmed' WHERE id = :id");
        $updateBooking->execute([':id' => $booking_id]);

        // 2. Chuyển trạng thái phòng sang 'booked' để khóa phòng
        $updateRoom = $pdo->prepare("UPDATE rooms SET status = 'booked' WHERE id = :room_id");
        $updateRoom->execute([':room_id' => $room_id]);

        echo "<script>alert('Duyệt đơn đặt phòng thành công!'); window.location.href='admin_bookings.php';</script>";
        exit();

    } elseif ($action === 'cancel') {
        // 1. Hủy đơn hàng đặt phòng
        $updateBooking = $pdo->prepare("UPDATE bookings SET status = 'cancelled' WHERE id = :id");
        $updateBooking->execute([':id' => $booking_id]);

        // 2. Trả trạng thái phòng về lại 'available' (phòng trống) để khách khác có thể tìm thấy
        $updateRoom = $pdo->prepare("UPDATE rooms SET status = 'available' WHERE id = :room_id");
        $updateRoom->execute([':room_id' => $room_id]);

        echo "<script>alert('Đã hủy đơn đặt phòng thành công!'); window.location.href='admin_bookings.php';</script>";
        exit();
    }

} catch (PDOException $e) {
    error_log("Lỗi xử lý duyệt phòng: " . $e->getMessage());
    die("Hệ thống gặp sự cố khi cập nhật trạng thái dữ liệu.");
}
?>