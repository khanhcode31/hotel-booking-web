<?php
// index.php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
require_once 'config/database.php';

try {
    // 1. Lấy danh sách các Loại phòng hiện có để hiển thị lên thanh chọn (ComboBox)
    $typeQuery = $pdo->query("SELECT DISTINCT room_type FROM rooms WHERE status != 'hidden'");
    $roomTypes = $typeQuery->fetchAll(PDO::FETCH_COLUMN);

    // 2. Thu thập dữ liệu tìm kiếm từ URL (Phương thức GET)
    $search_type = isset($_GET['room_type']) ? trim($_GET['room_type']) : '';
    $check_in = isset($_GET['check_in']) ? trim($_GET['check_in']) : '';
    $check_out = isset($_GET['check_out']) ? trim($_GET['check_out']) : '';

    // 3. Xây dựng câu lệnh SQL lọc phòng trống nâng cao
    $sql = "SELECT id, room_number, room_type, price, img FROM rooms WHERE status = :status";
    $params = [':status' => 'available'];

    // Lọc theo loại phòng nếu khách có chọn
    if (!empty($search_type)) {
        $sql .= " AND room_type = :room_type";
        $params[':room_type'] = $search_type;
    }

    // Thuật toán kiểm tra trùng lịch đặt phòng (Overlap Booking)
    if (!empty($check_in) && !empty($check_out)) {
        $sql .= " AND id NOT IN (
            SELECT room_id FROM bookings 
            WHERE status IN ('pending', 'confirmed') 
            AND NOT (check_out <= :check_in OR check_in >= :check_out)
        )";
        $params[':check_in'] = $check_in;
        $params[':check_out'] = $check_out;
    }

    $sql .= " LIMIT 6";
    
    // Execute câu lệnh an toàn chống SQL Injection
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Lỗi truy vấn trang chủ: " . $e->getMessage());
    $rooms = [];
    $roomTypes = [];
}

// Gọi giao diện hiển thị
require_once 'views/home.php';
?>