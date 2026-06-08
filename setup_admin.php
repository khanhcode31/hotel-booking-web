<?php
// setup_admin.php
require_once 'config/database.php';

$email = 'admin@hotel.com'; // Đặt định dạng email để lọt qua form HTML5
$password = 'hugeooo';

// Mã hóa mật khẩu chuẩn Bcrypt
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

try {
    // Thêm trực tiếp vào DB: Đã kích hoạt (is_verified = 1) và Quyền (role = 'admin')
    $sql = "INSERT INTO users (fullname, email, sdt, address, password, is_verified, role) 
            VALUES ('Quản trị viên', :email, '0000000000', 'Phòng Máy Chủ', :password, 1, 'admin')";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email' => $email,
        ':password' => $hashedPassword
    ]);
    
    echo "<h2 style='color: green;'>✅ TẠO TÀI KHOẢN ADMIN THÀNH CÔNG!</h2>";
    echo "<p><b>Tài khoản:</b> admin@hotel.com</p>";
    echo "<p><b>Mật khẩu:</b> hugeooo</p>";
    echo "<a href='login.php' style='padding:10px; background:#6399F7; color:white; text-decoration:none; border-radius:5px;'>Đến trang Đăng nhập</a>";

} catch (PDOException $e) {
    // Bắt lỗi nếu bạn chạy file này lần thứ 2 (bị trùng email)
    if ($e->getCode() == 23000) {
        echo "<h2 style='color: orange;'>⚠️ Tài khoản admin@hotel.com đã tồn tại trong hệ thống!</h2>";
        echo "<a href='login.php'>Đến trang Đăng nhập</a>";
    } else {
        echo "Lỗi: " . $e->getMessage();
    }
}
?>