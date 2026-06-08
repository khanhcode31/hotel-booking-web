<?php
// process_room.php
session_start();
require_once 'config/database.php';

// 1. XỬ LÝ THÊM PHÒNG MỚI (Method POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $room_number = trim($_POST['room_number']);
    $room_type = trim($_POST['room_type']);
    $price = (float)$_POST['price'];
    $img = trim($_POST['img']);

    try {
        $sql = "INSERT INTO rooms (room_number, room_type, price, img, status) 
                VALUES (:room_number, :room_type, :price, :img, 'available')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':room_number' => $room_number,
            ':room_type' => $room_type,
            ':price' => $price,
            ':img' => $img
        ]);
        
        echo "<script>alert('Thêm phòng mới thành công!'); window.location.href='admin_rooms.php';</script>";
        exit();
    } catch (PDOException $e) {
        // Bắt lỗi trùng số phòng
        if ($e->getCode() == 23000) {
            die("<script>alert('Lỗi: Số phòng này đã tồn tại!'); window.history.back();</script>");
        }
        die("Lỗi hệ thống: " . $e->getMessage());
    }
}

// 2. XỬ LÝ ẨN/MỞ LẠI PHÒNG (Method GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = (int)$_GET['id'];
    $new_status = '';

    if ($action === 'hide') {
        $new_status = 'hidden';
    } elseif ($action === 'show') {
        $new_status = 'available';
    } else {
        header("Location: admin_rooms.php");
        exit();
    }

    try {
        $sql = "UPDATE rooms SET status = :status WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':status' => $new_status, ':id' => $id]);
        
        header("Location: admin_rooms.php");
        exit();
    } catch (PDOException $e) {
        die("Lỗi cập nhật trạng thái phòng: " . $e->getMessage());
    }
}
?>