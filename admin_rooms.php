<?php
// admin_rooms.php
session_start();
require_once 'config/database.php';

try {
    // Lấy toàn bộ danh sách phòng, sắp xếp phòng mới thêm lên đầu
    $stmt = $pdo->query("SELECT * FROM rooms ORDER BY id DESC");
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Lỗi tải danh sách phòng: " . $e->getMessage());
    $rooms = [];
}

// Gọi giao diện
require_once 'views/admin_rooms.php';
?>