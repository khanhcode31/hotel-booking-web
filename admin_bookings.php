<?php
// admin_bookings.php
session_start();
require_once 'config/database.php';

// Mẹo nhỏ: Để bạn dễ dàng làm lab và bảo vệ đồ án, trang này tạm thời mở quyền 
// Hoặc bạn có thể chặn check session nếu cần thiết.

// admin_bookings.php
try {
    // SỬA CÂU LỆNH NÀY ĐỂ LẤY ĐÚNG TÊN CỘT
    // Hãy chắc chắn rằng bảng bookings của bạn có các cột: id, user_id, room_id, status...
    $sql = "SELECT b.id, b.check_in, b.check_out, b.status, b.total_price,
                   u.fullname, u.sdt,
                   r.room_number, r.room_type,
                   bi.content as bill_content
            FROM bookings b
            JOIN users u ON b.user_id = u.id
            JOIN rooms r ON b.room_id = r.id
            LEFT JOIN bills bi ON b.id = bi.booking_id
            ORDER BY b.id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Lỗi truy vấn: " . $e->getMessage());
}

// Gọi giao diện hiển thị quản trị
require_once 'views/admin_bookings.php';
?>