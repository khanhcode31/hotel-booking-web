<?php
// confirm_payment.php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = (int)$_POST['booking_id'];
    $amount = (float)$_POST['amount'];
    $content = trim($_POST['content']);

    try {
        // Lưu thông tin hóa đơn chuyển khoản vào bảng bills theo thiết kế dữ liệu mới
        $sql = "INSERT INTO bills (booking_id, payment_method, amount, content) 
                VALUES (:booking_id, 'bank_transfer', :amount, :content)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':booking_id' => $booking_id,
            ':amount' => $amount,
            ':content' => $content
        ]);

        // Thông báo cho khách đơn hàng đang chờ duyệt
        echo "<script>
                alert('Hệ thống đã nhận thông báo chuyển khoản của bạn. Admin sẽ kiểm tra tài khoản và xác nhận đơn đặt phòng thành công trong giây lát!');
                window.location.href = 'index.php';
              </script>";
        exit();

    } catch (PDOException $e) {
        error_log("Lỗi tạo hóa đơn thanh toán: " . $e->getMessage());
        die("Lỗi hệ thống.");
    }
}
?>