<?php
// process_booking.php
session_start();
require_once 'config/database.php';

// 1. Kiểm tra xem khách hàng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    // Nếu chưa đăng nhập, bắt buộc chuyển hướng sang trang login
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $room_id = (int)$_POST['room_id'];
    $price_per_night = (float)$_POST['price_per_night'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    // 2. Tính toán số ngày ở theo công thức ràng buộc trong đồ án
    $date1 = new DateTime($check_in);
    $date2 = new DateTime($check_out);
    $interval = $date1->diff($date2);
    $days = $interval->days;

    // Ràng buộc: Ngày trả phòng phải sau ngày nhận phòng ít nhất 1 ngày
    if ($date2 <= $date1 || $days < 1) {
        die("Lỗi: Ngày trả phòng phải sau ngày nhận phòng ít nhất 1 ngày. Vui lòng quay lại thử lại.");
    }

    // 3. Tính tổng tiền đặt phòng = Số ngày ở * Giá phòng/Ngày
    $total_price = $days * $price_per_night;

    try {
        // 4. Lưu thông tin vào bảng bookings (Trạng thái mặc định là 'pending')
        $sql = "INSERT INTO bookings (user_id, room_id, check_in, check_out, status, total_price) 
                VALUES (:user_id, :room_id, :check_in, :check_out, 'pending', :total_price)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':room_id' => $room_id,
            ':check_in' => $check_in,
            ':check_out' => $check_out,
            ':total_price' => $total_price
        ]);

        // Lấy mã đơn đặt phòng (id) vừa sinh ra
        $booking_id = $pdo->lastInsertId();

        // 5. Chuyển hướng sang trang thanh toán QR kèm mã đơn hàng
        header("Location: payment.php?booking_id=" . $booking_id);
        exit();

    } catch (PDOException $e) {
        error_log("Lỗi lưu đơn đặt phòng: " . $e->getMessage());
        die("Hệ thống gặp sự cố khi xử lý đơn đặt phòng. Vui lòng thử lại sau.");
    }
} else {
    header("Location: index.php");
    exit();
}
?>